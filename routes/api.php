<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::prefix('categories')->group(function () {
        Route::post('/', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('/{id}', [CategoryController::class, 'show'])->name('categories.show');
        Route::put('/{id}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
        Route::get('/{identifier}/count-products', [CategoryController::class, 'countProducts'])->name('categories.countProducts');
    });

    Route::prefix('products')->group(function () {
        Route::post('/', [ProductController::class, 'store'])->name('products.store');
        Route::get('/', [ProductController::class, 'index'])->name('products.index');
        Route::get('/{id}', [ProductController::class, 'show'])->name('products.show');
        Route::put('/{id}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
    });
});
