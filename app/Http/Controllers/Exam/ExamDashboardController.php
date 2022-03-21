<?php

namespace App\Http\Controllers\Exam;

use App\Http\Controllers\Controller;

class ExamDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('layouts.dashboard');
    }
}
