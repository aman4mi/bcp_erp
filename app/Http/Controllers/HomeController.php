<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $userModel = new User();

        //echo auth()->id();
        //die;
        $modules = Module::where('active', true)->get();

        $userAccessModules = $userModel->getModules(auth()->id());

        /*foreach ($modules as $module) {
        $allModules[] = $module->module_name;
        }

        foreach ($userModules as $usrmodule) {
        $assignModules[] = $usrmodule->module_name;
        }

        $userAccessModules = array_intersect($allModules, $assignModules);

        dd($userAccessModules);*/

        return view('home', [
            'modules' => $userAccessModules,
        ]);
    }
}