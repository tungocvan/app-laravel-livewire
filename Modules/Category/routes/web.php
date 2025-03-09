<?php

use Illuminate\Support\Facades\Route;
use Modules\Category\Http\Controllers\CategoryController;


Route::middleware(['web','auth'])->prefix('/admin/category')->name('category.')->group(function(){
    Route::get('/{taxonomy}', [CategoryController::class,'index'])->name('index');
    Route::post('/submit', [CategoryController::class,'store'])->name('submit');
    Route::delete('/bulk-delete', [CategoryController::class, 'bulkDelete'])->name('bulkDelete');
});