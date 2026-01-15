<?php

namespace App\Livewire;

use Livewire\Component;

class WebTypeSelector extends Component
{
    public $selectedType = null;
    
    public $webTypes = [
        'landing' => [
            'name' => 'Landing Page',
            'description' => 'Página de aterrizaje para captar leads, promocionar producto o servicio',
            'icon' => '🎯',
            'examples' => 'Lanzamiento de producto, campaña marketing, evento',
            'recommended_structure' => ['full_width', 'landing'],
        ],
        'portfolio' => [
            'name' => 'Portafolio',
            'description' => 'Muestra tus trabajos, proyectos y habilidades profesionales',
            'icon' => '🎨',
            'examples' => 'Diseñador, fotógrafo, artista, desarrollador',
            'recommended_structure' => ['full_width', 'sidebar_left'],
        ],
        'blog' => [
            'name' => 'Blog / Contenido',
            'description' => 'Publica artículos, noticias y contenido regularmente',
            'icon' => '📝',
            'examples' => 'Blog personal, revista digital, noticias',
            'recommended_structure' => ['sidebar_right', 'sidebar_left'],
        ],
        'business' => [
            'name' => 'Sitio Empresarial',
            'description' => 'Web corporativa para tu empresa o negocio',
            'icon' => '🏢',
            'examples' => 'Empresa, agencia, consultoría, servicios profesionales',
            'recommended_structure' => ['full_width', 'sidebar_left'],
        ],
        'shop' => [
            'name' => 'Tienda Online',
            'description' => 'Vende productos con carrito de compras y gestión de pedidos',
            'icon' => '🛒',
            'examples' => 'E-commerce, tienda virtual, marketplace',
            'recommended_structure' => ['sidebar_left', 'full_width'],
            'has_cart' => true,
        ],
        'restaurant' => [
            'name' => 'Restaurante / Local',
            'description' => 'Menú, galería de productos, reservas y contacto',
            'icon' => '🍽️',
            'examples' => 'Restaurante, cafetería, bar, food truck',
            'recommended_structure' => ['full_width', 'two_columns'],
        ],
        'services' => [
            'name' => 'Servicios Profesionales',
            'description' => 'Presenta tus servicios, precios y testimonios',
            'icon' => '💼',
            'examples' => 'Consultor, freelancer, servicios profesionales',
            'recommended_structure' => ['full_width', 'sidebar_right'],
        ],
        'personal' => [
            'name' => 'Web Personal',
            'description' => 'Sitio minimalista sobre ti, tu CV o tarjeta de presentación',
            'icon' => '👤',
            'examples' => 'CV online, tarjeta personal, perfil profesional',
            'recommended_structure' => ['full_width', 'landing'],
        ],
    ];
    
    public function selectType($type)
    {
        $this->selectedType = $type;
    }
    
    public function continue()
    {
        if (!$this->selectedType) {
            return;
        }
        
        return redirect()->route('page.create.layout', ['type' => $this->selectedType]);
    }
    
    public function render()
    {
        return view('livewire.web-type-selector')
            ->layout('layouts.editor');
    }
}
