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
    public $selectedRow = null;
    public $selectedCols = []; // Array de columnas seleccionadas tipo checkbox
    public $gridRows = 1; // Empezar con 1 fila
    public $gridCols = 12;
    public $showComponentMenu = false;
    
    public function mount(Page $page)
    {
        $this->page = $page->load('components');
        
        // Inicializar grid si no existe
        if (!isset($this->page->meta_tags['grid_layout'])) {
            $this->page->update([
                'meta_tags' => array_merge($this->page->meta_tags ?? [], [
                    'grid_layout' => [],
                ])
            ]);
        }
    }
    
    public function selectCell($row, $col)
    {
        // Si cambia de fila, reiniciar selección
        if ($this->selectedRow !== null && $this->selectedRow != $row) {
            $this->selectedRow = $row;
            $this->selectedCols = [$col];
            return;
        }
        
        $this->selectedRow = $row;
        
        // Toggle checkbox style
        if (in_array($col, $this->selectedCols)) {
            // Deseleccionar
            $this->selectedCols = array_values(array_filter($this->selectedCols, fn($c) => $c != $col));
        } else {
            // Seleccionar
            $this->selectedCols[] = $col;
            sort($this->selectedCols);
        }
    }
    
    public function confirmSelection()
    {
        if (empty($this->selectedCols)) {
            return;
        }
        
        // Validar que sean consecutivas
        sort($this->selectedCols);
        for ($i = 0; $i < count($this->selectedCols) - 1; $i++) {
            if ($this->selectedCols[$i + 1] - $this->selectedCols[$i] != 1) {
                // No son consecutivas, mostrar error
                session()->flash('error', 'Las columnas deben ser consecutivas');
                return;
            }
        }
        
        $this->showComponentMenu = true;
    }
    
    public function cancelSelection()
    {
        $this->selectedRow = null;
        $this->selectedCols = [];
        $this->showComponentMenu = false;
    }
    
    public function addComponentToCell($type)
    {
        if (empty($this->selectedCols) || $this->selectedRow === null) return;
        
        sort($this->selectedCols);
        $row = $this->selectedRow;
        $col = $this->selectedCols[0];
        $colspan = count($this->selectedCols);
        
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
        $this->selectedRow = null;
        $this->selectedCols = [];
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
    }
    
    public function removeRow()
    {
        if ($this->gridRows > 1) {
            $this->gridRows--;
        }
    }
    
    public function render()
    {
        return view('livewire.page-editor')
            ->layout('layouts.editor');
    }
}
