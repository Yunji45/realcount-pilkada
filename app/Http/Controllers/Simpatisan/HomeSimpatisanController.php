<?php

namespace App\Http\Controllers\Simpatisan;

use App\Http\Controllers\Controller;

class HomeSimpatisanController extends Controller
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
        return view('dashboard.simpatisan.dashboard.index');
    }
}