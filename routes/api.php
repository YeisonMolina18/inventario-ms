<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;

// Renombramos el recurso a 'inventario' para que coincida con tu petición
Route::apiResource('inventario', ProductController::class)->parameters([
    'inventario' => 'product' // Le decimos a Laravel que {inventario} se refiere a un $product
]);

// Ruta para que Inventario consulte las ventas de un producto
Route::get('inventario/{product}/ventas', [ProductController::class, 'getSales']);
