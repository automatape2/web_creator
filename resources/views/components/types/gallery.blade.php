@php
    $title = $content['title'] ?? 'Galería';
    $items = $content['items'] ?? [];
    $layout = $settings['layout'] ?? 'grid';
    $columns = $settings['columns'] ?? '3';
@endphp

<section class="py-16">
    <div class="container mx-auto px-4">
        @if($title)
            <h2 class="text-4xl font-bold text-center mb-12 text-gray-800">
                {{ $title }}
            </h2>
        @endif
        
        <div class="grid grid-cols-1 md:grid-cols-{{ $columns }} gap-6 max-w-6xl mx-auto">
            @forelse($items as $item)
                <div class="relative overflow-hidden rounded-lg shadow-md hover:shadow-xl transition duration-200">
                    @if(isset($item['image']))
                        <img src="{{ $item['image'] }}" 
                             alt="{{ $item['title'] ?? 'Galería' }}" 
                             class="w-full h-64 object-cover">
                    @else
                        <div class="bg-gray-300 h-64 flex items-center justify-center">
                            <span class="text-gray-500">Sin imagen</span>
                        </div>
                    @endif
                    
                    @if(isset($item['title']) || isset($item['description']))
                        <div class="p-4 bg-white">
                            @if(isset($item['title']))
                                <h3 class="font-semibold text-lg mb-2">{{ $item['title'] }}</h3>
                            @endif
                            
                            @if(isset($item['description']))
                                <p class="text-gray-600 text-sm">{{ $item['description'] }}</p>
                            @endif
                        </div>
                    @endif
                </div>
            @empty
                <div class="col-span-full text-center text-gray-500">
                    No hay elementos en la galería
                </div>
            @endforelse
        </div>
    </div>
</section>
