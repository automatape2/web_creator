@php
    $content = $component->content ?? [];
    $settings = $component->settings ?? [];
@endphp

<div class="component-wrapper component-{{ $component->type }}" data-component-id="{{ $component->id }}">
    @switch($component->type)
        @case('hero')
            @include('components.types.hero', ['content' => $content, 'settings' => $settings])
            @break
        
        @case('text')
            @include('components.types.text', ['content' => $content, 'settings' => $settings])
            @break
        
        @case('image')
            @include('components.types.image', ['content' => $content, 'settings' => $settings])
            @break
        
        @case('gallery')
            @include('components.types.gallery', ['content' => $content, 'settings' => $settings])
            @break
        
        @case('video')
            @include('components.types.video', ['content' => $content, 'settings' => $settings])
            @break
        
        @case('contact_form')
            @include('components.types.contact-form', ['content' => $content, 'settings' => $settings])
            @break
        
        @case('features')
            @include('components.types.features', ['content' => $content, 'settings' => $settings])
            @break
        
        @case('testimonials')
            @include('components.types.testimonials', ['content' => $content, 'settings' => $settings])
            @break
        
        @case('pricing')
            @include('components.types.pricing', ['content' => $content, 'settings' => $settings])
            @break
        
        @case('faq')
            @include('components.types.faq', ['content' => $content, 'settings' => $settings])
            @break
        
        @case('cta')
            @include('components.types.cta', ['content' => $content, 'settings' => $settings])
            @break
        
        @default
            <div class="p-4 bg-gray-100 text-gray-500">
                Componente tipo "{{ $component->type }}" no implementado
            </div>
    @endswitch
</div>
