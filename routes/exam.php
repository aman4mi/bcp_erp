<?php

use App\Http\Controllers\Exam\ExamDashboardController;
use App\Http\Controllers\Exam\ExamInfoUpdateController;
use Illuminate\Support\Facades\Route;

Route::get('/exam-dashboard', [ExamDashboardController::class, 'index'])->middleware('auth')->name('exam-dashboard');

Route::get('/exam-info-update', [ExamInfoUpdateController::class, 'create'])->name('exam-info-update');
Route::post('/exam-info-save', [ExamInfoUpdateController::class, 'store'])->name('exam-info-save');
Route::get('/exam-info-update-file', [ExamInfoUpdateController::class, 'examInfoUpdateFileExport'])->name('exam-info-update-file');

//initialize
Route::get('/list-exam-info-update', [ExamInfoUpdateController::class, 'show'])->middleware(['auth'])->name('list-exam-info-update');
Route::get('/edit-exam-info-update/{id}', [ExamInfoUpdateController::class, 'edit'])->middleware(['auth'])->name('edit-exam-info-update');
Route::get('/exam-info-data', [ExamInfoUpdateController::class, 'getExamUpdateData'])->name('exam-info-data');
Route::get('/exam-info-delete/{id}', [ExamInfoUpdateController::class, 'deleteData'])->middleware(['auth'])->name('exam-info-delete');