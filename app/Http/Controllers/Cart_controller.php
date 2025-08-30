<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Cart_controller extends Controller
{
    public function index(Request $request)
    {
        $template = $request->route('template');
        //dd($template);
        return view('cart', compact('template'));
    }
}
