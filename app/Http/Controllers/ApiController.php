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

    private function stringToBool($s){
        if($s == '1' || $s == 'true'){
            return true;
        }
        return false;
    }

    public function getNotes(Request $request)
    {
        $user = Auth::user();
        $filter = [['user_id', '=', $user->id]];
        if(null !== $request->query('archived')){
            array_push($filter, ['archived', '=', $this->stringToBool($request->query('archived'))]);
        }
        if(null !== $request->query('color')){
            array_push($filter, ['color', '=', $request->query('color')]);
        }
        if(null !== $request->query('search')){
            array_push($filter, ['text', 'like', '%'.$request->query('search').'%']);
        } 
        $notes = Note::where($filter)->orderBy('archived', 'asc')->latest()->get();
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

        return $note->toJson();
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

        return Storage::download($note->image_name, $note->image_name, $headers);

    }

    public function createNote(Request $request)
    {
        $request = json_decode($request->getContent());
        $user = Auth::user();

        $note = new Note();
        $note->user_id = $user->id;
        $note->text = $request->note->text;
        $note->color = $request->note->color;

        if(isset($request->note->has_image) && isset($request->note->image_data)){

            $image = $request->note->image_data;
            preg_match("/data:image\/(.*?);/", $image, $image_extension);

            if(count($image_extension) == 2){
                $image = preg_replace('/data:image\/(.*?);base64,/', '', $image); 
                $image = str_replace(' ', '+', $image);
                $imageName = 'image_' . time() . '.' . $image_extension[1];
                Storage::disk('local')->put($imageName, base64_decode($image));
                $note->image_name = $imageName;
                $note->has_image = true;
            }
        }

        $note->save();
        return Note::find($note->id);
    }

    public function editNote(Request $request)
    {
        $request = json_decode($request->getContent());
        $user = Auth::user();
        $note = Note::where(['id' => $request->note->id, 'user_id' => $user->id])->first();

        if(!isset($note)){
            abort(404);
        }

        foreach(['text', 'color', 'archived'] as $p){
            if(isset($request->note->{$p})){
                $note[$p] = $request->note->{$p};
            }
        }

        if(isset($request->note->has_image) 
        && $this->stringToBool($request->note->has_image) 
        && isset($request->note->image_data)){

            // delete old file
            if($note->has_image && isset($note->image_name)){
                Storage::delete($note->image_name);
            }

            $image = $request->note->image_data;
            preg_match("/data:image\/(.*?);/", $image, $image_extension);

            if(count($image_extension) == 2){
                $image = preg_replace('/data:image\/(.*?);base64,/', '', $image); 
                $image = str_replace(' ', '+', $image);
                $imageName = 'image_' . time() . '.' . $image_extension[1];
                Storage::disk('local')->put($imageName, base64_decode($image));
                $note->image_name = $imageName;
                $note->has_image = true;
            }
        }

        if(isset($request->note->has_image)
        && $note->has_image
        && !$this->stringToBool($request->note->has_image)){
            Storage::delete($note->image_name);
            $note->image_name = null;
            $note->has_image = false;
        }

        $note->save();
        return Note::find($note->id);
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

}
