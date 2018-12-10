<?php

namespace App\Http\Controllers;


use App\Entity\Base\Entity;
use App\Entity\Proyecto as eProyecto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use DB;


class ProyectoController extends Controller
{
    public function index(){
    	return view('proyecto.index');
    }

    public function storeMasivo(Request $request){
        
        $proyectos=new eProyecto();
        if($request->file('archivos')==NULL){
            flash('No se seleccionaron archivos para subir')->error();
            return back();
        }
        
        if($proyectos->agregarMasivo($request->all(),Auth::id())){
            flash('Los proyectos se registraron correctamente.')->success();
        } else {
            flash('Hubo un error al registrar los proyectos')->error();
        }
        return back();

    }

}
