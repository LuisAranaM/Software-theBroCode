<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class pruebaController extends Controller {

    public function index() {
    	$cursos=[];
    	$curso1=array();
    	$curso1=[
    		'CODIGO'=>"INF226",
    		'CURSO'=>"Desarrollo de Programas 1",
    		'AVANCE'=>10,
    		'TOTAL'=>30,
    		'PROFESOR'=>"Dávila Ramón, Abraham Eliseo"
    		];
    	$curso2=array();
    	$curso2=[
    		'CODIGO'=>"INF227",
    		'CURSO'=>"Desarrollo de Programas 2",
    		'AVANCE'=>17,
    		'TOTAL'=>30,
    		'PROFESOR'=>"Aguilera Serpa, César Augusto"
    		];
    	$curso3=array();
    	$curso3=[
    		'CODIGO'=>"ING220",
    		'CURSO'=>"Ética Profesional",
    		'AVANCE'=>10,
    		'TOTAL'=>20,
    		'PROFESOR'=>"Ríos Alejos, Luis Esteban"
    		];
    	$cursos[0]=$curso1;
    	$cursos[1]=$curso2;
    	$cursos[2]=$curso3;
    	//dd($cursos);
        return view('principal')
        	->with('cursos',$cursos)
       		->with('nombreUsuario',"Luis Flores");
    }

}
