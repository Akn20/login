<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TokenController extends Controller
{
    public function index()
    {
        $tokens = [];
        return view('admin.Receptionist.tokens.index', compact('tokens'));
    }
}
