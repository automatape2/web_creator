<div class="min-h-screen bg-gray-50">
    <!-- Editor Toolbar -->
    <div class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 py-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('filament.admin.resources.pages.index') }}" class="text-gray-600 hover:text-gray-900">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                    </a>
                    <h1 class="text-xl font-semibold text-gray-900">{{ $page->title }}</h1>
                    <span class="px-2 py-1 text-xs rounded-full {{ $page->is_published ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ $page->is_published ? 'Publicada' : 'Borrador' }}
                    </span>
                </div>
                
                <div class="flex items-center space-x-2">
                    <button wire:click="togglePublish" class="px-4 py-2 text-sm font-medium text-white {{ $page->is_published ? 'bg-gray-600 hover:bg-gray-700' : 'bg-green-600 hover:bg-green-700' }} rounded-lg">
                        {{ $page->is_published ? 'Despublicar' : 'Publicar' }}
                    </button>
                    @if($page->is_published)
                    <a href="{{ route('page.show', $page->slug) }}" target="_blank" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                        Ver Pública
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Add Component Floating Button -->
    <div x-data="{ showMenu: false }" class="fixed bottom-6 right-6 z-40">
        <div x-show="showMenu" @click.away="showMenu = false" class="absolute bottom-16 right-0 w-64 bg-white rounded-lg shadow-lg border border-gray-200 max-h-96 overflow-y-auto">
            <div class="p-2">
                <p class="px-3 py-2 text-xs font-semibold text-gray-500 uppercase">Agregar Componente</p>
                @foreach(\App\Models\PageComponent::getAvailableTypes() as $type => $label)
                <button wire:click="addComponent('{{ $type }}')"
                        @click="showMenu = false"
                        class="w-full text-left px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded">
                    {{ $label }}
                </button>
                @endforeach
            </div>
        </div>
        
        <button @click="showMenu = !showMenu" class="w-14 h-14 bg-blue-600 hover:bg-blue-700 text-white rounded-full shadow-lg flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
        </button>
    </div>

    <!-- Page Content -->
    <div class="max-w-7xl mx-auto py-8">
        @if($page->components->isEmpty())
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Sin componentes</h3>
            <p class="mt-1 text-sm text-gray-500">Comienza agregando un componente a tu página.</p>
        </div>
        @else
        <div class="space-y-4">
            @foreach($page->components->sortBy('order') as $component)
            <div class="relative group">
                <!-- Component Edit Overlay -->
                <div class="absolute -top-2 -right-2 opacity-0 group-hover:opacity-100 transition-opacity flex space-x-2 z-10">
                    <button wire:click="editComponent({{ $component->id }})" 
                            class="px-3 py-1 bg-blue-600 text-white text-xs rounded-lg hover:bg-blue-700 shadow-lg">
                        ✏️ Editar
                    </button>
                    <button wire:click="deleteComponent({{ $component->id }})" 
                            wire:confirm="¿Eliminar este componente?"
                            class="px-3 py-1 bg-red-600 text-white text-xs rounded-lg hover:bg-red-700 shadow-lg">
                        🗑️
                    </button>
                </div>
                
                <!-- Component Render -->
                <div class="{{ $editingComponent === $component->id ? 'ring-4 ring-blue-500' : 'ring-1 ring-gray-200 group-hover:ring-2 group-hover:ring-blue-300' }} rounded-lg overflow-hidden bg-white transition-all">
                    @include('components.types.' . $component->type, [
                        'content' => $component->content ?? [],
                        'settings' => $component->settings ?? []
                    ])
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    <!-- Edit Component Modal -->
    @if($editingComponent)
    <div class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4">
                <h3 class="text-lg font-semibold text-gray-900">Editar Componente</h3>
            </div>
            
            <div class="p-6 space-y-6">
                <!-- Content Fields -->
                <div>
                    <h4 class="text-sm font-medium text-gray-900 mb-3">Contenido</h4>
                    <div class="space-y-3">
                        @forelse($componentContent as $key => $value)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ ucfirst($key) }}</label>
                            @if(strlen($value) > 100)
                            <textarea wire:model="componentContent.{{ $key }}" 
                                      rows="4" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                            @else
                            <input type="text" 
                                   wire:model="componentContent.{{ $key }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @endif
                        </div>
                        @empty
                        <div class="text-center py-4">
                            <button wire:click="$set('componentContent.titulo', '')" class="text-sm text-blue-600 hover:text-blue-700">
                                + Agregar campo de contenido
                            </button>
                        </div>
                        @endforelse
                        
                        @if(!empty($componentContent))
                        <button type="button" 
                                x-data="{}"
                                @click="$wire.componentContent[prompt('Nombre del campo:')] = ''"
                                class="text-sm text-blue-600 hover:text-blue-700">
                            + Agregar otro campo
                        </button>
                        @endif
                    </div>
                </div>

                <!-- Settings Fields -->
                <div>
                    <h4 class="text-sm font-medium text-gray-900 mb-3">Configuración</h4>
                    <div class="space-y-3">
                        @forelse($componentSettings as $key => $value)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ ucfirst($key) }}</label>
                            <input type="text" 
                                   wire:model="componentSettings.{{ $key }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        @empty
                        <div class="text-center py-4">
                            <button wire:click="$set('componentSettings.color', 'blue')" class="text-sm text-blue-600 hover:text-blue-700">
                                + Agregar configuración
                            </button>
                        </div>
                        @endforelse
                        
                        @if(!empty($componentSettings))
                        <button type="button" 
                                x-data="{}"
                                @click="$wire.componentSettings[prompt('Nombre de la configuración:')] = ''"
                                class="text-sm text-blue-600 hover:text-blue-700">
                            + Agregar otra configuración
                        </button>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="sticky bottom-0 bg-gray-50 border-t border-gray-200 px-6 py-4 flex justify-end space-x-3">
                <button wire:click="cancelEdit" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                    Cancelar
                </button>
                <button wire:click="saveComponent" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                    Guardar Cambios
                </button>
            </div>
        </div>
    </div>
    @endif
</div>
