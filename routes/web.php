<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicacionController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\MensajeController; // ← Importante
use Illuminate\Support\Facades\Route;

// Rutas para invitados (no autenticados)
Route::middleware('guest')->group(function () {
    Route::get('/registro', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/registro', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Rutas protegidas (requieren autenticación)
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard (mural de anuncios)
    Route::get('/dashboard', [PublicacionController::class, 'index'])->name('dashboard');
    Route::get('/', fn() => redirect()->route('dashboard'));

    // CRUD de publicaciones
    Route::resource('publicaciones', PublicacionController::class)->except(['show']);

    // Calificaciones (estrellas)
    Route::post('/publicaciones/{publicacion}/calificar', [RatingController::class, 'store'])->name('publicaciones.calificar');

    // Perfil de usuario (edición, actualización, foto, eliminación)
    Route::get('/perfil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/perfil', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/perfil', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo');
    Route::get('/perfil/mensajes', [ProfileController::class, 'messages'])->name('profile.messages');

    // Mensajería (compra/contacto y buzones)
    Route::get('/publicacion/{publicacion}/comprar', [MensajeController::class, 'create'])->name('comprar.form');
    Route::post('/enviar-mensaje', [MensajeController::class, 'store'])->name('enviar.mensaje');
    Route::get('/mis-mensajes', [MensajeController::class, 'inbox'])->name('mensajes.inbox');
    Route::get('/mensajes/enviados', [MensajeController::class, 'sent'])->name('mensajes.sent');
    Route::get('/mensaje/{mensaje}', [MensajeController::class, 'show'])->name('mensajes.show');
    Route::get('/mensajes/responder/{mensaje}', [MensajeController::class, 'reply'])->name('mensajes.reply');
});