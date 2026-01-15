<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Header -->
        <div class="text-center mb-12">
            @if($webType)
            <div class="mb-4">
                <span class="inline-block px-4 py-2 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold">
                    Tipo seleccionado: {{ ucfirst($webType) }}
                </span>
            </div>
            @endif
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Crear Nueva Página</h1>
            <p class="text-lg text-gray-600">Paso 2 de 3: Elige la estructura base de tu página (header, sidebar, footer, columnas)</p>
            <p class="text-sm text-gray-500 mt-2">💡 Podrás modificar todo después en el editor visual</p>
        </div>

        @if(!$selectedLayout)
        <!-- Layout Grid Selection -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($layouts as $key => $layout)
            <button wire:click="selectLayout('{{ $key }}')" 
                    class="bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow p-6 text-left border-2 border-transparent hover:border-blue-500 group">
                
                <!-- Visual Preview -->
                <div class="mb-4 h-32 bg-gray-100 rounded-lg p-4 flex items-center justify-center">
                    @if($layout['illustration'] === 'full')
                        <div class="w-full h-full border-2 border-gray-300 rounded"></div>
                    @elseif($layout['illustration'] === 'left')
                        <div class="w-full h-full flex gap-2">
                            <div class="w-1/4 bg-blue-200 rounded"></div>
                            <div class="flex-1 border-2 border-gray-300 rounded"></div>
                        </div>
                    @elseif($layout['illustration'] === 'right')
                        <div class="w-full h-full flex gap-2">
                            <div class="flex-1 border-2 border-gray-300 rounded"></div>
                            <div class="w-1/4 bg-blue-200 rounded"></div>
                        </div>
                    @elseif($layout['illustration'] === 'two')
                        <div class="w-full h-full flex gap-2">
                            <div class="flex-1 border-2 border-gray-300 rounded"></div>
                            <div class="flex-1 border-2 border-gray-300 rounded"></div>
                        </div>
                    @elseif($layout['illustration'] === 'three')
                        <div class="w-full h-full flex gap-2">
                            <div class="w-1/5 bg-blue-200 rounded"></div>
                            <div class="flex-1 border-2 border-gray-300 rounded"></div>
                            <div class="w-1/5 bg-blue-200 rounded"></div>
                        </div>
                    @elseif($layout['illustration'] === 'landing')
                        <div class="w-full h-full border-2 border-dashed border-gray-400 rounded"></div>
                    @endif
                </div>
                
                <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-blue-600">{{ $layout['name'] }}</h3>
                <p class="text-gray-600 mb-4">{{ $layout['description'] }}</p>
                
                <div class="space-y-1 text-sm">
                    @if($layout['structure']['header'])
                        <div class="flex items-center text-green-600">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            Header
                        </div>
                    @endif
                    
                    @if(isset($layout['structure']['sidebar']))
                        @if($layout['structure']['sidebar'] === 'left')
                            <div class="flex items-center text-blue-600">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                Sidebar Izquierdo
                            </div>
                        @elseif($layout['structure']['sidebar'] === 'right')
                            <div class="flex items-center text-blue-600">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                Sidebar Derecho
                            </div>
                        @endif
                    @endif
                    
                    @if(isset($layout['structure']['columns']))
                        <div class="flex items-center text-purple-600">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            {{ $layout['structure']['columns'] }} Columnas
                        </div>
                    @endif
                    
                    @if($layout['structure']['footer'])
                        <div class="flex items-center text-green-600">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            Footer
                        </div>
                    @endif
                </div>
            </button>
            @endforeach
        </div>
        
        <div class="mt-8 text-center">
            <a href="{{ route('filament.admin.resources.pages.index') }}" class="text-gray-600 hover:text-gray-900">
                ← Volver a mis páginas
            </a>
        </div>
        
        @else
        <!-- Page Details Form -->
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-lg shadow-md p-8">
                <div class="mb-6">
                    <button wire:click="$set('selectedLayout', null)" class="text-blue-600 hover:text-blue-700 flex items-center">
                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Cambiar modelo
                    </button>
                </div>
                
                <div class="mb-6">
                    <div class="flex items-center space-x-4 p-4 bg-blue-50 rounded-lg">
                        <div class="text-4xl">{{ $layouts[$selectedLayout]['preview'] }}</div>
                        <div>
                            <h3 class="font-bold text-gray-900">{{ $layouts[$selectedLayout]['name'] }}</h3>
                            <p class="text-sm text-gray-600">{{ $layouts[$selectedLayout]['description'] }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                Esta es la estructura base (header, sidebar, footer). En el siguiente paso agregarás el contenido (secciones, imágenes, texto, etc.).
                            </p>
                        </div>
                    </div>
                </div>
                
                <form wire:submit="createPage" class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Título de la página *</label>
                        <input type="text" 
                               wire:model="pageTitle" 
                               placeholder="Ej: Mi Portafolio"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               required>
                        @error('pageTitle') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Descripción (opcional)</label>
                        <textarea wire:model="pageDescription" 
                                  rows="3"
                                  placeholder="Breve descripción de tu página"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>
                    
                    <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                        <a href="{{ route('filament.admin.resources.pages.index') }}" class="text-gray-600 hover:text-gray-900">
                            Cancelar
                        </a>
                        <button type="submit" 
                                class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                            Crear Página →
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>
