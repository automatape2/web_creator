<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $page->title }}</title>
    
    <meta name="description" content="{{ $page->description }}">
    
    @if($page->meta_tags)
        @foreach($page->meta_tags as $name => $content)
            <meta name="{{ $name }}" content="{{ $content }}">
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
    </style>
</head>
<body class="antialiased">
    <div id="page-content">
        @foreach($page->components as $component)
            @include('components.page-component', ['component' => $component])
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
