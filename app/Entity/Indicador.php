<?php

namespace App\Entity;

use \Illuminate\Pagination\LengthAwarePaginator as Paginator;
use App\Models\Indicador as mIndicador;
use Jenssegers\Date\Date as Carbon;

use Excel;

class Indicador extends \App\Entity\Base\Entity {

	protected $_idCriterio;
    protected $_idEspecialidad;
    protected $_idSemestre;
    protected $_nombre;
    protected $_desc1;
    protected $_desc2;
    protected $_desc3;
    protected $_desc4;
    protected $_fechaRegistro;
    protected $_fechaActualizacion;
    protected $_usuarioModif;
    protected $_estado;
    
    public function setFromAuth($indicador) {
        $this->setValue('_idCategoria',$indicador->ID_CATEGORIA);
        $this->setValue('_idEspecialidad',$indicador->ID_ESPECIALIDAD);
        $this->setValue('_idSemestre',$indicador->ID_SEMESTRE);
        $this->setValue('_nombre',$indicador->NOMBRE);
        $this->setValue('_fechaRegistro',$indicador->FECHA_REGISTRO);
        $this->setValue('_fechaActualizacion',$indicador->FECHA_ACTUALIZACION);
        $this->setValue('_usuarioModif',$indicador->USUARIO_MODIF);
        $this->setValue('_estado',$indicador->ESTADO);        
    }   

    static function insertIndicador($idCat,$nombre,$orden){
        $model =new mIndicador();
        return $model->insertIndicador($idCat,$nombre,$orden,self::getIdSemestre(),self::getEspecialidadUsuario());
    }
    static function getIndicadoresByRes($idRes){
        $model =new mIndicador();
        return $model::getIndicadoresByRes($idRes)->get();
    }
    static function getIndicadoresId($idCat){
        $model =new mIndicador();
        return $model::getIndicadoresId($idCat)->get();
    }
    static function getIndicadores(){
        $model =new mIndicador();
        return $model::getIndicadores(self::getIdSemestre(),self::getEspecialidadUsuario())->get();
    }
    static function getIndicadorId($idInd){
        $model =new mIndicador();
        return $model::getIndicadorId($idInd)->get();
    }
    static function updateIndicador($id, $nombre, $orden){
        $model =new mIndicador();
        return $model::updateIndicador($id, $nombre, $orden);
    }
    static function deleteIndicador($id){
        $model =new mIndicador();
        return $model->deleteIndicador($id);
    }
    static function graficoReporteResultadosCiclo($idSemestre){
        $model =new mIndicador();
        return $model->getDataGraficoReporteResultadosCiclo($idSemestre,self::getEspecialidadUsuario())->get();   
    }

    static function graficoReporteResultadosCurso($idSemestre,$idCurso){
        $model =new mIndicador();
        return $model->getDataGraficoResultadosxCurso($idSemestre,$idCurso,self::getEspecialidadUsuario())->get();
    }

    static function getReporteResultadosCiclo($filtros){
        $model =new mIndicador();
        $nombreEspecialidad=self::getNombreEspecialidadUsuario();
        $semestre=self::getSemestre();
        $nombreExcel='Reporte_Resultados_Ciclo_'.$nombreEspecialidad.'_'.$semestre;

        $reporte=$model->exportarReporteResultadosCiclo($filtros,self::getIdSemestre(),self::getEspecialidadUsuario())->get();
        //dd($reporte);
        //dd($nombreExcel);
        Excel::create($nombreExcel, function($excel) use ($semestre,$reporte){
            
            $excel->setTitle('Reporte Resultados del semestre '.$semestre);
            $excel->sheet('Reporte Resultados del Semestre', function($sheet) use ($semestre,$reporte){
                $sheet->setColumnFormat(array('D' => '0%','E' => '0%'));
                $sheet->getStyle('A2:H1000')->getAlignment()->setWrapText(true);
                $sheet->cells('A2:H1000', function($cells) {
                    $cells->setFontFamily('Arial');
                    $cells->setFontSize(11);

                });
                //Consideraciones previas
                //$sheet->setAutoSize(true);
                $sheet->mergeCells('B2:E2');
                
                $i=2;
                $sheet->setWidth(array(
                                        'A'     =>  5,
                                        'B'     =>  25,
                                        'C'     =>  45,
                                        'D'     =>  15,
                                        'E'     =>  15,
                                    ));

                $sheet->setHeight($i, 30);
                $sheet->row($i++, array('','REPORTE: RESULTADOS DEL SEMESTRE '.$semestre));
                $sheet->cells('B2:E2', function($cells) {    // manipulate the cell
                            $cells->setFontSize(20);
                            $cells->setFontWeight('bold');
                            $cells->setAlignment('center');
                            $cells->setValignment('center');

                });

                $codResultado = "";
                $nombreCategoria = "";
                $filaInicialCat = 6;
                $filaFinalCat = 6;
                $filaInicial = 4;
                $filaFinal = 4;
                $nIndicadores = 0;
                $porcentajeAcumulado = 0;
                $style = array('font' => array('size' => 15,'bold' => true));

                foreach ($reporte as $fila) {
                    if($codResultado!=$fila->COD_RESULTADO){
                        //solo la primera fila no lo hará, las siguientes verificarán si el 
                        if($i!=3){
                            $sheet->mergeCells('B'.$filaInicialCat.':B'.($filaFinalCat-1));
                            $sheet->mergeCells('E'.$filaInicial.':E'.($filaFinal-1));  
                            $sheet->setBorder('B'.($filaInicial-3).':E'.($filaFinal-1), 'thin');
                            $sheet->getStyle("D".$filaInicial.":G".($filaFinal-1))->applyFromArray($style);
                            
                            $porcentajetotal=round($porcentajeAcumulado/$nIndicadores,4);
                            $sheet->setCellValue('E'.$filaInicial,$porcentajetotal);
                            $sheet->cell('E'.$filaInicial, function($color){$color->setBackground('#FF0000');});
                            if($porcentajetotal<0.70) $sheet->cell('E'.$filaInicial, function($color){$color->setBackground('#FF0000');});
                            else if($porcentajetotal<0.85) $sheet->cell('E'.$filaInicial, function($color){$color->setBackground('#FFFF00');});
                            else $sheet->cell('E'.$filaInicial, function($color){$color->setBackground('#00FF00');});
                            $i++;
                        }
                        $nIndicadores = 0;
                        $porcentajeAcumulado = 0;
                        $sheet->cells('B'.$i.':E'.($i+1), function($cells) {
                            $cells->setBackground('#D8D8D8');
                            $cells->setAlignment('center');
                            $cells->setValignment('center');
                            $cells->setFontSize(14);
                            $cells->setFontWeight('bold');
                        });
                        $sheet->mergeCells('B'.$i.':E'.$i);
                        $sheet->row($i++, array("",$fila->COD_RESULTADO));
                        $sheet->mergeCells('B'.$i.':E'.$i);
                        $sheet->getRowDimension($i)->setRowHeight(-1);
                        $sheet->row($i++, array("",$fila->NOMBRE_RESULTADO));
                        $sheet->setHeight($i, 30);
                        $sheet->cells('B'.$i.':E'.$i,  function($cells) {
                            $cells->setBackground('#000066');
                            $cells->setFontColor('#FFFFFF');
                            $cells->setFontWeight('bold');
                            $cells->setAlignment('center');
                            $cells->setValignment('center');

                        });
                        $sheet->row($i++, array("","Categoría", "Indicador","Promedio Indicador %","Promedio Resultado %"));
                        $filaInicial=$i;
                        $filaInicialCat=$i;
                    }
                    else if($nombreCategoria!=$fila->NOMBRE_CATEGORIA){
                        
                        //solo la primera fila del resultado no lo hará, las siguientes verificarán si el 
                        
                        if($i!=$filaInicial){
                            //dd($i,$filaInicialCat,$filaInicial,$filaFinalCat);
                            $sheet->mergeCells('B'.$filaInicialCat.':B'.($filaFinalCat-1));
                            //$sheet->setBorder('B'.($filaInicial-3).':E'.($filaFinal-1), 'thin');
                            //$filaInicialCat=$i;
                        }
                        $filaInicialCat=$i;
                    }
                    $sheet->row($i, array('',$fila->NOMBRE_CATEGORIA, $fila->COD_RESULTADO.$fila->VALORIZACION.'. '.$fila->NOMBRE_INDICADOR,
                                $fila->PORCENTAJE_PONDERADO));
                    $sheet->setHeight($i, 45);
                    $i++;
                    $codResultado = $fila->COD_RESULTADO;
                    $nombreCategoria = $fila->NOMBRE_CATEGORIA;
                    $filaFinal=$i;
                    $filaFinalCat=$i;
                    $nIndicadores++;
                    $porcentajeAcumulado += $fila->PORCENTAJE_PONDERADO;
                }
                $sheet->mergeCells('B'.$filaInicialCat.':B'.($filaFinalCat-1));
                $sheet->mergeCells('E'.$filaInicial.':E'.($filaFinal-1));
                $porcentajetotal=round($porcentajeAcumulado/$nIndicadores,4);
                $sheet->setCellValue('E'.$filaInicial,$porcentajetotal);
                if($porcentajetotal<0.70) $sheet->cell('E'.$filaInicial, function($color){$color->setBackground('#FF0000');});
                else if($porcentajetotal<0.85) $sheet->cell('E'.$filaInicial, function($color){$color->setBackground('#FFFF00');});
                else $sheet->cell('E'.$filaInicial, function($color){$color->setBackground('#00FF00');}); 
                $sheet->setBorder('B'.($filaInicial-3).':E'.($filaFinal-1), 'thin');   
                //dd('A'.$filaInicial.':A'.($filaFinal-1));
                $sheet->getStyle("D".$filaInicial.":G".($filaFinal-1))->applyFromArray($style);
                //Centrado
                $sheet->cells('A2:G1000', function($cells) {   
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                });
            });
        })->download('xlsx');
    }

    static function getReporteCursosResultado($filtros){
        $model =new mIndicador();
        $nombreEspecialidad=self::getNombreEspecialidadUsuario();
        $semestre=self::getSemestre();
        $nombreExcel='Reporte_Cursos_Resultado_'.$nombreEspecialidad.'_'.$semestre;

        $reporte=$model->getReporteCursosResultado($filtros,self::getIdSemestre(),self::getEspecialidadUsuario())->get();
        //dd($reporte);
        //dd($nombreExcel);
        Excel::create($nombreExcel, function($excel) use ($semestre,$reporte){
            $excel->setTitle('Reporte Resultados por Curso del semestre '.$semestre);
            $excel->sheet('Reporte Resultados del Semestre', function($sheet) use ($semestre,$reporte){

                $sheet->setColumnFormat(array('H' => '0%'));
                $sheet->getStyle('A2:H1000')->getAlignment()->setWrapText(true);
                $sheet->cells('A2:H1000', function($cells) {
                    $cells->setFontFamily('Arial');
                    $cells->setFontSize(11);

                });
                $sheet->mergeCells('B2:H2');
                
                $i=2;
                $sheet->setWidth(array(
                                        'A'     =>  5,
                                        'B'     =>  15,
                                        'C'     =>  30,
                                        'D'     =>  25,
                                        'E'     =>  45,
                                        'F'     =>  30,
                                        'G'     =>  15,
                                        'H'     =>  15,
                                    ));

                $sheet->setHeight($i, 30);
                $sheet->row($i++, array('','REPORTE: RESULTADOS POR CURSOS DEL SEMESTRE '.$semestre));
                $sheet->cells('B2:E2', function($cells) {    // manipulate the cell
                            $cells->setFontSize(20);
                            $cells->setFontWeight('bold');
                            $cells->setAlignment('center');
                            $cells->setValignment('center');
                });
                

                $codResultado="";
                $filaInicial=3;
                $filaFinal=3;
                $filaInicialCat=3;
                $filaFinalCat=3;
                $nombreCategoria="";
                $filaInicialInd=3;
                $filaFinalInd=3;
                $nombreInd="";
                foreach ($reporte as $fila) {
                    if($codResultado!=$fila->COD_RESULTADO){
                        //dd($fila,'A'.$filaInicial.':A'.$filaFinal);
                        if($i!=3){
                            $sheet->mergeCells('E'.$filaInicialInd.':E'.($filaFinalInd-1));
                            $sheet->mergeCells('D'.$filaInicialCat.':D'.($filaFinalCat-1));
                            $sheet->mergeCells('B'.$filaInicial.':B'.($filaFinal-1));
                            $sheet->mergeCells('C'.$filaInicial.':C'.($filaFinal-1));
                            $i++;
                        }
                        $sheet->cells('B'.$i.':H'.$i,  function($cells) {
                            $cells->setBackground('#000066');
                            $cells->setFontColor('#FFFFFF');
                            $cells->setFontWeight('bold');
                            $cells->setAlignment('center');
                            $cells->setValignment('center');
        
                        });
                        $sheet->row($i++, array("","Código","Resultado","Categoría", "Indicador",
                            "Curso","Promedio","Aprobados %"));
                        
                        $filaInicial=$i;
                        $filaInicialCat=$i;
                        $filaInicialInd=$i;
                    }
                    else if($nombreCategoria!=$fila->NOMBRE_CATEGORIA){
                        //solo la primera fila del resultado no lo hará, las siguientes verificarán si el 
                        if($i!=$filaInicial){
                            $sheet->mergeCells('E'.$filaInicialInd.':E'.($filaFinalInd-1));
                            $sheet->mergeCells('D'.$filaInicialCat.':D'.($filaFinalCat-1));
                        }
                        $filaInicialCat=$i;
                        $filaInicialInd=$i;
                    }
                    else if($nombreInd!=$fila->NOMBRE_INDICADOR){
                        //solo la primera fila del resultado no lo hará, las siguientes verificarán si el 
                        if($i!=$filaInicialCat){
                            $sheet->mergeCells('E'.$filaInicialInd.':E'.($filaFinalInd-1));
                        }
                        $filaInicialInd=$i;
                    }
                    
                    
                    $sheet->row($i, array("",$fila->COD_RESULTADO,$fila->NOMBRE_RESULTADO,$fila->NOMBRE_CATEGORIA, $fila->NOMBRE_INDICADOR,
                            $fila->NOMBRE_CURSO,$fila->PROMEDIO_CALIF,$fila->PORCENTAJE_APROBADOS));
                    $sheet->setHeight($i, 45);
                    $i++;
                    $codResultado=$fila->COD_RESULTADO;
                    $nombreCategoria = $fila->NOMBRE_CATEGORIA;
                    $nombreInd = $fila->NOMBRE_INDICADOR;
                    $filaFinal=$i;
                    $filaFinalCat=$i;
                    $filaFinalInd=$i;
                }  
                $sheet->mergeCells('E'.$filaInicialInd.':E'.($filaFinalInd-1));
                $sheet->mergeCells('D'.$filaInicialCat.':D'.($filaFinalCat-1));
                $sheet->mergeCells('B'.$filaInicial.':B'.($filaFinal-1));
                $sheet->mergeCells('C'.$filaInicial.':C'.($filaFinal-1));
                
                //Centrado
                $sheet->cells('A2:G1000', function($cells) {   
                            $cells->setAlignment('center');
                            $cells->setValignment('center');
                });
            });
        })->download('xlsx');
        //flash('El reporte se generó correctamente')->success();
        //return back();
    }

     static function getReporteConsolidado($filtros){
        $model =new mIndicador();
        $nombreEspecialidad=self::getNombreEspecialidadUsuario();
        $semestre=self::getSemestre();
        $nombreExcel='Reporte_Consolidado_'.$nombreEspecialidad.'_'.$semestre;

        $reporte=$model->getReporteCursosResultado($filtros,self::getIdSemestre(),self::getEspecialidadUsuario())->get();
        //dd($reporte);
        //dd($nombreExcel);
        Excel::create($nombreExcel, function($excel) use ($semestre,$reporte){
            $excel->setTitle('Reporte Consolidado del semestre '.$semestre);
            $excel->sheet('Reporte Resultados del Semestre', function($sheet) use ($semestre,$reporte){
                //Consideraciones previas
                //$sheet->setAutoSize(true);
                $sheet->mergeCells('A1:G1');
                $sheet->setColumnFormat(array('G' => '0%'));
                $i=1;
                $sheet->setWidth(array(
                                        'A'     =>  15,
                                        'B'     =>  30,
                                        'C'     =>  30,
                                        'D'     =>  30,
                                        'E'     =>  30,
                                        'F'     =>  15,
                                        'G'     =>  15
                                    ));


                $sheet->row($i++, array('Reporte Consolidado del semestre '.$semestre));
                $sheet->cells('A1:G1', function($cells) {    // manipulate the cell
                            $cells->setBackground('#EDFC00');
                            $cells->setFontSize(20);
                            $cells->setFontWeight('bold');
                            $cells->setAlignment('center');
                            $cells->setValignment('center');

                });

                $codResultado="";
                $filaInicial=3;
                $filaFinal=3;
                foreach ($reporte as $fila) {
                    if($codResultado!=$fila->COD_RESULTADO){
                        //dd($fila,'A'.$filaInicial.':A'.$filaFinal);
                        if($i!=2){
                            $sheet->mergeCells('A'.$filaInicial.':A'.($filaFinal-1));
                            $sheet->mergeCells('B'.$filaInicial.':B'.($filaFinal-1));
                            $i++;
                        }
                        $sheet->row($i++, array("Código","Resultado","Categoría", "Indicador",
                            "Curso","Promedio","Aprobados %"));
                        $filaInicial=$i;
                    }
                    $sheet->row($i, array($fila->COD_RESULTADO,$fila->NOMBRE_RESULTADO,$fila->NOMBRE_CATEGORIA, $fila->NOMBRE_INDICADOR,
                            $fila->NOMBRE_CURSO,$fila->PROMEDIO_CALIF,$fila->PORCENTAJE_APROBADOS));
                    $sheet->setHeight($i, 45);
                    $i++;
                    $codResultado=$fila->COD_RESULTADO;
                    $filaFinal=$i;
                }  
                $sheet->mergeCells('A'.$filaInicial.':A'.($filaFinal-1));
                $sheet->mergeCells('B'.$filaInicial.':B'.($filaFinal-1));
                //dd('A'.$filaInicial.':A'.($filaFinal-1));
                
                //Centrado
                $sheet->cells('A2:G1000', function($cells) {   
                            $cells->setAlignment('center');
                            $cells->setValignment('center');

                });
            });
        })->download('xlsx');
        //flash('El reporte se generó correctamente')->success();
        //return back();
    }

    static function getInfoResultadoAlumno($idResultado,$idCurso,$idAlumno,$idHorario){
        $model =new mIndicador();
        $reporte=$model->getInfoResultadoAlumno($idResultado,$idCurso,$idAlumno,$idHorario,self::getIdSemestre(),self::getEspecialidadUsuario())->get();
        //dd($reporte);
        //Debemos armar un arreglo de indicadores y dentro de cada indicador colocar sus descripciones
        $i=0;
        $idIndicador=null;
        $nombreIndicador=null;

        $valIndicador=null;

        $indicadores=[];

        foreach ($reporte as $fila) {
            if($i==0){
                //Primera fila
                $idIndicador=$fila->ID_INDICADOR;
                $nombreIndicador=$fila->NOMBRE_INDICADOR;

                $valIndicador=$fila->VALORIZACION_INDICADOR;

                $descripcionesAlumno=[];                
            }
            else{
                if($idIndicador!=$fila->ID_INDICADOR){
                    array_push($indicadores,['ID_INDICADOR'=>$idIndicador,

                                'NOMBRE_INDICADOR'=>$nombreIndicador,'VALORIZACION_INDICADOR'=>$valIndicador,'DESCRIPCIONES'=>$descripcionesAlumno]);
                    $idIndicador=$fila->ID_INDICADOR;
                    $nombreIndicador=$fila->NOMBRE_INDICADOR;
                    $valIndicador=$fila->VALORIZACION_INDICADOR;

                    $descripcionesAlumno=[];
                }

            }
            array_push($descripcionesAlumno,['ID_DESCRIPCION'=>$fila->ID_DESCRIPCION,'NOMBRE_DESCRIPCION'=>$fila->NOMBRE_DESCRIPCION,
                    'VALORIZACION'=>$fila->VALORIZACION,'NOMBRE_VALORIZACION'=>$fila->NOMBRE_VALORIZACION,
                    'ESCALA_CALIFICACION'=>$fila->ESCALA_CALIFICACION,'ID_CATEGORIA'=>$fila->ID_CATEGORIA
                ]);
            $i++;
        }
        //Último elemento
         array_push($indicadores,['ID_INDICADOR'=>$idIndicador,

                                'NOMBRE_INDICADOR'=>$nombreIndicador,'VALORIZACION_INDICADOR'=>$valIndicador,
                                'DESCRIPCIONES'=>$descripcionesAlumno]);

        return $indicadores;
    }

    
}