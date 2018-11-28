<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class DropzoneController extends Controller
{
	public function dropzoneGestion(){
		return view('dropzone');
	}	
}