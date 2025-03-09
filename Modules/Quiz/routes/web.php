<?php

use Illuminate\Support\Facades\Route;
use Modules\Quiz\Http\Controllers\QuizController;
use Modules\Quiz\Http\Controllers\PdfUploadController;

Route::middleware(['web','auth'])->prefix('/admin')->name('quiz.')->group(function(){
    Route::get('/quiz-list', [QuizController::class,'quizList'])->name('quiz-list');
    Route::post('/submit-list', [QuizController::class,'submitList'])->name('submit-list');
    Route::get('/topic-set-list', [QuizController::class,'topicSetList'])->name('topic-set-list');
    Route::post('/submit-topic-set-list', [QuizController::class,'topicSetList'])->name('submit-topic-set-list');
    Route::get('/topic-set-add', [QuizController::class,'topicSetAdd'])->name('topic-set-add');
    Route::get('/question-set/{id}', [QuizController::class,'questionSet'])->name('question-set');
    Route::post('/submit', [QuizController::class,'submit'])->name('submit');
    Route::post('/submit-set/{id}', [QuizController::class,'submitSet'])->name('submit-set');
    Route::get('/quiz/settings', [QuizController::class,'settings'])->name('settings');
    Route::post('/quiz/submit-topic', [QuizController::class,'submitTopic'])->name('submit-topic');
    Route::post('/quiz/submit-class', [QuizController::class,'submitClass'])->name('submit-class');
    Route::post('/quiz/submit-add', [QuizController::class,'submitAdd'])->name('submit-add');

    // Quản trị câu hỏi
    Route::get('/quiz-add', [QuizController::class,'quizAdd'])->name('quiz-add');
    Route::post('/quiz-edit', [QuizController::class,'quizEdit'])->name('quiz-edit');
    Route::post('/quiz-store', [QuizController::class,'quizStore'])->name('quiz-store');
    Route::post('/quiz-delete', [QuizController::class,'quizDelete'])->name('quiz-delete');
    Route::post('/quiz-store', [QuizController::class,'quizStore'])->name('quiz-store');
    Route::post('/quiz-import', [QuizController::class,'quizImport'])->name('quiz-import');
    Route::post('/quiz-import-set', [QuizController::class,'quizImportSet'])->name('quiz-import-set');
    Route::post('/quiz-create-setquiz', [QuizController::class,'createSetquiz'])->name('create-setquiz');
    
   
});

Route::post('/upload-pdf', [PdfUploadController::class, 'upload'])->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);