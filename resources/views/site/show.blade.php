<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $page->title }}</title>
    
    <meta name="description" content="{{ $page->description }}">
    
    @if($page->meta_tags)
        @foreach($page->meta_tags as $name => $content)
            @if(is_string($content) && !in_array($name, ['grid_layout', 'grid_rows', 'structure']))
                <meta name="{{ $name }}" content="{{ $content }}">
            @endif
        @endforeach
    @endif
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js para interactividad -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Estilos personalizados -->
    @if($page->styles)
        <style>
            {!! is_array($page->styles) ? implode("\n", $page->styles) : $page->styles !!}
        </style>
    @endif
    
    <style>
        /* Estilos base para componentes */
        .component-wrapper {
            width: 100%;
        }
        
        .hero-section {
            min-height: 60vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .primary-bg {
            background: #667eea;
        }
        
        /* CSS Grid Layout */
        .grid-layout {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            grid-auto-rows: minmax(80px, auto);
            gap: 1rem;
            width: 100%;
            max-width: 1400px;
            margin: 0 auto;
            padding: 1rem;
        }
    </style>
</head>
<body class="antialiased">
    <div id="page-content" class="grid-layout">
        @foreach($page->components->sortBy(function($component) {
            $pos = $component->settings['grid_position'] ?? ['row' => 1, 'col' => 1];
            return ($pos['row'] * 100) + $pos['col'];
        }) as $component)
            @php
                $gridPos = $component->settings['grid_position'] ?? ['row' => 1, 'col' => 1, 'rowspan' => 1, 'colspan' => 1];
                $row = $gridPos['row'];
                $col = $gridPos['col'];
                $rowspan = $gridPos['rowspan'] ?? 1;
                $colspan = $gridPos['colspan'] ?? 1;
            @endphp
            <div style="grid-row: {{ $row }} / {{ $row + $rowspan }}; grid-column: {{ $col }} / {{ $col + $colspan }};">
                @include('components.page-component', ['component' => $component])
            </div>
        @endforeach
    </div>
    
    <!-- Scripts personalizados -->
    @if($page->scripts)
        <script>
            {!! is_array($page->scripts) ? implode("\n", $page->scripts) : $page->scripts !!}
        </script>
    @endif
</body>
</html>
