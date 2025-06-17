<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticuloController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\CarritoController;

Route::get('/', [ArticuloController::class, 'index'])->name('inicio');

Auth::routes();

Route::get('/home', [App\Http\Controllers\ArticuloController::class, 'index'])->name('home');
Route::get('/articulos', [ArticuloController::class, 'index'])->name('articulos.index');
Route::get('/articulos/buscar', [ArticuloController::class, 'buscar'])->name('articulos.buscar');
Route::get('/articulos/busqueda-avanzada', [ArticuloController::class, 'busquedaAvanzada'])->name('articulos.busquedaAvanzada');
Route::get('/articulos/{articulo}', [ArticuloController::class, 'show'])->name('articulos.show');


Route::post('/articulos/{id}/comprar', [CompraController::class, 'comprar'])->middleware('auth')->name('comprar.articulo');

Route::get('/carrito', [CarritoController::class, 'ver'])->name('carrito.ver');
Route::post('/carrito/agregar/{id}', [CarritoController::class, 'agregar'])->name('carrito.agregar');
Route::post('/carrito/actualizar/{id}', [CarritoController::class, 'actualizar'])->name('carrito.actualizar');
Route::post('/carrito/eliminar/{id}', [CarritoController::class, 'eliminar'])->name('carrito.eliminar');
Route::post('/carrito/comprar', [CarritoController::class, 'comprar'])->middleware('auth')->name('carrito.comprar');