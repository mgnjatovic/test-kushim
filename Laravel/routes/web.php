<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'GroupsController@index')->name('index');

Route::get('/groups', 'GroupsController@index')->name('index');
Route::get('/group/{id}', 'GroupsController@show')->name('index');
Route::get('/group/create', 'GroupsController@create')->name('create');
Route::get('/group/{id}/edit', 'GroupsController@edit')->name('create');

Route::get('/contacts', 'ContactsController@index')->name('home');
Route::get('/contact/create', 'ContactsController@create')->name('create');
Route::get('/contact/{id}', 'ContactsController@edit')->name('create');
