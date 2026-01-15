@php
    $title = $content['title'] ?? 'Características';
    $items = $content['items'] ?? [];
    $columns = $settings['columns'] ?? '3';
    $style = $settings['style'] ?? 'cards';
@endphp

<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        @if($title)
            <h2 class="text-4xl font-bold text-center mb-12 text-gray-800">
                {{ $title }}
            </h2>
        @endif
        
        <div class="grid grid-cols-1 md:grid-cols-{{ $columns }} gap-8 max-w-6xl mx-auto">
            @foreach($items as $item)
                <div class="{{ $style === 'cards' ? 'bg-white p-8 rounded-lg shadow-md' : 'p-6' }}">
                    @if(isset($item['icon']))
                        <div class="text-4xl mb-4">
                            @switch($item['icon'])
                                @case('check')
                                    ✓
                                    @break
                                @case('lightning')
                                    ⚡
                                    @break
                                @case('shield')
                                    🛡️
                                    @break
                                @default
                                    ✨
                            @endswitch
                        </div>
                    @endif
                    
                    <h3 class="text-xl font-semibold mb-3 text-gray-800">
                        {{ $item['title'] ?? 'Característica' }}
                    </h3>
                    
                    @if(isset($item['description']))
                        <p class="text-gray-600">
                            {{ $item['description'] }}
                        </p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>
