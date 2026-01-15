<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Rutas para el creador de páginas
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/my-pages', [PageController::class, 'index'])->name('pages.index');
    Route::get('/page/{page}/preview', [PageController::class, 'preview'])->name('page.preview');
    Route::get('/page/{page}/edit', \App\Livewire\PageEditor::class)->name('page.edit');
    Route::get('/page/create/start', \App\Livewire\WebTypeSelector::class)->name('page.create.start');
    Route::get('/page/create/select-layout', \App\Livewire\LayoutSelector::class)->name('page.create.layout');
});

// Ruta pública para ver páginas
Route::get('/p/{slug}', [PageController::class, 'show'])->name('page.show');

require __DIR__.'/settings.php';
