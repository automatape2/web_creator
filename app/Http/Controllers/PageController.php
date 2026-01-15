<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Muestra una página pública por su slug
     */
    public function show(string $slug): View
    {
        $page = Page::where('slug', $slug)
            ->where('is_published', true)
            ->with('components')
            ->firstOrFail();
        
        return view('site.show', compact('page'));
    }

    /**
     * Lista todas las páginas publicadas del usuario autenticado
     */
    public function index(): View
    {
        $pages = auth()->user()
            ->pages()
            ->latest()
            ->get();
        
        return view('site.index', compact('pages'));
    }

    /**
     * Vista previa de una página (incluso si no está publicada)
     */
    public function preview(Page $page): View
    {
        // Verificar que el usuario sea el propietario
        if ($page->user_id !== auth()->id()) {
            abort(403);
        }
        
        $page->load('components');
        
        return view('site.show', compact('page'));
    }
}
