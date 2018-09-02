<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class pruebaController extends Controller {

    public function index() {
       return view('pruebaLayout')
       ->with('variable1',1);
    }

}
