<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Entity\Base\Entity;
use App\Entity\Curso as eCurso;
use App\Entity\Horario as eHorario;
use App\Entity\Resultado as eResultado;
use App\Entity\Categoria as eCategoria;
use App\Entity\Indicador as eIndicador;
use App\Entity\IndicadoresHasCurso as eIndicadoresHasCurso;
use App\Entity\IndicadoresHasAlumnosHasHorarios as eIndicadoresHasAlumnosHasHorarios;

use DB;
use App\Entity\Usuario as Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;

use Illuminate\Support\Facades\Redirect;

use Excel;
use Validator;
class ExportExcelController extends Controller
{
    public function generarReporteResultadosPorSemestreEspecialidad()
    {
        $customer_array[] = array('Customer Name', 'Address', 'City', 'Postal Code', 'Country');

        $clean[] = array(
        'Customer Name'  => '$customer->CustomerName',
        'Address'   => '$customer->Address',
        'City'    => '$customer->City',
        'Postal Code'  => '$customer->PostalCode',
        'Country'   => '$customer->Country'
        );
        Excel::create('Reporte Resultados del Semestre', function($excel) use ($customer_array){
        $excel->setTitle('Reporte Resultados del Semestre');
        $excel->sheet('Reporte Resultados del Semestre', function($sheet) use ($customer_array){
            
            $sheet->row(0, array('MEDICIÓN - INGENIERÍA INFORMÁTICA  2016 - 2'));
            $i = 1;

            $resultados = eResultado::getResultados();
            foreach($resultados as $resultado){
                $sheet->row($i, array($resultado->NOMBRE.' ('.$resultado->DESCRIPCION.')'));
                $sheet->row($i+1, array('Aspecto','Criterio','Promedio %'));
                
                $promedioPuntajeResultado = 0;
                $porcentajeResultado = 0;
                $nIndicadores = 0;
                $nCursosIndicador = 0;
                $i = $i + 2;

                $categorias = eCategoria::getCategoriasId($resultado->ID_RESULTADO);
                foreach($categorias as $categoria){
                    $indicadores = eIndicador::getIndicadoresId($categoria->ID_CATEGORIA);
                    foreach($indicadores as $indicador){
                        $nIndicadores += 1;
                        $cursos = eIndicadoresHasCurso::getCursosByIdIndicador($indicador->ID_INDICADOR);

                        $porcentajeIndicador = 0;
                        $totalAlumnosIndicador = 0; 

                        foreach($cursos as $curso){
                            $horarios = eHorario::getHorarios($curso->ID_CURSO);
                            $puntajetotal = 0;
                            $alumnosPuntaje3y4 = 0;
                            $totalAlumnosCursoIndicador = 0;
                            foreach($horarios as $horario){
                                //dd($indicador->ID_INDICADOR, $horario->ID_HORARIO, $curso->NOMBRE);
                                $valores = eIndicadoresHasAlumnosHasHorarios::getValoresReporte1($indicador->ID_INDICADOR, $horario->ID_HORARIO);
                                $puntajetotal += $valores[0];
                                $alumnosPuntaje3y4 += $valores[1];
                                $totalAlumnosCursoIndicador += $valores[2];
                                //dd($totalAlumnosCursoIndicador);
                            }

                            if($totalAlumnosCursoIndicador>0){
                                $promedioPuntaje = $puntajetotal/$totalAlumnosCursoIndicador;
                                $promedioPuntajeResultado += $promedioPuntaje;
                                $nCursosIndicador += 1;
                                $porcentajeCursoIndicador = $alumnosPuntaje3y4/$totalAlumnosCursoIndicador*100;
                                //Imprimo promedioPuntaje y porcentajeCursoIndicador

                                $porcentajeIndicador += $porcentajeCursoIndicador*$totalAlumnosCursoIndicador;
                                $totalAlumnosIndicador += $totalAlumnosCursoIndicador;
                                //Actualizo valor de porcentajeIndicador y mergeo celda
                                //$sheet->row($i, array($categoria->NOMBRE,$indicador->NOMBRE,$curso->NOMBRE,$promedioPuntaje,$porcentajeCursoIndicador.'%'));
                                //$i += 1;
                            }
                            
                        }
                        if($totalAlumnosIndicador>0){
                            $porcentajeIndicador /= $totalAlumnosIndicador;
                            //Actualizo valor de porcentajeIndicador
                            $porcentajeResultado += $porcentajeIndicador;
                        }
                        $sheet->row($i, array($categoria->NOMBRE,$indicador->NOMBRE,round($porcentajeIndicador,2).'%'));
                        $i += 1;
                    }

                    
                }
                if($nIndicadores>0 && $nCursosIndicador>0){
                    $porcentajeResultado/= $nIndicadores;
                    $promedioPuntajeResultado/= $nCursosIndicador;
                    $sheet->row($i, array('','',round($porcentajeResultado,2).'%'));
                    $i += 1;
                }
                
            }
        });
        })->download('xlsx');
    }
}
