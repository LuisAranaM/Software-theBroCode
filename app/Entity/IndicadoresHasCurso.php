<?php

namespace App\Entity;

use \Illuminate\Pagination\LengthAwarePaginator as Paginator;
use App\Models\IndicadoresHasCurso as mIndicadoresHasCurso;
use App\Models\Curso as mCurso;
use App\Models\Resultado as mResultado;
use App\Models\Indicador as mIndicador;
use Jenssegers\Date\Date as Carbon;
use Excel;

class IndicadoresHasCurso extends \App\Entity\Base\Entity {

	protected $_fechaRegistro;
    
    function setProperties($data) {
        $this->setValues([
            '_fechaRegistro' => $data->FECHA_REGISTRO,
        ]);
    }

    static function getCantIndicadoresByCurso($idCurso, $idSemestre){
        return mIndicadoresHasCurso::getCantIndicadoresByCurso($idCurso, $idSemestre);
    }

    function setValueToTable() {
        return $this->cleanArray([
            'FECHA_REGISTRO' => $this->_fechaRegistro,
        ]);
    }

    static function getIndicadoresbyIdCurso($idCurso) {
        $model = new mIndicadoresHasCurso();
        return mIndicadoresHasCurso::getIndicadoresbyIdCurso($idCurso,self::getIdSemestre(),self::getEspecialidadUsuario())->get();
    }
    
    static function getCursosByIdIndicador($idIndicador) {
        $model = new mIndicadoresHasCurso();
        return mIndicadoresHasCurso::getCursosByIdIndicador($idIndicador,self::getIdSemestre(),self::getEspecialidadUsuario())->get();
    }

    static function actualizarIndicadoresCurso($idIndicadores,$estadoIndicadores,$idCurso, $id){
        //dd($idIndicadores,$estadoIndicadores,$idCurso, $id);
        $model = new mIndicadoresHasCurso();
        if ($model->actualizarIndicadoresCurso($idIndicadores,$estadoIndicadores,$idCurso, $id,self::getEspecialidadUsuario(),self::getIdSemestre())){
            return true;
        }else{
            //$this->setMessage('Hubo un error en el servidor de base de datos');
            return false;
        }
    }

    static function getIndicadoresByCursos(){
        $final = [];
        $cursos = mCurso::getCursos(self::getIdSemestre(),self::getEspecialidadUsuario())->get();
        //dd($cursos);
        foreach ($cursos as $curso){
            $cursoTemp= [];
            //dd($curso->ID_CURSO);
            array_push($cursoTemp, $curso->CODIGO_CURSO, $curso->NOMBRE);
            $resultadosTemp = [];
            $resultadosTemp = mResultado::getResultadosByCurso($curso->ID_CURSO,self::getIdSemestre(),self::getEspecialidadUsuario())->get();            
            $resultados = [];
            foreach($resultadosTemp as $resultado){
                $resultadoTemp = [];
                array_push($resultadoTemp,$resultado->NOMBRE,$resultado->DESCRIPCION);
                
                $indicadoresTemp = [];
                $indicadoresTemp = mIndicador::getIndicadoresbyResultadoOrdenado($resultado->ID_RESULTADO,self::getIdSemestre(),self::getEspecialidadUsuario())->get();
                $indicadores = [];
                foreach ($indicadoresTemp as $indicador) {
                    $indicadorTemp = [];
                    array_push($indicadorTemp,$indicador->VALORIZACION,$indicador->NOMBRE);
                    $existe = mIndicadoresHasCurso::getindicadorbyIdCurso($indicador->ID_INDICADOR,$curso->ID_CURSO,self::getIdSemestre(),self::getEspecialidadUsuario())->first();
                    if(!$existe) array_push($indicadorTemp,0);
                    else array_push($indicadorTemp,1);

                    array_push($indicadores,$indicadorTemp);
                }
                array_push($resultadoTemp,$indicadores);


                array_push($resultados,$resultadoTemp);
            }
            array_push($cursoTemp,$resultados);
            array_push($final,$cursoTemp);
        }
        return $final;
    }

    static function generarExcelIndicadoresByCurso(){
        //dd("HOLI");
        $cursos=self::getIndicadoresByCursos();
        //dd($cursos);
        /*foreach ($cursos as $curso) {
            dd($curso);
            # code...
        }*/


        $nombreEspecialidad=self::getNombreEspecialidadUsuario();
        $semestre=self::getSemestreByIdSemestre(self::getIdSemestre());
        $nombreExcel='Mapeo_Cursos_'.$nombreEspecialidad.'_'.$semestre;

        Excel::create($nombreExcel, function($excel) use ($nombreEspecialidad,$semestre,$cursos){
            
            $excel->setTitle('Mapeo de indicadores');
            $excel->sheet('CURSOS VS INDICADORES', function($sheet) use ($cursos){
                /*$sheet->setColumnFormat(array('D' => '0%','E' => '0%'));
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
                if(!empty($reporte)){
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
                }
                $sheet->cells('A2:E1000', function($cells) {   
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                });*/
            });
        })->download('xlsx');
    }


    
}