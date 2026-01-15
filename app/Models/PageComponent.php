<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PageComponent extends Model
{
    protected $fillable = [
        'page_id',
        'type',
        'content',
        'settings',
        'order',
    ];

    protected $casts = [
        'content' => 'array',
        'settings' => 'array',
    ];

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    // Tipos de componentes disponibles
    public static function getAvailableTypes(): array
    {
        return [
            'hero' => 'Sección Hero',
            'text' => 'Texto',
            'image' => 'Imagen',
            'gallery' => 'Galería',
            'video' => 'Video',
            'contact_form' => 'Formulario de Contacto',
            'features' => 'Características',
            'testimonials' => 'Testimonios',
            'pricing' => 'Precios',
            'faq' => 'Preguntas Frecuentes',
            'cta' => 'Llamada a la Acción',
        ];
    }
}
