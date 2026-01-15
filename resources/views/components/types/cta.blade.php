@php
    $title = $content['title'] ?? '¿Listo para empezar?';
    $subtitle = $content['subtitle'] ?? '';
    $buttonText = $content['button_text'] ?? 'Comenzar Ahora';
    $buttonUrl = $content['button_url'] ?? '#';
    $bgStyle = $settings['background'] ?? 'primary';
@endphp

<section class="py-20 {{ $bgStyle === 'primary' ? 'primary-bg' : 'gradient-bg' }} text-white">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto text-center">
            <h2 class="text-4xl font-bold mb-4">
                {{ $title }}
            </h2>
            
            @if($subtitle)
                <p class="text-xl mb-8 opacity-90">
                    {{ $subtitle }}
                </p>
            @endif
            
            <a href="{{ $buttonUrl }}" 
               class="inline-block bg-white text-purple-600 px-8 py-4 rounded-lg font-semibold text-lg hover:bg-gray-100 transition duration-200 shadow-lg">
                {{ $buttonText }}
            </a>
        </div>
    </div>
</section>
