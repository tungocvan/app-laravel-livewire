<?php

use Illuminate\Support\Facades\Route;
use Modules\Dashboard\Http\Controllers\DashboardController;

Route::middleware(['web','auth'])->prefix('/dashboard')->name('dashboard.')->group(function(){
    Route::get('/', [DashboardController::class,'index'])->name('index');
});
