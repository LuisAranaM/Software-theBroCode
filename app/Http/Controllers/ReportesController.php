<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entity\Indicador as Indicador;
class ReportesController extends Controller
{
    //
	function exportarReporteCursosResultado(Request $request){
		$filtros=[];
		$reporte=Indicador::getReporteCursosResultado($filtros);
		flash('Las cursos a acreditar se registraron correctamente.')->success();
		return back();
	}

	function exportarReporteConsolidado(Request $request){
		$filtros=[];
		$reporte=Indicador::getReporteConsolidado($filtros);
		flash('Las cursos a acreditar se registraron correctamente.')->success();
		return back();
	}
}
