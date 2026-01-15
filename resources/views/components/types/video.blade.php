@php
    $url = $content['url'] ?? '';
    $title = $content['title'] ?? '';
@endphp

<section class="py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            @if($title)
                <h2 class="text-3xl font-bold text-center mb-8 text-gray-800">
                    {{ $title }}
                </h2>
            @endif
            
            @if($url)
                <div class="relative pb-[56.25%] h-0 overflow-hidden rounded-lg shadow-lg">
                    <iframe src="{{ $url }}" 
                            class="absolute top-0 left-0 w-full h-full"
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen>
                    </iframe>
                </div>
            @else
                <div class="bg-gray-200 rounded-lg h-64 flex items-center justify-center">
                    <span class="text-gray-400">URL de video no disponible</span>
                </div>
            @endif
        </div>
    </div>
</section>
