@php
    $title = $content['title'] ?? 'Testimonios';
    $items = $content['items'] ?? [];
@endphp

<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        @if($title)
            <h2 class="text-4xl font-bold text-center mb-12 text-gray-800">
                {{ $title }}
            </h2>
        @endif
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
            @foreach($items as $item)
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="mb-4">
                        <svg class="w-8 h-8 text-purple-500" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                        </svg>
                    </div>
                    
                    <p class="text-gray-600 mb-4 italic">
                        "{{ $item['quote'] ?? 'Testimonio...' }}"
                    </p>
                    
                    <div class="flex items-center">
                        @if(isset($item['avatar']))
                            <img src="{{ $item['avatar'] }}" 
                                 alt="{{ $item['name'] ?? '' }}" 
                                 class="w-12 h-12 rounded-full mr-4">
                        @else
                            <div class="w-12 h-12 rounded-full bg-purple-500 text-white flex items-center justify-center mr-4 font-semibold">
                                {{ substr($item['name'] ?? '?', 0, 1) }}
                            </div>
                        @endif
                        
                        <div>
                            <p class="font-semibold text-gray-800">{{ $item['name'] ?? 'Anónimo' }}</p>
                            @if(isset($item['position']))
                                <p class="text-sm text-gray-500">{{ $item['position'] }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
