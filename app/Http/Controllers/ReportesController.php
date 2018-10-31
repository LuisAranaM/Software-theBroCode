<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entity\Indicador as Indicador;
class ReportesController extends Controller
{
    //
	function mostrarReporte(Request $request){
		$filtros=[];
		$reporte=Indicador::getReportes($filtros);
	}
}
