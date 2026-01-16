<div class="min-h-screen bg-gray-50">
    <!-- Editor Toolbar -->
    <div class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-full mx-auto px-4 py-3">
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
                    <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-700">
                        📐 Editor de Cuadrícula
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

    <!-- Grid Editor -->
    <div class="p-6">
        <div class="mb-4 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <p class="text-sm text-blue-800">
                <strong>💡 Cómo usar:</strong> Arrastra sobre las celdas para seleccionar el área del componente (ancho y alto). Luego elige el tipo de componente.
            </p>
            @if($selectionStart && $selectionEnd)
                @php
                    $area = [
                        'rowStart' => min($selectionStart['row'], $selectionEnd['row']),
                        'rowEnd' => max($selectionStart['row'], $selectionEnd['row']),
                        'colStart' => min($selectionStart['col'], $selectionEnd['col']),
                        'colEnd' => max($selectionStart['col'], $selectionEnd['col']),
                    ];
                    $rows = ($area['rowEnd'] - $area['rowStart']) + 1;
                    $cols = ($area['colEnd'] - $area['colStart']) + 1;
                @endphp
                <div class="mt-2 flex items-center gap-2">
                    <span class="text-sm font-semibold text-blue-900">
                        Área seleccionada: {{ chr(64 + $area['colStart']) }}{{ $area['rowStart'] }} - {{ chr(64 + $area['colEnd']) }}{{ $area['rowEnd'] }}
                        ({{ $rows }} fila{{ $rows > 1 ? 's' : '' }} × {{ $cols }} columna{{ $cols > 1 ? 's' : '' }})
                    </span>
                    @if(!$isDragging)
                    <button wire:click="endSelection" class="px-3 py-1 bg-blue-600 text-white text-xs rounded hover:bg-blue-700">
                        ✓ Agregar Componente
                    </button>
                    @endif
                    <button wire:click="cancelSelection" class="px-3 py-1 bg-gray-400 text-white text-xs rounded hover:bg-gray-500">
                        ✗ Cancelar
                    </button>
                </div>
            @endif
        </div>

        <!-- Grid Controls -->
        <div class="mb-4 flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <button wire:click="addRow" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700">
                    + Agregar Fila
                </button>
                @if($gridRows > 1)
                <button wire:click="removeRow" class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700">
                    - Quitar Fila
                </button>
                @endif
            </div>
            <div class="text-sm text-gray-600">
                Filas: <span class="font-semibold">{{ $gridRows }}</span> × Columnas: <span class="font-semibold">{{ $gridCols }}</span>
            </div>
        </div>

        <!-- Grid Container -->
        <div class="bg-white rounded-lg shadow-lg p-4 overflow-x-auto">
            <div class="inline-grid gap-1" style="grid-template-columns: repeat({{ $gridCols }}, 80px); grid-template-rows: repeat({{ $gridRows }}, 80px);">
                @for($row = 1; $row <= $gridRows; $row++)
                    @for($col = 1; $col <= $gridCols; $col++)
                        @php
                            $cellComponent = $page->components->first(function($comp) use ($row, $col) {
                                $pos = $comp->settings['grid_position'] ?? null;
                                if (!$pos) return false;
                                
                                $rowspan = $pos['rowspan'] ?? 1;
                                $colspan = $pos['colspan'] ?? 1;
                                $componentRow = $pos['row'];
                                $componentCol = $pos['col'];
                                
                                return $row >= $componentRow && $row < ($componentRow + $rowspan)
                                    && $col >= $componentCol && $col < ($componentCol + $colspan);
                            });

                            // Calcular si está en el área seleccionada
                            $isSelected = false;
                            if ($selectionStart && $selectionEnd) {
                                $minRow = min($selectionStart['row'], $selectionEnd['row']);
                                $maxRow = max($selectionStart['row'], $selectionEnd['row']);
                                $minCol = min($selectionStart['col'], $selectionEnd['col']);
                                $maxCol = max($selectionStart['col'], $selectionEnd['col']);
                                $isSelected = $row >= $minRow && $row <= $maxRow && $col >= $minCol && $col <= $maxCol;
                            }
                            
                            // Verificar si esta celda es la primera de un componente
                            $isComponentStart = $cellComponent && 
                                ($cellComponent->settings['grid_position']['row'] ?? null) == $row &&
                                ($cellComponent->settings['grid_position']['col'] ?? null) == $col;
                            
                            // Si es parte de un componente pero no es el inicio, skip
                            if ($cellComponent && !$isComponentStart) {
                                continue;
                            }
                            
                            $componentRowspan = 1;
                            $componentColspan = 1;
                            if ($cellComponent) {
                                $componentRowspan = $cellComponent->settings['grid_position']['rowspan'] ?? 1;
                                $componentColspan = $cellComponent->settings['grid_position']['colspan'] ?? 1;
                            }
                        @endphp

                        <div wire:mousedown="startSelection({{ $row }}, {{ $col }})"
                             wire:mouseenter="updateSelection({{ $row }}, {{ $col }})"
                             wire:mouseup="endSelection"
                             style="{{ $cellComponent ? 'grid-column: span ' . $componentColspan . '; grid-row: span ' . $componentRowspan . ';' : '' }}"
                             class="border-2 transition-all cursor-crosshair relative group select-none
                                    {{ $isSelected ? 'border-blue-500 bg-blue-100 ring-2 ring-blue-400 z-10' : 'border-gray-200 hover:border-blue-300 hover:bg-blue-50' }}
                                    {{ $cellComponent ? 'bg-green-50 border-green-400 cursor-pointer' : '' }}">
                            
                            <div class="absolute top-0 left-0 text-[8px] text-gray-400 px-1">
                                {{ chr(64 + $col) }}{{ $row }}
                            </div>
                            
                            @if($cellComponent)
                                <div class="h-full flex flex-col items-center justify-center p-1">
                                    <div class="text-2xl">
                                        @switch($cellComponent->type)
                                            @case('hero') 🎯 @break
                                            @case('text') 📝 @break
                                            @case('image') 🖼️ @break
                                            @case('video') 🎥 @break
                                            @case('gallery') 🎨 @break
                                            @case('features') ⭐ @break
                                            @case('contact_form') 📧 @break
                                            @case('testimonials') 💬 @break
                                            @case('pricing') 💰 @break
                                            @case('faq') ❓ @break
                                            @case('cta') 📢 @break
                                            @default 📦
                                        @endswitch
                                    </div>
                                    <div class="text-[9px] font-semibold text-gray-600 text-center mt-1">
                                        {{ ucfirst($cellComponent->type) }}
                                    </div>
                                    
                                    <div class="absolute top-1 right-1 opacity-0 group-hover:opacity-100 flex gap-1">
                                        <button wire:click.stop="editComponent({{ $cellComponent->id }})" 
                                                class="bg-blue-500 text-white rounded px-1 text-[10px] hover:bg-blue-600">
                                            ✏️
                                        </button>
                                        <button wire:click.stop="deleteComponent({{ $cellComponent->id }})" 
                                                wire:confirm="¿Eliminar?"
                                                class="bg-red-500 text-white rounded px-1 text-[10px] hover:bg-red-600">
                                            🗑️
                                        </button>
                                    </div>
                                </div>
                            @else
                                <div class="h-full flex items-center justify-center text-gray-300 text-2xl">
                                    +
                                </div>
                            @endif
                        </div>
                    @endfor
                @endfor
            </div>
        </div>
    </div>

    @if($showComponentMenu && $selectionStart && $selectionEnd)
    <div class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4" wire:click="cancelSelection">
        <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full p-6" @click.stop>
            @php
                $area = [
                    'rowStart' => min($selectionStart['row'], $selectionEnd['row']),
                    'rowEnd' => max($selectionStart['row'], $selectionEnd['row']),
                    'colStart' => min($selectionStart['col'], $selectionEnd['col']),
                    'colEnd' => max($selectionStart['col'], $selectionEnd['col']),
                ];
                $rows = ($area['rowEnd'] - $area['rowStart']) + 1;
                $cols = ($area['colEnd'] - $area['colStart']) + 1;
            @endphp
            <h3 class="text-lg font-bold text-gray-900 mb-4">
                Agregar componente: {{ chr(64 + $area['colStart']) }}{{ $area['rowStart'] }} - {{ chr(64 + $area['colEnd']) }}{{ $area['rowEnd'] }}
                <span class="text-sm font-normal text-gray-600">({{ $rows }} fila{{ $rows > 1 ? 's' : '' }} × {{ $cols }} columna{{ $cols > 1 ? 's' : '' }})</span>
            </h3>
            
            <div class="grid grid-cols-3 gap-3">
                @foreach(\App\Models\PageComponent::getAvailableTypes() as $type => $label)
                <button wire:click="addComponentToCell('{{ $type }}')"
                        class="p-4 border-2 border-gray-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-all text-center">
                    <div class="text-3xl mb-2">
                        @switch($type)
                            @case('hero') 🎯 @break
                            @case('text') 📝 @break
                            @case('image') 🖼️ @break
                            @case('video') 🎥 @break
                            @case('gallery') 🎨 @break
                            @case('features') ⭐ @break
                            @case('contact_form') 📧 @break
                            @case('testimonials') 💬 @break
                            @case('pricing') 💰 @break
                            @case('faq') ❓ @break
                            @case('cta') 📢 @break
                        @endswitch
                    </div>
                    <div class="text-sm font-semibold text-gray-700">{{ $label }}</div>
                </button>
                @endforeach
            </div>
            
            <div class="mt-4 text-center">
                <button wire:click="cancelSelection" class="px-4 py-2 text-gray-600 hover:text-gray-800">
                    Cancelar
                </button>
            </div>
        </div>
    </div>
    @endif

    @if($editingComponent)
    <div class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4">
                <h3 class="text-lg font-semibold text-gray-900">Editar Componente</h3>
            </div>
            
            <div class="p-6 space-y-6">
                @forelse($componentContent as $key => $value)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ ucfirst($key) }}</label>
                    @if(strlen($value) > 100)
                    <textarea wire:model="componentContent.{{ $key }}" 
                              rows="4" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"></textarea>
                    @else
                    <input type="text" 
                           wire:model="componentContent.{{ $key }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    @endif
                </div>
                @empty
                <div class="text-center py-4 text-gray-500">
                    Sin campos de contenido
                </div>
                @endforelse
            </div>
            
            <div class="sticky bottom-0 bg-gray-50 border-t border-gray-200 px-6 py-4 flex justify-end space-x-3">
                <button wire:click="cancelEdit" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                    Cancelar
                </button>
                <button wire:click="saveComponent" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                    Guardar
                </button>
            </div>
        </div>
    </div>
    @endif
</div>
