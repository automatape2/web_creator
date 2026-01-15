<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Páginas - Web Creator</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-white shadow">
            <div class="container mx-auto px-4 py-6">
                <div class="flex justify-between items-center">
                    <h1 class="text-3xl font-bold text-gray-800">Mis Páginas Web</h1>
                    <div class="flex gap-4">
                        <a href="/admin" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 transition">
                            Ir al Panel
                        </a>
                        <form method="POST" action="/logout">
                            @csrf
                            <button type="submit" class="text-gray-600 hover:text-gray-800">
                                Cerrar Sesión
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="container mx-auto px-4 py-12">
            @if($pages->isEmpty())
                <div class="text-center py-20">
                    <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h2 class="mt-4 text-2xl font-bold text-gray-700">No tienes páginas aún</h2>
                    <p class="mt-2 text-gray-500">Crea tu primera página web con IA o desde una plantilla</p>
                    <a href="/admin/pages/create" class="mt-6 inline-block bg-purple-600 text-white px-8 py-3 rounded-lg hover:bg-purple-700 transition">
                        Crear Mi Primera Página
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($pages as $page)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                            <div class="p-6">
                                <div class="flex items-start justify-between mb-4">
                                    <h3 class="text-xl font-bold text-gray-800">
                                        {{ $page->title }}
                                    </h3>
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $page->is_published ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $page->is_published ? 'Publicada' : 'Borrador' }}
                                    </span>
                                </div>
                                
                                @if($page->description)
                                    <p class="text-gray-600 mb-4 line-clamp-2">
                                        {{ $page->description }}
                                    </p>
                                @endif
                                
                                <div class="flex items-center text-sm text-gray-500 mb-4">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                                    </svg>
                                    {{ $page->components->count() }} componentes
                                </div>
                                
                                <div class="text-xs text-gray-400 mb-4">
                                    Creada {{ $page->created_at->diffForHumans() }}
                                </div>
                                
                                <div class="flex gap-2">
                                    @if($page->is_published)
                                        <a href="{{ route('page.show', $page->slug) }}" 
                                           target="_blank"
                                           class="flex-1 bg-purple-600 text-white text-center px-4 py-2 rounded hover:bg-purple-700 transition">
                                            Ver Página
                                        </a>
                                    @else
                                        <a href="{{ route('page.preview', $page) }}" 
                                           target="_blank"
                                           class="flex-1 bg-gray-600 text-white text-center px-4 py-2 rounded hover:bg-gray-700 transition">
                                            Vista Previa
                                        </a>
                                    @endif
                                    
                                    <a href="/admin/pages/{{ $page->id }}/edit" 
                                       class="flex-1 bg-gray-200 text-gray-800 text-center px-4 py-2 rounded hover:bg-gray-300 transition">
                                        Editar
                                    </a>
                                </div>
                                
                                @if($page->is_published)
                                    <div class="mt-3">
                                        <div class="flex items-center">
                                            <input type="text" 
                                                   value="{{ url('/p/' . $page->slug) }}" 
                                                   readonly 
                                                   class="flex-1 text-xs bg-gray-50 border border-gray-300 rounded-l px-3 py-2">
                                            <button onclick="copyUrl('{{ url('/p/' . $page->slug) }}')" 
                                                    class="bg-gray-200 border border-l-0 border-gray-300 rounded-r px-3 py-2 hover:bg-gray-300 transition">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M8 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z"/>
                                                    <path d="M6 3a2 2 0 00-2 2v11a2 2 0 002 2h8a2 2 0 002-2V5a2 2 0 00-2-2 3 3 0 01-3 3H9a3 3 0 01-3-3z"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </main>
    </div>

    <script>
        function copyUrl(url) {
            navigator.clipboard.writeText(url).then(() => {
                alert('URL copiada al portapapeles');
            });
        }
    </script>
</body>
</html>
