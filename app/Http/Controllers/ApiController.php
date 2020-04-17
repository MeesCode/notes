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
        $user = User::where('api_token', $request->api_token)->first();

        if($user == null){
            return '{"error": "unknown token"}';
        }

        $notes = Note::where('user_id', $user->id)->get();
        return $notes->toJson();
    }

    public function deleteNote(Request $request)
    {
        $user = User::where('api_token', $request->api_token)->first();
        if($user == null){
            return '{"error": "unknown token"}';
        }

        $note = Note::where('id', $request->id)->first();
        if($note == null){
            return '{"error": "note does not exist"}';
        }

        if($user->id != $note->user_id){
            return '{"error": "invalid api token"}';
        }

        $note->delete();

        return '{"success": true, "amount": 1}';
    }

}
