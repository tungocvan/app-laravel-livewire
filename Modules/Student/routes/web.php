<?php

use Illuminate\Support\Facades\Route;
use Modules\Student\Http\Controllers\StudentController;

Route::middleware(['web','auth'])->prefix('/student')->name('student.')->group(function(){
    Route::get('/', [StudentController::class,'index'])->name('index');
    Route::get('/result', [StudentController::class,'result'])->name('result');
    Route::get('/view-file/{id}', [StudentController::class, 'viewFile'])->name('view-file');
    Route::get('/delete-file/{id}', [StudentController::class, 'deleteFile'])->name('delete-file');
});

