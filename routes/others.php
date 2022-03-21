<?php

use App\Http\Controllers\Others\BcpsGoldenJubileeController;
use App\Http\Controllers\Others\ConvocationController;
use Illuminate\Support\Facades\Route;

/* BCPS Golden Jubilee */
Route::get('/golden-jubilee', [BcpsGoldenJubileeController::class, 'index'])->name('golden-jubilee');
Route::get('/golden-jubilee-list', [BcpsGoldenJubileeController::class, 'list'])->name('golden-jubilee-list');
Route::get('/jubilee-member-info', [BcpsGoldenJubileeController::class, 'show'])->name('jubilee-member-info');
Route::get('/bcps-golden-jubilee', [BcpsGoldenJubileeController::class, 'create'])->name('bcps-golden-jubilee');
Route::post('/bcps-golden-jubilee-store', [BcpsGoldenJubileeController::class, 'store'])->name('jubilee-store');

Route::get('/fellow-list', [BcpsGoldenJubileeController::class, 'listfellow'])->name('fellow-list');
Route::get('/action-list', [BcpsGoldenJubileeController::class, 'show_action_list'])->middleware(['auth'])->name('action-list');
Route::get('/gold-file', [BcpsGoldenJubileeController::class, 'goldFileExport'])->name('gold-file');

// Artisan
Route::get('/link1234567890123', [BcpsGoldenJubileeController::class, 'stor_link'])->middleware(['auth'])->name('link');
Route::get('/clear-route-cache', [BcpsGoldenJubileeController::class, 'cacheclear_link'])->name('clear-route-cache');

//Convocation
Route::get('/convocation4teen', [ConvocationController::class, 'create2'])->name('convocation4teen');
Route::get('/subject-by-type', [ConvocationController::class, 'getSubjectByDegreeType'])->name('subject-by-type');
Route::post('/convocation4teen-save', [ConvocationController::class, 'store'])->name('conv-4teen-save');

    // Route::get('/link2', function () {        
    //     $target = 'storage/app/public';
    //     $shortcut = 'storage';
    //     symlink($target, $shortcut);
    //  });