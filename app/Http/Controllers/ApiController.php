<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Note;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{

    public function getNotes(Request $request)
    {
        $user = User::where('access_token', $request->access_token)->first();
        if($user == null){
            return '{"error": "invalid token"}';
        }

        $notes = Note::where('user_id', $user->id)->get();
        return $notes->toJson();
    }

    public function deleteNote(Request $request)
    {
        $user = User::where('access_token', $request->access_token)->first();
        if($user == null){
            return '{"error": "invalid token"}';
        }

        $note = Note::where('id', $request->id)->first();
        if($note == null){
            return '{"error": "note does not exist"}';
        }

        if($user->id != $note->user_id){
            return '{"error": "invalid api token"}';
        }

        $note->delete();

        $notes = Note::where('user_id', $user->id)->get();
        return $notes->toJson();
    }

    public function createNote(Request $request)
    {
        $user = User::where('access_token', $request->access_token)->first();
        if($user == null){
            return '{"error": "invalid token"}';
        }

        $note = new Note();
        $note->user_id = $user->id;
        $note->title = $request->title;
        $note->text = $request->text;
        $note->save();

        $notes = Note::where('user_id', $user->id)->get();
        return $notes->toJson();
    }

}
