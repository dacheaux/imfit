<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "Api" middleware group. Enjoy building your API!
|
*/

Route::get('entrancesCount', 'Api\Admin\EntryApiController@getEntrances')->name('api.entrances');


Route::get('entrances', 'Api\EntryController@index');
Route::post('entrances', 'Api\EntryController@checkEntry');

Route::get('doors', 'Api\DoorController@checkDoor');
Route::post('doors', 'Api\DoorController@postDoor');

//Route::post('entry', 'Api\EntryController@postEntry');

Route::middleware('auth:Api')->get('/user', function (Request $request) {
    return $request->user();
});


