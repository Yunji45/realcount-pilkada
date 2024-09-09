<?php

namespace App\Http\Controllers\Lainya;

use App\Http\Controllers\Controller;

class HomeLainyaController extends Controller
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
        return view('dashboard.lain-lain.dashboard.index');
    }
}
