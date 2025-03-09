<?php

use Illuminate\Support\Facades\Route;
use Modules\Base\Http\Controllers\BaseController;

Route::middleware(['web','auth'])->prefix('/base')->name('base.')->group(function(){
    Route::get('/', [BaseController::class,'index'])->name('index');
});
