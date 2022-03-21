<?php

use App\Http\Controllers\It\ItDashboardControllr;
use Illuminate\Support\Facades\Route;

Route::get('/it-dashboard', [ItDashboardControllr::class, 'index'])->middleware('auth')->name('it-dashboard');