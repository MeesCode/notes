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

Route::get('/api_token', 'ApiController@apiToken')->name('apiToken');

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/notes', 'ApiController@getNotes')->name('getNotes');
    Route::get('/archived_notes', 'ApiController@getArchivedNotes')->name('getArchivedNotes');
    Route::post('/create_note', 'ApiController@createNote')->name('createNote');
    Route::delete('/delete_note', 'ApiController@deleteNote')->name('deleteNote');
    Route::get('/get_image', 'ApiController@getImage')->name('getImage');
    Route::patch('/toggle_archive', 'ApiController@toggleArchive')->name('toggleArchive');
});
