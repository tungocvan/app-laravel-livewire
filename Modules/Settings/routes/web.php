<?php

use Illuminate\Support\Facades\Route;
use Modules\Settings\Http\Controllers\SettingsController;

Route::middleware(['web','auth'])->prefix('/settings')->name('settings.')->group(function(){
    Route::get('/', [SettingsController::class,'index'])->name('index');
    Route::get('/help', [SettingsController::class,'help'])->name('help');
    Route::get('/menu', [SettingsController::class,'menu'])->name('menu');
    Route::get('/artisan', [SettingsController::class,'artisan'])->name('artisan');
});
