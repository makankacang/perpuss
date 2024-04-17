<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PerpusController extends Controller
{
    public function dashboard()
    {
        return view('dashboard');
    }

    public function home()
    {
        return view('/');
    }
}
