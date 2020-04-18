<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Note;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;


class ApiController extends Controller
{

    public function getNotes(Request $request)
    {
        $request = json_decode($request->getContent());
        $user = User::where('access_token', $request->access_token)->first();
        if($user == null){
            return '{"error": "invalid token"}';
        }

        $notes = Note::where('user_id', $user->id)->get();
        return $notes->toJson();
    }

    public function deleteNote(Request $request)
    {
        $request = json_decode($request->getContent());
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

        if(isset($note->file)){
            Storage::delete($note->file);
        }

        $note->delete();

        $notes = Note::where('user_id', $user->id)->get();
        return $notes->toJson();
    }

    public function getImage(Request $request)
    {
        $user = User::where('access_token', $request->query('access_token'))->first();
        if($user == null){
            return '{"error": "invalid token"}';
        }

        $note = Note::where('id', $request->query('id'))->first();
        if($note == null){
            return '{"error": "note does not exist"}';
        }

        if($user->id != $note->user_id){
            return '{"error": "invalid api token"}';
        }

        $headers = array(
            'Content-Disposition' => 'inline',
        );

        return Storage::download($note->file, $note->file, $headers);

    }

    public function createNote(Request $request)
    {
        $request = json_decode($request->getContent());
        $user = User::where('access_token', $request->access_token)->first();
        if($user == null){
            return '{"error": "invalid token"}';
        }

        $note = new Note();
        $note->user_id = $user->id;
        $note->title = $request->note->title;
        $note->text = $request->note->text;

        // if a file is added
        if(isset($request->note->file)){
            $image = $request->note->file;
            preg_match("/data:image\/(.*?);/",$image,$image_extension);
            $image = preg_replace('/data:image\/(.*?);base64,/','',$image); 
            $image = str_replace(' ', '+', $image);
            $imageName = 'image_' . time() . '.' . $image_extension[1];
            Storage::disk('local')->put($imageName,base64_decode($image));
            $note->file = $imageName;
        }

        $note->save();

        $notes = Note::where('user_id', $user->id)->get();
        return $notes->toJson();
    }



}
