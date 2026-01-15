<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-12">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-5xl font-bold text-gray-900 mb-4">¿Qué tipo de web quieres crear?</h1>
            <p class="text-xl text-gray-600">Paso 1 de 3: Selecciona la intención de tu página</p>
        </div>

        <!-- Web Types Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            @foreach($webTypes as $key => $type)
            <button wire:click="selectType('{{ $key }}')" 
                    class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all p-6 text-center border-4 {{ $selectedType === $key ? 'border-blue-500 ring-4 ring-blue-200' : 'border-transparent hover:border-blue-300' }} group transform hover:scale-105">
                
                <div class="text-6xl mb-4">{{ $type['icon'] }}</div>
                
                <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-blue-600">
                    {{ $type['name'] }}
                    @if(isset($type['has_cart']) && $type['has_cart'])
                        <span class="ml-1 text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full">+ Carrito</span>
                    @endif
                </h3>
                
                <p class="text-sm text-gray-600 mb-4">{{ $type['description'] }}</p>
                
                <div class="pt-4 border-t border-gray-200">
                    <p class="text-xs text-gray-500">
                        <strong>Ejemplos:</strong><br>
                        {{ $type['examples'] }}
                    </p>
                </div>
                
                @if($selectedType === $key)
                <div class="mt-4">
                    <span class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-700 text-sm font-semibold rounded-full">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        Seleccionado
                    </span>
                </div>
                @endif
            </button>
            @endforeach
        </div>
        
        <!-- Action Buttons -->
        <div class="flex items-center justify-center space-x-4">
            <a href="{{ route('filament.admin.resources.pages.index') }}" 
               class="px-6 py-3 text-gray-700 bg-white border-2 border-gray-300 rounded-lg hover:bg-gray-50 font-semibold transition-colors">
                ← Cancelar
            </a>
            
            @if($selectedType)
            <button wire:click="continue" 
                    class="px-8 py-3 bg-blue-600 text-white font-bold text-lg rounded-lg hover:bg-blue-700 transition-colors shadow-lg hover:shadow-xl">
                Continuar → Elegir Estructura
            </button>
            @else
            <button disabled 
                    class="px-8 py-3 bg-gray-300 text-gray-500 font-bold text-lg rounded-lg cursor-not-allowed">
                Selecciona un tipo primero
            </button>
            @endif
        </div>
        
        @if($selectedType)
        <div class="mt-8 text-center">
            <div class="inline-block bg-blue-50 border-2 border-blue-200 rounded-lg p-4">
                <p class="text-sm text-blue-800">
                    <strong>📋 Siguiente:</strong> Elegirás la estructura (header, sidebar, footer) para tu 
                    <span class="font-bold">{{ $webTypes[$selectedType]['name'] }}</span>
                </p>
            </div>
        </div>
        @endif
    </div>
</div>
