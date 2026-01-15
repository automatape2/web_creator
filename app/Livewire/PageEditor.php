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
    
    public function mount(Page $page)
    {
        $this->page = $page->load('components');
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
    
    public function render()
    {
        return view('livewire.page-editor')
            ->layout('layouts.editor');
    }
}
