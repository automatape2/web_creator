@php
    $url = $content['url'] ?? '';
    $alt = $content['alt'] ?? 'Imagen';
    $width = $settings['width'] ?? 'full';
@endphp

<section class="py-8">
    <div class="container mx-auto px-4">
        <div class="max-w-{{ $width === 'full' ? 'full' : '4xl' }} mx-auto">
            @if($url)
                <img src="{{ $url }}" 
                     alt="{{ $alt }}" 
                     class="w-full h-auto rounded-lg shadow-lg">
            @else
                <div class="bg-gray-200 rounded-lg h-64 flex items-center justify-center">
                    <span class="text-gray-400">Imagen no disponible</span>
                </div>
            @endif
        </div>
    </div>
</section>
