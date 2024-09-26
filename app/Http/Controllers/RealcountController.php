<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RealcountController extends Controller
{
    public function realcount()
    {
        return view('realcount.page');
    }
}
