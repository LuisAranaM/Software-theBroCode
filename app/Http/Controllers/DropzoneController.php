<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Entity\IndicadoresHasCurso as IhC;
use App\Entity\Resultado as Resultado;

class DropzoneController extends Controller
{
	public function dropzoneGestion(){
		return view('dropzone');
	}	

	public function getcursosxind(Request $request){
		//dd("holis");
		Ihc::getResultadosByIndicadores();

	}

	public function logRubrica(Request $request){
		$rubrica=Resultado::cambiosRubricas();
        return $rubrica;
	}
}