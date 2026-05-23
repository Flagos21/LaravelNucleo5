<?php

use App\Http\Controllers\FormRequestController;
use App\Http\Controllers\ModuloController;
use Illuminate\Support\Facades\Route;

// ─────────────────────────────────────────────
// Rutas NT5 — Formularios y Validaciones
// ─────────────────────────────────────────────

// Dashboard principal
Route::get('/', [ModuloController::class, 'dashboard'])->name('dashboard');

// Módulo 1 — Creación de formularios
Route::get('/modulo/formularios', [ModuloController::class, 'formularios'])->name('modulos.formularios');
Route::post('/modulo/formularios', [ModuloController::class, 'guardarFicha'])->name('modulos.formularios.store');

// Módulo 2 — Validación de datos
Route::get('/modulo/validacion', [ModuloController::class, 'validacion'])->name('modulos.validacion');
Route::post('/modulo/validacion', [ModuloController::class, 'guardarProducto'])->name('modulos.validacion.store');

// Módulo 3 — Mensajes de error personalizados
Route::get('/modulo/errores', [ModuloController::class, 'errores'])->name('modulos.errores');
Route::post('/modulo/errores', [ModuloController::class, 'guardarContacto'])->name('modulos.errores.store');

// Módulo 4 — Form Request Objects
Route::get('/modulo/form-request', [FormRequestController::class, 'index'])->name('modulos.form-request');
Route::post('/modulo/form-request', [FormRequestController::class, 'store'])->name('modulos.form-request.store');

// ─────────────────────────────────────────────
// Rutas NT6 — Autenticación y Autorización
// ─────────────────────────────────────────────
Route::get('/nt6', fn() => view('nt6.index'))->name('nt6.index');
