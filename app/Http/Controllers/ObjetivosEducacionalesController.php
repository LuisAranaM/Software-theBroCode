<?php

namespace App\Http\Controllers;

use App\Entity\Sos as eSos;
use App\Entity\Eos as eEos;
use App\Entity\SosHasEos;
use App\Entity\Semestre;
use App\Entity\Resultado as eResultado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class ObjetivosEducacionalesController extends Controller
{
    public function objetivosGestion() {    
        $resultados = eResultado::getResultados()->toArray();
        return view('objetivos.objetivos')
        ->with('casillasChecks',SosHasEos::getSosHasEos())
        ->with('objetivosEstudiante',$resultados)
        ->with('objetivosEducacionales',eEos::getObjetivosEducacionales());
    }
     public function objetivosGestionTablas() { 

        $objetivosSos=[];
        $objetivosSos = eSos::getObjetivosTotales()->toArray();
        $objetivosEos=[];
        $objetivosEos = eEos::getObjetivosTotales()->toArray();

        return view('objetivos.objetivosGestion')
        ->with('objetivosEstudiante',eSos::getObjetivosEstudiante())
        ->with('objetivosEducacionales',eEos::getObjetivosEducacionales())
        ->with('objetivosSos',$objetivosSos)
        ->with('semestres', Semestre::getSemestres())
        ->with('objetivosEos',$objetivosEos);
    }
    
    public function informacionObj(Request $request){

        $objsos=eSos::getinformacionObj($request->get('idSemestre'));
        return $objsos;
    }


    public function copiarObj(Request $request){
        
        $obj = new eSos();           
        
        if($obj->copiarObj($request->get('idSemestreConfirmado'),Auth::id())){
            flash('Se copió la configuración correctamente')->success();
        } else {
            flash('Hubo un error al copiar la configuración')->error();
        }
        return back();
    }

    public function objetivosGuardar(Request $request) {  
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

        if($sos->eliminarSos($request->get('IDSOS'),$request->get('nombreSOS'),Auth::id())){
            flash('Se eliminó el objetivo correctamente')->success();
        } else {
            flash('Hubo un error')->error();
        }
        return back();
     }


     public function eliminarEos(Request $request){
        $eos=new eEos();

        if($eos->eliminarEos($request->get('IDEOS'),$request->get('nombreEOS'),Auth::id())){
            flash('Se eliminó el objetivo correctamente')->success();
        } else {
            flash('Hubo un error')->error();
        }
        return back();
     }

     public function editarSos(Request $request){
        $sos=new eSos();
        if($sos->editarSos($request->get('IDSOS'),$request->get('nombreSOS'),Auth::id())){
        
        } else {
            flash('Hubo un error')->error();
        }
        return back();
     }
     
     public function editarEos(Request $request){
        $eos=new eEos();
        if($eos->editarEos($request->get('IDEOS'),$request->get('nombreEOS'),Auth::id())){
        
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
     
     public function agregarEos(Request $request){
        $eos=new eEos();

        if($eos->agregarEos($request->get('txtEos'),Auth::id())){
        } else {
            flash('Hubo un error')->error();
        }
        return back();
     }  

}
