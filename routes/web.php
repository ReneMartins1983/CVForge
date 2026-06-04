<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResumeController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

// Galeria pública de modelos (sem login)
Route::get('/modelos', [ResumeController::class, 'gallery'])->name('templates');

// Páginas públicas (link compartilhável + impressão/PDF) — sem login
Route::get('/r/{resume}', [ResumeController::class, 'show'])->name('resumes.show');
Route::get('/r/{resume}/print', [ResumeController::class, 'print'])->name('resumes.print');

// Área autenticada
Route::middleware('auth')->group(function () {
    // após o login o Breeze envia para "dashboard"
    Route::get('/dashboard', fn () => redirect()->route('resumes.index'))->name('dashboard');

    // Builder (criar / editar)
    Route::get('/builder', [ResumeController::class, 'create'])->name('resumes.create');
    Route::get('/builder/{resume}', [ResumeController::class, 'edit'])->name('resumes.edit');

    // CRUD dos currículos do usuário
    Route::get('/resumes', [ResumeController::class, 'index'])->name('resumes.index');
    Route::post('/resumes', [ResumeController::class, 'store'])->name('resumes.store');
    Route::put('/resumes/{resume}', [ResumeController::class, 'update'])->name('resumes.update');
    Route::delete('/resumes/{resume}', [ResumeController::class, 'destroy'])->name('resumes.destroy');

    // Perfil (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
