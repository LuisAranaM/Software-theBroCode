<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entity\Indicador as Indicador;
class ReportesController extends Controller
{
	//Grafico1
	function graficoReporteResultadosCiclo(Request $request){
		//flash('Se ha generado el reporte de resultados por ciclo correctamente.')->success();
		return Indicador::graficoReporteResultadosCiclo($request->get('idSemestre'));
	}

	//Grafico1
	function graficoResultadosxCurso(Request $request){
		//flash('Se ha generado el reporte de resultados por ciclo correctamente.')->success();
		return Indicador::graficoReporteResultadosCurso($request->get('idSemestre'),$request->get('idCurso'));
	}

	function exportarReporteResultadosCiclo(Request $request){
		$filtros=[];
		$reporte=Indicador::getReporteResultadosCiclo($filtros);
		flash('Se ha generado el reporte de resultados por ciclo correctamente.')->success();
		return back();
	}

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
