<?php

use App\Http\Controllers\Rtm\RtmDashboardControllr;
use Illuminate\Support\Facades\Route;

Route::get('/rtm-dashboard', [RtmDashboardControllr::class, 'index'])->middleware('auth')->name('rtm-dashboard');
