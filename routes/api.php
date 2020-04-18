<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/notes', 'ApiController@getNotes')->name('apiNotes');
Route::post('/create_note', 'ApiController@createNote')->name('createNote');
Route::post('/delete_note', 'ApiController@deleteNote')->name('deleteNote');
Route::get('/get_image', 'ApiController@getImage')->name('getImage');