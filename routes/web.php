<?php

use App\Livewire\Home;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteMapGenerator;
use App\Http\Controllers\ProfileController;
use App\Livewire\Converter;
use App\Livewire\Remover;

Route::get('/', Home::class)->name('home');
Route::redirect('converter', 'unlimited-free-images-converter', 301);
Route::get('/unlimited-free-images-converter', Converter::class)->name('converter');
Route::get('/unlimited-free-images-background-remover', Remover::class)->name('remover');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/sitemap.xml', [SiteMapGenerator::class, 'index'])->name('sitemap');

require __DIR__ . '/auth.php';
