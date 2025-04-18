<?php

use Illuminate\Support\Facades\Route;
use Modules\Products\Http\Controllers\ProductsController;

Route::middleware(['web','auth'])->prefix('/admin/products')->name('products.')->group(function(){
    Route::get('/', [ProductsController::class,'index'])->name('index');
});
