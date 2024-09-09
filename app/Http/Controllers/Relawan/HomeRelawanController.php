<?php

namespace App\Http\Controllers\Relawan;

use App\Http\Controllers\Controller;

class HomeRelawanController extends Controller
{
    public function index()
    {
        return view('dashboard.relawan.dashboard.index');
    }
}
