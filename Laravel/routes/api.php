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

Route::resource('groups', 'Api\GroupController')
    ->only(['index', 'edit', 'store']);

Route::get('groups/{group}/remove', 'Api\GroupController@destroy');
Route::get('groups/{group}', 'Api\GroupController@show');

Route::resource('contacts', 'Api\ContactController')
    ->only(['index', 'edit', 'store']);

Route::get('contacts/{contact}/remove', 'Api\ContactController@destroy');
Route::get('contacts/{contact}', 'Api\ContactController@show');

Route::get('group/{group}/contacts/', 'Api\ContactController@contacts');