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
    	->with('nombreSistema','RubriK');
});

Route::get('/logout', ['as' => 'logout', 'uses' => 'LoginController@logout']);
Route::get('/login', ['as' => 'login.index', 'uses' => 'LoginController@index']);

Route::get('/prueba', ['as'=>'prueba','uses'=>'PruebaController@index']);
Route::get('/cursos/gestion', ['as'=>'cursos.gestion','uses'=>'PruebaController@cursosGestion']);
Route::get('/cursos/horarios', ['as'=>'cursos.horarios','uses'=>'PruebaController@horariosGestion']);
Route::get('/cursos/progreso', ['as'=>'cursos.progreso','uses'=>'PruebaController@progresoGestion']);

Route::get('/cursos/reportes', ['as'=>'cursos.reportes','uses'=>'PruebaController@reportesGestion']);




