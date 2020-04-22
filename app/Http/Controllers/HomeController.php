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
        $filter = ['user_id' => Auth::user()->id, 'archived' => false];
        $notes = Note::where($filter)->get();
        return view('dashboard', 
            [
                'toggles' => true,
                'filter' => $filter, 
                'notes' => $notes
            ]
        );
    }

    public function apiDetails(Request $request)
    {
        return view('apiDetails', ['toggles' => false]);
    }

}
