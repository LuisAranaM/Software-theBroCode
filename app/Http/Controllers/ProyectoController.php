<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class ProyectoController extends Controller
{
    public function index(){
    	return view('proyecto.index');
    }

    public function store(Request $request){
    	$file = $request->file('archivo');
    	$file->storePubliclyAs('upload', 'filename');
    	return back();
    }
}
