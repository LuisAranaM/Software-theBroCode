<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class cursosController extends Controller
{
    //
    public function index(){

    }
    public function store(Request $request){
    	Cursos::create
    }
}
