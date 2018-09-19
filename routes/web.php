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
Route::get('/welcome', function () {
    return view('welcome');
});

/*LOGIN*/
Route::get('/', function () {
    return view('login')
    	->with('nombreSistema','NINJA SYSTEM');
});

Route::get('/logout', ['as' => 'logout', 'uses' => 'LoginController@logout']);
Route::get('/login', ['as' => 'login.index', 'uses' => 'LoginController@index']);

Route::get('/prueba', ['as'=>'prueba','uses'=>'PruebaController@index']);

