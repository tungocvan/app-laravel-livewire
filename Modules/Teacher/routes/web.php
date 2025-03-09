<?php

use Illuminate\Support\Facades\Route;
use Modules\Teacher\Http\Controllers\TeacherController;

Route::middleware(['web','auth'])->prefix('/admin/teacher')->name('teacher.')->group(function(){
    Route::get('/', [TeacherController::class,'index'])->name('index');
});
 