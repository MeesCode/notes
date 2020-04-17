<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Note;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{

    public function dashboard()
    {
        return view('dashboard');
    }

    public function apiDetails(Request $request)
    {
        return view('apiDetails');
    }

}
