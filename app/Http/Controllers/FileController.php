<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    public function create(){
    	return view('file.dropzone');
    }

    public function dropzone(Request $request){
    	$file = $request->file('file');
    	File::create([
    		'title' => $file->getClientOriginalName(),
    		'description' => 'Upload with dropzone.js',
    		'path' => $file->store('public/storage')
    	]);
    }

}
