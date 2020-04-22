<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Note;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{

    public function spa()
    {
        if(Auth::check()){
            $filter = ['user_id' => Auth::user()->id];
            $notes = Note::where($filter)->latest()->get();
            return view('layouts.spa', ['notes' => $notes]);
        } else {
            return view('layouts.spa');
        }
    }

    public function tologin(Request $request)
    {
        return redirect('login');
    }

}
