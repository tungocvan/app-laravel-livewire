<?php

use Illuminate\Support\Facades\Route;
use Modules\Post\Http\Controllers\PostController;

Route::middleware(['web','auth'])->prefix('/post')->name('post.')->group(function(){
    Route::get('/', [PostController::class,'index'])->name('index');
});
