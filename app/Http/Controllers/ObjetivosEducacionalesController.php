<?php

namespace App\Http\Controllers;

use App\Entity\Sos as eSos;
use App\Entity\Eos as eEos;
use App\Entity\SosHasEos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class ObjetivosEducacionalesController extends Controller
{
    public function objetivosGestion() {    
    	//dd(eSos::getObjetivosEstudiante(),eEos::getObjetivosEducacionales());
        return view('objetivos.objetivos')
        ->with('casillasChecks',SosHasEos::getSosHasEos())
        ->with('objetivosEstudiante',eSos::getObjetivosEstudiante())
        ->with('objetivosEducacionales',eEos::getObjetivosEducacionales());
    }
     public function objetivosGestionTablas() {    
        //dd(eSos::getObjetivosEstudiante(),eEos::getObjetivosEducacionales());
        return view('objetivos.objetivosGestion')
        //->with('casillasChecks',SosHasEos::getSosHasEos())
        ->with('objetivosEstudiante',eSos::getObjetivosEstudiante())
        ->with('objetivosEducacionales',eEos::getObjetivosEducacionales());
    }

    public function objetivosGuardar(Request $request) {  
    	//dd($request->all());

        $checks=$request->get('checkSosHasEos',null);
        
        $sosEos = new SosHasEos();           
        
        if($sosEos->actualizarObjetivos($checks,Auth::id())){
            flash('Los objetivos educacionales se agregaron correctamente')->success();
        } else {
            flash('Hubo un error al registrar los objetivos educacionales')->error();
        }
        return back();

    }
    
     public function eliminarSos(Request $request){
        $sos=new eSos();

        if($sos->eliminarSos($request->all(),Auth::id())){
            flash('Se eliminó al alumno correctamente')->success();
        } else {
            flash('Hubo un error')->error();
        }
        return back();
     }

     public function editarSos(Request $request){
        $sos=new eSos();
        //dd("HOLA");
        //dd($request->get('IDSOS'));
        if($sos->editarSos($request->get('IDSOS'),$request->get('nombreSOS'),Auth::id())){
        
        } else {
            flash('Hubo un error')->error();
        }
        return back();
     }

     
     public function agregarSos(Request $request){
        $sos=new eSos();

        if($sos->agregarSos($request->get('textSos'),Auth::id())){
            
        } else {
            flash('Hubo un error')->error();
        }
        return back();
     }  
}
