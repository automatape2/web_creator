@php
    $title = $content['title'] ?? 'Planes y Precios';
    $items = $content['items'] ?? [];
@endphp

<section class="py-16">
    <div class="container mx-auto px-4">
        @if($title)
            <h2 class="text-4xl font-bold text-center mb-12 text-gray-800">
                {{ $title }}
            </h2>
        @endif
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
            @foreach($items as $index => $item)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden {{ isset($item['featured']) && $item['featured'] ? 'ring-2 ring-purple-600 transform scale-105' : '' }}">
                    @if(isset($item['featured']) && $item['featured'])
                        <div class="bg-purple-600 text-white text-center py-2 text-sm font-semibold">
                            Más Popular
                        </div>
                    @endif
                    
                    <div class="p-8">
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">
                            {{ $item['name'] ?? 'Plan ' . ($index + 1) }}
                        </h3>
                        
                        <div class="mb-6">
                            <span class="text-5xl font-bold text-gray-800">
                                {{ $item['currency'] ?? '$' }}{{ $item['price'] ?? '0' }}
                            </span>
                            <span class="text-gray-600">
                                /{{ $item['period'] ?? 'mes' }}
                            </span>
                        </div>
                        
                        @if(isset($item['description']))
                            <p class="text-gray-600 mb-6">
                                {{ $item['description'] }}
                            </p>
                        @endif
                        
                        @if(isset($item['features']))
                            <ul class="mb-8 space-y-3">
                                @foreach($item['features'] as $feature)
                                    <li class="flex items-center text-gray-700">
                                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $feature }}
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                        
                        <button class="w-full {{ isset($item['featured']) && $item['featured'] ? 'bg-purple-600 hover:bg-purple-700' : 'bg-gray-800 hover:bg-gray-900' }} text-white py-3 rounded-lg font-semibold transition duration-200">
                            {{ $item['cta'] ?? 'Seleccionar Plan' }}
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
