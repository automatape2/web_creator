<?php

namespace Database\Seeders;

use App\Models\Template;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $templates = [
            [
                'name' => 'Landing Page Moderna',
                'description' => 'Plantilla perfecta para promocionar productos o servicios con un diseño moderno y atractivo',
                'structure' => [
                    [
                        'type' => 'hero',
                        'content' => [
                            'title' => 'Transforma tu Negocio Digital',
                            'subtitle' => 'Crea páginas web impresionantes con nuestra plataforma impulsada por IA',
                            'cta_text' => 'Comenzar Gratis',
                        ],
                        'settings' => [
                            'background' => 'gradient',
                            'text_align' => 'center',
                        ],
                        'order' => 0,
                    ],
                    [
                        'type' => 'features',
                        'content' => [
                            'title' => '¿Por qué elegirnos?',
                            'items' => [
                                ['title' => 'Fácil de Usar', 'icon' => 'check', 'description' => 'Interfaz intuitiva sin necesidad de código'],
                                ['title' => 'Potenciado por IA', 'icon' => 'lightning', 'description' => 'Genera contenido automáticamente'],
                                ['title' => 'Totalmente Personalizable', 'icon' => 'shield', 'description' => 'Controla cada aspecto de tu diseño'],
                            ],
                        ],
                        'settings' => [
                            'columns' => '3',
                            'style' => 'cards',
                        ],
                        'order' => 1,
                    ],
                    [
                        'type' => 'cta',
                        'content' => [
                            'title' => '¿Listo para crear tu página?',
                            'subtitle' => 'Únete a miles de usuarios que ya confían en nosotros',
                            'button_text' => 'Empezar Ahora',
                        ],
                        'settings' => [
                            'background' => 'primary',
                        ],
                        'order' => 2,
                    ],
                ],
                'default_styles' => [
                    'primary-color' => '#667eea',
                    'secondary-color' => '#764ba2',
                    'font-family' => 'Inter, sans-serif',
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Portfolio Profesional',
                'description' => 'Muestra tu trabajo de manera elegante con esta plantilla de portfolio',
                'structure' => [
                    [
                        'type' => 'hero',
                        'content' => [
                            'title' => 'Diseñador Creativo',
                            'subtitle' => 'Creando experiencias digitales únicas',
                        ],
                        'settings' => [
                            'style' => 'minimal',
                        ],
                        'order' => 0,
                    ],
                    [
                        'type' => 'gallery',
                        'content' => [
                            'title' => 'Mis Proyectos',
                            'items' => [],
                        ],
                        'settings' => [
                            'layout' => 'grid',
                            'columns' => '3',
                        ],
                        'order' => 1,
                    ],
                    [
                        'type' => 'contact_form',
                        'content' => [
                            'title' => 'Trabajemos Juntos',
                            'fields' => ['name', 'email', 'message'],
                            'button_text' => 'Enviar Mensaje',
                        ],
                        'settings' => [],
                        'order' => 2,
                    ],
                ],
                'default_styles' => [
                    'primary-color' => '#000000',
                    'secondary-color' => '#ffffff',
                    'font-family' => 'Helvetica, Arial, sans-serif',
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Página de Producto',
                'description' => 'Destaca tu producto con esta plantilla enfocada en conversión',
                'structure' => [
                    [
                        'type' => 'hero',
                        'content' => [
                            'title' => 'El Producto que Necesitas',
                            'subtitle' => 'Aumenta tu productividad al máximo',
                            'cta_text' => 'Comprar Ahora',
                        ],
                        'settings' => [
                            'background' => 'gradient',
                        ],
                        'order' => 0,
                    ],
                    [
                        'type' => 'features',
                        'content' => [
                            'title' => 'Características Principales',
                            'items' => [
                                ['title' => 'Rápido', 'icon' => 'lightning'],
                                ['title' => 'Seguro', 'icon' => 'shield'],
                                ['title' => 'Confiable', 'icon' => 'check'],
                            ],
                        ],
                        'settings' => [
                            'columns' => '3',
                        ],
                        'order' => 1,
                    ],
                    [
                        'type' => 'pricing',
                        'content' => [
                            'title' => 'Planes y Precios',
                            'items' => [
                                [
                                    'name' => 'Básico',
                                    'price' => '9',
                                    'period' => 'mes',
                                    'features' => ['Característica 1', 'Característica 2'],
                                    'cta' => 'Empezar',
                                ],
                                [
                                    'name' => 'Pro',
                                    'price' => '29',
                                    'period' => 'mes',
                                    'featured' => true,
                                    'features' => ['Todo en Básico', 'Característica 3', 'Característica 4'],
                                    'cta' => 'Empezar',
                                ],
                            ],
                        ],
                        'settings' => [],
                        'order' => 2,
                    ],
                ],
                'default_styles' => [
                    'primary-color' => '#3b82f6',
                    'secondary-color' => '#1e40af',
                ],
                'is_active' => true,
            ],
        ];

        foreach ($templates as $template) {
            Template::create($template);
        }
    }
}
