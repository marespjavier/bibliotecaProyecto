<?php

use App\Http\Controllers\AutorController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\LibroController;
use App\Http\Controllers\PrestamoController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Registro y login: públicas
Route::post('/user', [UserController::class, 'store']);
Route::post('/user/login', [UserController::class, 'verify']);

// Todo lo protegido por token
Route::middleware('auth:sanctum')->group(function () {
    // usuarios
    Route::get('/user/logout', [UserController::class, 'logout']);
    Route::get('/user', [UserController::class, 'index']);
    Route::get('/user/{user}', [UserController::class, 'show']);
    Route::put('/user/{user}', [UserController::class, 'update']);
    Route::delete('/user/{user}', [UserController::class, 'destroy']);


    // préstamos
    Route::get('/prestamo', [PrestamoController::class, 'index']);
    Route::get('/prestamo/{prestamo}', [PrestamoController::class, 'show']);
    Route::post('/prestamo', [PrestamoController::class, 'store']);
    Route::put('/prestamo/{prestamo}', [PrestamoController::class, 'update']);
    Route::delete('/prestamo/{prestamo}', [PrestamoController::class, 'destroy']);

    // libros
    Route::get('/libro', [LibroController::class, 'index']);
    Route::get('/libro/{libro}', [LibroController::class, 'show']);
    Route::post('/libro', [LibroController::class, 'store']);
    Route::put('/libro/{libro}', [LibroController::class, 'update']);
    Route::delete('/libro/{libro}', [LibroController::class, 'destroy']);

    //categoria
    Route::get('/categoria', [CategoriaController::class, 'index']);
    Route::get('/categoria/{categoria}', [CategoriaController::class, 'show']);
    Route::post('/categoria', [CategoriaController::class, 'store']);
    Route::put('/categoria/{categoria}', [CategoriaController::class, 'update']);
    Route::delete('/categoria/{categoria}', [CategoriaController::class, 'destroy']);

    //autor
    Route::get('/autor', [AutorController::class, 'index']);
    Route::get('/autor/{autor}', [AutorController::class, 'show']);
    Route::post('/autor', [AutorController::class, 'store']);
    Route::put('/autor/{autor}', [AutorController::class, 'update']);
    Route::delete('/autor/{autor}', [AutorController::class, 'destroy']);
});
