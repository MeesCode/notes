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
        $user = Auth::user();
        $notes = Note::where(['user_id' => $user->id, 'archived' => false])->get();
        return $notes->toJson();
    }

    public function getArchivedNotes(Request $request)
    {
        $user = Auth::user();
        $notes = Note::where(['user_id' => $user->id, 'archived' => true])->get();
        return $notes->toJson();
    }

    public function deleteNote(Request $request)
    {
        $user = Auth::user();
        $request = json_decode($request->getContent());
        $note = Note::where(['id' => $request->id, 'user_id' => $user->id])->first();

        if(!isset($note)){
            abort(404);
        }

        if(isset($note->file)){
            Storage::delete($note->file);
        }
        $note->delete();

        return response()->json(['success' => 'success'], 200);
    }

    public function getImage(Request $request)
    {
        $user = Auth::user();
        $note = Note::where(['id' => $request->query('id'), 'user_id' => $user->id])->first();

        if(!isset($note)){
            abort(404);
        }

        $headers = array(
            'Content-Disposition' => 'inline',
        );

        return Storage::download($note->file, $note->file, $headers);

    }

    public function createNote(Request $request)
    {
        $request = json_decode($request->getContent());
        $user = Auth::user();

        $note = new Note();
        $note->user_id = $user->id;
        $note->title = $request->note->title;
        $note->text = $request->note->text;
        $note->color = $request->note->color;

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
        return $note->toJson();
    }

    public function editNote(Request $request)
    {
        $request = json_decode($request->getContent());
        $user = Auth::user();
        $note = Note::where(['id' => $request->note->id, 'user_id' => $user->id])->first();

        if(!isset($note)){
            abort(404);
        }

        $note->user_id = $user->id;
        $note->title = $request->note->title;
        $note->text = $request->note->text;
        $note->color = $request->note->color;

        // if a file is added
        if(isset($request->note->file)){

            // delete old file
            if(isset($note->file)){
                Storage::delete($note->file);
            }

            $image = $request->note->file;
            preg_match("/data:image\/(.*?);/",$image,$image_extension);
            $image = preg_replace('/data:image\/(.*?);base64,/','',$image); 
            $image = str_replace(' ', '+', $image);
            $imageName = 'image_' . time() . '.' . $image_extension[1];
            Storage::disk('local')->put($imageName,base64_decode($image));
            $note->file = $imageName;
        }

        $note->save();
        return $note->toJson();
    }

    public function apiToken(Request $request)
    {
        $credentials = $request->query();

        if (Auth::attempt($credentials)) {
            $user = User::where('email', $request->input('email'))->first();
            return json_encode(['api_token' => $user->api_token]);
        }
        return response()->json(['error' => 'invalid'], 401);;
    }

    public function toggleArchive(Request $request)
    {
        $user = Auth::user();
        $note = Note::where(['id' => $request->id, 'user_id' => $user->id])->first();

        if(!isset($note)){
            abort(404);
        }

        $note->archived = !$note->archived;
        $note->save();

        return $note->toJson();
    }



}
