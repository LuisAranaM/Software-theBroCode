<?php

namespace App\Http\Controllers;
use App\Entity\PruebaEntity as Prueba;
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
      

      return view('principal')
      ->with('cursos',$cursos);
       		//->with('prueba',Prueba::getPrueba());
  }

    public function cursosGestion() {
      return view('cursos.gestion')
      ->with('cursos',Prueba::getCursos());
    }
	

    public function horariosGestion(Request $request) {  
		//dd($request->all());
		$idCurso=$request->get('id',null);
		$nombreCurso=$request->get('nombre',null);
		$codCurso=$request->get('codigo',null);
		//$infoCurso=Prueba::getInformacionCurso($idCurso);
		//$infoCurso trae la información principal del curso en un arreglo	
        return view('cursos.horarios')
		->with('nombreCurso',$nombreCurso)
		->with('codCurso',$codCurso)
		->with('horario',Prueba::getHorarios($idCurso));
    }	

    public function progresoGestion() {    		
  		$horarios=[];
  		$cursos = Prueba::getCursos();
  		foreach ($cursos as $curso){
  			$idCurso = $curso->ID_CURSO;
  			$horarios[$idCurso] = Prueba::getHorarios($idCurso);
  		}
          return view('cursos.progreso')
        		->with('idCurso',$idCurso)
        		->with('horarios',$horarios)
        		->with('cursos',Prueba::getCursos());
    }

    public function reportesGestion() {    
        return view('reportes.reportes');
    }

    public function administrador() {    
        return view('administrador.principal');
    }

    public function coordinador() {    
        return view('coordinador.principal');
    }

    public function asistente() {    
        return view('asistente.principal');
    }

    public function profesor() {    
        return view('profesor.principal');
    }

    public function rubricasGestion() {
        return view('rubricas.gestion');
    }
}
