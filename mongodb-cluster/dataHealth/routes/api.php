<?php

use Illuminate\Http\Request;

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

Route::get('/data/{facility_name}', 'DataHealthController@list');
Route::post('/data/create', 'DataHealthController@create');
Route::post('/data/update', 'DataHealthController@update');
Route::post('/data/delete', 'DataHealthController@delete');

Route::get('data/max','DataHealthController@max');