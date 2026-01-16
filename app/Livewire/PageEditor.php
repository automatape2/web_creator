<?php

namespace App\Livewire;

use App\Models\Page;
use App\Models\PageComponent;
use Livewire\Component;

class PageEditor extends Component
{
    public Page $page;
    public $editingComponent = null;
    public $componentContent = [];
    public $componentSettings = [];
    public $selectionStart = null; // ['row' => 1, 'col' => 1]
    public $selectionEnd = null; // ['row' => 2, 'col' => 3]
    public $isDragging = false;
    public $draggingComponent = null; // ID del componente siendo arrastrado
    public $dropTarget = null; // ID del componente sobre el que se está arrastrando
    public $gridRows = 1; // Empezar con 1 fila
    public $gridCols = 12;
    public $showComponentMenu = false;
    
    public function mount(Page $page)
    {
        $this->page = $page->load('components');
        
        // Cargar gridRows desde meta_tags o usar 1 por defecto
        $this->gridRows = $this->page->meta_tags['grid_rows'] ?? 1;
        
        // Inicializar grid si no existe
        if (!isset($this->page->meta_tags['grid_layout'])) {
            $this->page->update([
                'meta_tags' => array_merge($this->page->meta_tags ?? [], [
                    'grid_layout' => [],
                    'grid_rows' => 1,
                ])
            ]);
        }
    }
    
    public function startSelection($row, $col)
    {
        $this->selectionStart = ['row' => $row, 'col' => $col];
        $this->selectionEnd = ['row' => $row, 'col' => $col];
        $this->isDragging = true;
    }
    
    public function updateSelection($row, $col)
    {
        if ($this->isDragging && $this->selectionStart) {
            // Solo permitir selección horizontal (misma fila)
            $this->selectionEnd = ['row' => $this->selectionStart['row'], 'col' => $col];
        }
    }
    
    public function endSelection()
    {
        $this->isDragging = false;
        if ($this->selectionStart && $this->selectionEnd) {
            $this->showComponentMenu = true;
        }
    }
    
    public function cancelSelection()
    {
        $this->selectionStart = null;
        $this->selectionEnd = null;
        $this->isDragging = false;
        $this->showComponentMenu = false;
        $this->draggingComponent = null;
        $this->dropTarget = null;
    }
    
    public function startDragging($componentId)
    {
        $this->draggingComponent = $componentId;
    }
    
    public function setDropTarget($componentId)
    {
        $this->dropTarget = $componentId;
    }
    
    public function clearDropTarget()
    {
        $this->dropTarget = null;
    }
    
    public function swapComponents($componentId1, $componentId2)
    {
        if ($componentId1 == $componentId2) {
            $this->draggingComponent = null;
            $this->dropTarget = null;
            return;
        }
        
        $comp1 = PageComponent::find($componentId1);
        $comp2 = PageComponent::find($componentId2);
        
        if (!$comp1 || !$comp2) {
            $this->draggingComponent = null;
            $this->dropTarget = null;
            return;
        }
        
        $settings1 = $comp1->settings;
        $settings2 = $comp2->settings;
        
        // Intercambiar toda la posición (row, col, rowspan, colspan)
        $tempPosition = $settings1['grid_position'];
        $settings1['grid_position'] = $settings2['grid_position'];
        $settings2['grid_position'] = $tempPosition;
        
        $comp1->update(['settings' => $settings1]);
        $comp2->update(['settings' => $settings2]);
        
        $this->draggingComponent = null;
        $this->dropTarget = null;
        $this->page->refresh();
    }
    
    public function getSelectedArea()
    {
        if (!$this->selectionStart || !$this->selectionEnd) {
            return null;
        }
        
        return [
            'rowStart' => min($this->selectionStart['row'], $this->selectionEnd['row']),
            'rowEnd' => max($this->selectionStart['row'], $this->selectionEnd['row']),
            'colStart' => min($this->selectionStart['col'], $this->selectionEnd['col']),
            'colEnd' => max($this->selectionStart['col'], $this->selectionEnd['col']),
        ];
    }
    
    public function addComponentToCell($type)
    {
        $area = $this->getSelectedArea();
        if (!$area) return;
        
        $row = $area['rowStart'];
        $col = $area['colStart'];
        $colspan = ($area['colEnd'] - $area['colStart']) + 1;
        
        // Crear componente
        $component = PageComponent::create([
            'page_id' => $this->page->id,
            'type' => $type,
            'content' => $this->getDefaultContent($type),
            'settings' => [
                'grid_position' => [
                    'row' => $row,
                    'col' => $col,
                    'rowspan' => 1,
                    'colspan' => $colspan,
                ]
            ],
            'order' => $this->page->components->count(),
        ]);
        
        $this->page->refresh();
        $this->showComponentMenu = false;
        $this->selectionStart = null;
        $this->selectionEnd = null;
    }
    
    private function getDefaultContent($type)
    {
        $defaults = [
            'hero' => ['title' => 'Título Hero', 'subtitle' => 'Subtítulo'],
            'text' => ['title' => 'Título', 'content' => 'Contenido de texto...'],
            'image' => ['url' => 'https://via.placeholder.com/800x400'],
            'features' => ['title' => 'Características'],
            'gallery' => ['title' => 'Galería'],
            'video' => ['url' => ''],
            'contact_form' => ['title' => 'Contáctanos'],
            'testimonials' => ['title' => 'Testimonios'],
            'pricing' => ['title' => 'Precios'],
            'faq' => ['title' => 'Preguntas Frecuentes'],
            'cta' => ['title' => '¿Listo para empezar?', 'button_text' => 'Comenzar'],
        ];
        
        return $defaults[$type] ?? [];
    }
    
    public function editComponent($componentId)
    {
        $component = $this->page->components->find($componentId);
        if ($component) {
            $this->editingComponent = $componentId;
            $this->componentContent = $component->content ?? [];
            $this->componentSettings = $component->settings ?? [];
        }
    }
    
    public function saveComponent()
    {
        if ($this->editingComponent) {
            $component = PageComponent::find($this->editingComponent);
            $component->update([
                'content' => $this->componentContent,
                'settings' => $this->componentSettings,
            ]);
            
            $this->editingComponent = null;
            $this->page->refresh();
            
            $this->dispatch('component-saved');
        }
    }
    
    public function cancelEdit()
    {
        $this->editingComponent = null;
        $this->componentContent = [];
        $this->componentSettings = [];
    }
    
    public function addComponent($type, $afterComponentId = null)
    {
        $order = $afterComponentId 
            ? PageComponent::find($afterComponentId)->order + 1
            : $this->page->components->max('order') + 1;
        
        PageComponent::create([
            'page_id' => $this->page->id,
            'type' => $type,
            'content' => [],
            'settings' => [],
            'order' => $order,
        ]);
        
        $this->page->refresh();
    }
    
    public function deleteComponent($componentId)
    {
        PageComponent::find($componentId)->delete();
        $this->page->refresh();
    }
    
    public function reorderComponents($orderedIds)
    {
        foreach ($orderedIds as $index => $id) {
            PageComponent::find($id)->update(['order' => $index]);
        }
        
        $this->page->refresh();
    }
    
    public function togglePublish()
    {
        $this->page->update(['is_published' => !$this->page->is_published]);
        $this->page->refresh();
    }
    
    public function addRow()
    {
        $this->gridRows++;
        $this->page->update([
            'meta_tags' => array_merge($this->page->meta_tags ?? [], [
                'grid_rows' => $this->gridRows,
            ])
        ]);
    }
    
    public function removeRow()
    {
        if ($this->gridRows > 1) {
            $this->gridRows--;
            $this->page->update([
                'meta_tags' => array_merge($this->page->meta_tags ?? [], [
                    'grid_rows' => $this->gridRows,
                ])
            ]);
        }
    }
    
    public function render()
    {
        return view('livewire.page-editor')
            ->layout('layouts.editor');
    }
}
