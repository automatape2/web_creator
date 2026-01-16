<?php

namespace App\Livewire;

use App\Models\Page;
use Livewire\Component;

class LayoutSelector extends Component
{
    public $selectedLayout = null;
    public $pageTitle = '';
    public $pageDescription = '';
    public $webType = null; // Tipo de web seleccionado en paso anterior
    
    public $layouts = [
        'full_width' => [
            'name' => 'Ancho Completo',
            'description' => 'Sin sidebar, contenido a todo el ancho',
            'preview' => '□',
            'structure' => ['header' => true, 'sidebar' => null, 'footer' => true],
            'illustration' => 'full',
        ],
        'sidebar_left' => [
            'name' => 'Sidebar Izquierdo',
            'description' => 'Menú/navegación en el lado izquierdo',
            'preview' => '▐□',
            'structure' => ['header' => true, 'sidebar' => 'left', 'footer' => true],
            'illustration' => 'left',
        ],
        'sidebar_right' => [
            'name' => 'Sidebar Derecho',
            'description' => 'Información adicional en el lado derecho',
            'preview' => '□▌',
            'structure' => ['header' => true, 'sidebar' => 'right', 'footer' => true],
            'illustration' => 'right',
        ],
        'two_columns' => [
            'name' => 'Dos Columnas',
            'description' => 'Contenido dividido en 2 columnas iguales',
            'preview' => '▐▌',
            'structure' => ['header' => true, 'columns' => 2, 'footer' => true],
            'illustration' => 'two',
        ],
        'three_columns' => [
            'name' => 'Tres Columnas',
            'description' => 'Layout con 3 columnas (sidebar + contenido + sidebar)',
            'preview' => '▐▐▌',
            'structure' => ['header' => true, 'columns' => 3, 'footer' => true],
            'illustration' => 'three',
        ],
        'landing' => [
            'name' => 'Landing Page',
            'description' => 'Sin header/footer, secciones a pantalla completa',
            'preview' => '▬',
            'structure' => ['header' => false, 'sidebar' => null, 'footer' => false],
            'illustration' => 'landing',
        ],
    ];
    
    public function mount()
    {
        $this->webType = request()->get('type');
    }
    
    public function selectLayout($layout)
    {
        $this->selectedLayout = $layout;
    }
    
    public function createPage()
    {
        $this->validate([
            'pageTitle' => 'required|min:3',
            'selectedLayout' => 'required',
        ]);
        
        // Crear la página con la estructura seleccionada
        $page = Page::create([
            'user_id' => auth()->id(),
            'title' => $this->pageTitle,
            'slug' => \Illuminate\Support\Str::slug($this->pageTitle),
            'description' => $this->pageDescription,
            'is_published' => false,
            'meta_tags' => [
                'web_type' => $this->webType,
                'layout_type' => $this->selectedLayout,
                'structure' => $this->layouts[$this->selectedLayout]['structure'],
                'has_cart' => $this->webType === 'shop',
                'grid_rows' => 10, // Inicializar con 10 filas
            ],
        ]);
        
        // Redirigir al editor visual
        return redirect()->route('page.edit', $page);
    }
    
    private function getDefaultContent($type)
    {
        $defaults = [
            'hero' => ['title' => $this->pageTitle, 'subtitle' => $this->pageDescription ?: 'Subtítulo aquí', 'cta_text' => 'Comenzar'],
            'features' => ['title' => 'Características'],
            'cta' => ['title' => '¿Listo para empezar?', 'button_text' => 'Contactar'],
            'text' => ['title' => 'Sección de Texto', 'content' => 'Escribe tu contenido aquí...'],
            'gallery' => ['title' => 'Galería'],
            'testimonials' => ['title' => 'Testimonios'],
            'contact_form' => ['title' => 'Contáctanos'],
            'pricing' => ['title' => 'Planes y Precios'],
            'faq' => ['title' => 'Preguntas Frecuentes'],
            'image' => ['title' => 'Imagen'],
            'video' => ['title' => 'Video'],
        ];
        
        return $defaults[$type] ?? [];
    }
    
    private function getDefaultSettings($type)
    {
        $defaults = [
            'hero' => ['background' => 'gradient', 'text_align' => 'center'],
            'features' => ['columns' => '3', 'style' => 'cards'],
            'gallery' => ['columns' => '3'],
        ];
        
        return $defaults[$type] ?? [];
    }
    
    public function render()
    {
        return view('livewire.layout-selector')
            ->layout('layouts.editor');
    }
}
