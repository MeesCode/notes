<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Note;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{

    public function index()
    {
        $notes = Note::where('user_id', Auth::user()->id)->get();
        $token = Auth::user()->api_token;
        return view('home', ['notes' => $notes, 'token' => $token]);
    }
    
    public function createNote(Request $request)
    {

        // very basic validator
        $validator = Validator::make($request->all(), [
            'title' => ['string', 'max:255'],
            'text' => ['string'],
        ]);

        if ($validator->fails()) {
            return redirect(route('home'))->withErrors($validator)->withInput();
        }

        $note = new Note();
        $note->user_id = Auth::user()->id;
        $note->title = $request->title;
        $note->text = $request->text;
        $note->save();

        return redirect(route('home'));
    }

    public function deleteNote(Request $request)
    {


        $note = Note::find($request->id);
        if($note->user_id != Auth::user()->id){
            return redirect(route('home'));
        }
        $note->delete();
        return redirect(route('home'));
    }

}
