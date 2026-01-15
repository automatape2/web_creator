@php
    $title = $content['title'] ?? 'Preguntas Frecuentes';
    $items = $content['items'] ?? [];
@endphp

<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        @if($title)
            <h2 class="text-4xl font-bold text-center mb-12 text-gray-800">
                {{ $title }}
            </h2>
        @endif
        
        <div class="max-w-3xl mx-auto space-y-4" x-data="{ openIndex: null }">
            @foreach($items as $index => $item)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <button @click="openIndex = openIndex === {{ $index }} ? null : {{ $index }}"
                            class="w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 transition">
                        <span class="font-semibold text-gray-800">
                            {{ $item['question'] ?? 'Pregunta' }}
                        </span>
                        <svg class="w-5 h-5 text-gray-600 transform transition-transform"
                             :class="{ 'rotate-180': openIndex === {{ $index }} }"
                             fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                    
                    <div x-show="openIndex === {{ $index }}" 
                         x-collapse
                         class="px-6 pb-4 text-gray-600">
                        {{ $item['answer'] ?? 'Respuesta' }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
