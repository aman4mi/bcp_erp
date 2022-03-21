<?php

namespace App\Http\Controllers\Rtm;

use App\Http\Controllers\Controller;

class RtmDashboardControllr extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('rtm.dashboard');
    }
}
