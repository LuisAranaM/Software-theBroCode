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
        $model->deleteIndicador($id);
    }
    static function graficoReporteResultadosCiclo($idSemestre){
        $model =new mIndicador();
        return $model->getDataGraficoReporteResultadosCiclo($idSemestre,self::getEspecialidadUsuario())->get();   
    }
    static function graficoIndicadoresResultado($idSemestre,$idResultado){
        $model =new mIndicador();
        return $model->getDataGraficoIndicadoresResultado($idSemestre,$idResultado,self::getEspecialidadUsuario())->get();   
    }
    //Grafico 2.1
    static function graficoReporteResultadosCurso($idSemestre,$idCurso){
        $model =new mIndicador();
        return $model->getDataGraficoResultadosxCurso($idSemestre,$idCurso,self::getEspecialidadUsuario())->get();
    }
    //Grafico 2.2
    static function graficoReporteIndicadoresCurso($idSemestre,$idCurso, $idResultado){
        $model =new mIndicador();
        return $model->getDataGraficoIndicadoresxCurso($idSemestre,$idCurso,self::getEspecialidadUsuario(),$idResultado)->get();
    }

    static function getReporteResultadosCiclo($filtros, $idSemestre){
        $model =new mIndicador();
        $nombreEspecialidad=self::getNombreEspecialidadUsuario();
        $semestre=self::getSemestreByIdSemestre($idSemestre);
        $nombreExcel='Reporte_Resultados_Ciclo_'.$nombreEspecialidad.'_'.$semestre;
        $reporte=$model->exportarReporteResultadosCiclo($filtros,$idSemestre,self::getEspecialidadUsuario())->get();
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
                            if($porcentajetotal<0.70) $sheet->cell('E'.$filaInicial, function($color){$color->setBackground('#fc3232');});
                            else if($porcentajetotal<0.85) $sheet->cell('E'.$filaInicial, function($color){$color->setBackground('#ffe74d');});
                            else $sheet->cell('E'.$filaInicial, function($color){$color->setBackground('#13d604');});
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
                if(count($reporte)>0){
                    $sheet->mergeCells('B'.$filaInicialCat.':B'.($filaFinalCat-1));
                    $sheet->mergeCells('E'.$filaInicial.':E'.($filaFinal-1));
                    $porcentajetotal=round($porcentajeAcumulado/$nIndicadores,4);
                    $sheet->setCellValue('E'.$filaInicial,$porcentajetotal);
                    if($porcentajetotal<0.70) $sheet->cell('E'.$filaInicial, function($color){$color->setBackground('#fc3232');});
                    else if($porcentajetotal<0.85) $sheet->cell('E'.$filaInicial, function($color){$color->setBackground('#ffe74d');});
                    else $sheet->cell('E'.$filaInicial, function($color){$color->setBackground('#13d604');}); 
                    $sheet->setBorder('B'.($filaInicial-3).':E'.($filaFinal-1), 'thin');   
                    //dd('A'.$filaInicial.':A'.($filaFinal-1));
                    $sheet->getStyle("D".$filaInicial.":G".($filaFinal-1))->applyFromArray($style);
                    //Centrado 
                }
                $sheet->cells('A2:E1000', function($cells) {   
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                });
            });
        })->download('xlsx');
    }
    //Reporte 2
    static function getReporteCursosResultado($filtros, $idSemestre){
        $model =new mIndicador();
        $nombreEspecialidad=self::getNombreEspecialidadUsuario();
        $semestre=self::getSemestreByIdSemestre($idSemestre);
        
        $nombreExcel='Reporte_Cursos_Resultado_'.$nombreEspecialidad.'_'.$semestre;

        $reporte=$model->getReporteCursosResultado($filtros,$idSemestre,self::getEspecialidadUsuario())->get();
        
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
                
                $style = array('font' => array('size' => 15,'bold' => true));
                $promedioResultado=0;
                $contadorAlumnos=0;
                foreach ($reporte as $fila) {
                    if($codResultado!=$fila->COD_RESULTADO){
                        //dd($fila,'A'.$filaInicial.':A'.$filaFinal);
                        if($i!=3){
                            $sheet->mergeCells('E'.$filaInicialInd.':E'.($filaFinalInd-1));
                            $sheet->mergeCells('D'.$filaInicialCat.':D'.($filaFinalCat-1));
                            $sheet->mergeCells('B'.$filaInicial.':B'.($filaFinal-1));
                            $sheet->mergeCells('C'.$filaInicial.':C'.($filaFinal-1));
                            $sheet->setBorder('B'.($filaInicial-1).':H'.($filaFinal-1), 'thin');
                            $sheet->getStyle("G".$filaInicial.":H".($filaFinal))->applyFromArray($style);
                            if($contadorAlumnos!=0){
                                $sheet->row($i, array("","","","", "","",$promedioResultado/($contadorAlumnos),""));
                                if($promedioResultado/($contadorAlumnos)<0.70) $sheet->cell('G'.($i), function($color){$color->setBackground('#fc3232');});
                                else if($promedioResultado/($contadorAlumnos)<0.85) $sheet->cell('G'.($i), function($color){$color->setBackground('#ffe74d');});
                                else $sheet->cell('G'.($i), function($color){$color->setBackground('#13d604');});
                                
                            }
                            $promedioResultado=0;
                            $contadorAlumnos=0;
                            $sheet->setBorder('G'.($i).':G'.($i), 'thin');
                            $sheet->setHeight($i, 45);
                            $sheet->getStyle('G'.$i)
                            ->getNumberFormat()->applyFromArray( 
                                array( 
                                    'code' =>  '0.00%'
                                )
                            );
                            $i+=2;
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
                    
                    $sheet->row($i, array("",$fila->COD_RESULTADO,$fila->NOMBRE_RESULTADO,$fila->NOMBRE_CATEGORIA,  $fila->COD_RESULTADO.$fila->VALORIZACION.'. '.$fila->NOMBRE_INDICADOR,
                            $fila->NOMBRE_CURSO,round($fila->PROMEDIO_CALIF,2),$fila->PORCENTAJE_APROBADOS));
                    $promedioResultado+=$fila->PORCENTAJE_APROBADOS*$fila->COUNT;
                    $contadorAlumnos+=$fila->COUNT;
                    $sheet->setHeight($i, 45);
                    if($fila->PORCENTAJE_APROBADOS<0.70) $sheet->cell('H'.$i, function($color){$color->setBackground('#fc3232');});
                    else if($fila->PORCENTAJE_APROBADOS<0.85) $sheet->cell('H'.$i, function($color){$color->setBackground('#ffe74d');});
                    else $sheet->cell('H'.$i, function($color){$color->setBackground('#13d604');});
                    $sheet->setHeight($i, 45);
                    $i++;
                    $codResultado=$fila->COD_RESULTADO;
                    $nombreCategoria = $fila->NOMBRE_CATEGORIA;
                    $nombreInd = $fila->NOMBRE_INDICADOR;
                    $filaFinal=$i;
                    $filaFinalCat=$i;
                    $filaFinalInd=$i;
                }  
                if(count($reporte)>0){
                    $sheet->mergeCells('E'.$filaInicialInd.':E'.($filaFinalInd-1));
                    $sheet->mergeCells('D'.$filaInicialCat.':D'.($filaFinalCat-1));
                    $sheet->mergeCells('B'.$filaInicial.':B'.($filaFinal-1));
                    $sheet->mergeCells('C'.$filaInicial.':C'.($filaFinal-1));
                    $sheet->setBorder('B'.($filaInicial-1).':H'.($filaFinal-1), 'thin');
                    $sheet->getStyle("G".$filaInicial.":H".($filaFinal))->applyFromArray($style);
                    if($contadorAlumnos!=0){
                        $sheet->row($i, array("","","","", "","",$promedioResultado/($contadorAlumnos),""));
                        if($promedioResultado/($contadorAlumnos)<0.70) $sheet->cell('G'.$i, function($color){$color->setBackground('#fc3232');});
                        else if($promedioResultado/($contadorAlumnos)<0.85) $sheet->cell('G'.$i, function($color){$color->setBackground('#ffe74d');});
                        else $sheet->cell('G'.$i, function($color){$color->setBackground('#13d604');});
                    
                    }
                    $promedioResultado=0;
                    $contadorAlumnos=0;
                    $sheet->getStyle('G'.$i)
                    ->getNumberFormat()->applyFromArray( 
                        array( 
                            'code' =>  '0.00%'
                        )
                    );
                    $sheet->setBorder('G'.($i).':G'.($i), 'thin');
                    $sheet->setHeight($i, 45);
                }
                //Centrado
                $sheet->cells('A2:H1000', function($cells) {   
                            $cells->setAlignment('center');
                            $cells->setValignment('center');
                });
            });
        })->download('xlsx');
    }

     static function getReporteConsolidado($filtros){
        $model =new mIndicador();
        $nombreEspecialidad=self::getNombreEspecialidadUsuario();
        $semestre=self::getSemestre();
        $nombreExcel='Reporte_Consolidado_'.$nombreEspecialidad.'_'.$semestre;
        $reporte=$model->getReporteConsolidado($filtros,self::getIdSemestre(),self::getEspecialidadUsuario())->get();
        Excel::create($nombreExcel, function($excel) use ($semestre,$reporte){
            $excel->setTitle('Reporte Consolidado del semestre '.$semestre);
            $excel->sheet('Reporte Resultados del Semestre', function($sheet) use ($semestre,$reporte){
                //Consideraciones previas
                $sheet->setColumnFormat(array('G' => '0%','H' => '0%','I' => '0%','J' => '0%','K' => '0%','L' => '0%','M' => '0%','N' => '0%','O' => '0%','P' => '0%','Q' => '0%'));
                $sheet->getStyle('A2:Z1000')->getAlignment()->setWrapText(true);

                $sheet->mergeCells('A2:K2');
                $sheet->mergeCells('A3:K3');
                $style = array('font' => array('size' => 15,'bold' => true));
                
                $sheet->setColumnFormat(array('G' => '0%'));
                $i=2;
                $sheet->setWidth(array(
                                        'A'     =>  15,
                                        'B'     =>  30,
                                        'C'     =>  30,
                                        'D'     =>  30,
                                        'E'     =>  30,
                                    ));

                //$sheet->row($i++, array('Reporte Consolidado del semestre '.$semestre));
                $sheet->setHeight($i, 30);
                $sheet->row($i++, array('PONTIFICIA UNIVERSIDAD CATÓLICA DEL PERÚ'));
                $sheet->setHeight($i, 30);
                $sheet->row($i++, array('CONSOLIDACIÓN DE RESULTADO DE LOS INDICADORES DE GESTIÓN'));
                
                $sheet->cells('A2:K2', function($cells) {    // manipulate the cell
                            $cells->setFontSize(13);
                            $cells->setFontWeight('bold');
                            $cells->setAlignment('center');
                            $cells->setValignment('center');
                });
                $sheet->cells('A3:K3', function($cells) {    // manipulate the cell
                    $cells->setFontSize(13);
                    $cells->setAlignment('center');
                    $cells->setValignment('center');

                 });
                $i++;
                $codResultado="";
                $constanteFila = $i-2;
                $filaInicial=$constanteFila + 3;
                $filaFinal=$constanteFila + 3;
                $ciclo = "";
                $columnaInicio = 'I';
                $calculoMenor = 99999999;
                $anhoMenor = 0;
                $cicloMenor = 0;
                $filaInicialCat=$constanteFila + 3;
                $filaFinalCat=$constanteFila + 3;
                $nombreCategoria="";
                $filaInicialInd=$constanteFila + 3;
                $filaFinalInd=$constanteFila + 3;
                $nombreInd="";

                foreach ($reporte as $fila) {
                    if($calculoMenor > ($fila->ANHO*10 + $fila->CICLO)){
                        $calculoMenor = ($fila->ANHO*10 + $fila->CICLO);
                        $anhoMenor = $fila->ANHO;
                        $cicloMenor = $fila->CICLO;
                    }
                }
                $anhoActual = (int)str_replace(' ', '', substr($semestre, 0, 4));
                
                $cicloActual = (int)str_replace(' ', '', substr($semestre, 5,2));
                $anhoDif = 2*($anhoActual - $anhoMenor);
                $columnaFin = $columnaInicio;
                if($cicloActual == 1 and $cicloMenor == 2 or ($cicloActual == 0 and $cicloMenor == 2) )
                    $columnaFin = chr(ord($columnaFin)+$anhoDif - 1);
                elseif ($cicloActual == 2 and $cicloMenor == 1) 
                    $columnaFin = chr(ord($columnaFin)+$anhoDif + 1);
                else
                    $columnaFin = chr(ord($columnaFin)+$anhoDif);
                $filaEncabezados = $constanteFila + 2;
                $porcentajeList = [];
                $alumnosList = [];
                $contAux = 0;
                while($contAux<(ord($columnaFin)-ord($columnaInicio)+1)){
                    $porcentajeList[$contAux] = 0;
                    $alumnosList[$contAux] = 0;
                    $contAux++;
                }
                
                foreach ($reporte as $fila) {
                    if($codResultado!=$fila->COD_RESULTADO){
                        //dd($fila,'A'.$filaInicial.':A'.$filaFinal);
                        if(($anhoActual*10+$cicloActual) < ($fila->ANHO*10+$fila->CICLO)){
                            $codResultado=$fila->COD_RESULTADO;
                            break;
                        }
                        else{
                            if($i!=$constanteFila + 2){
                                $sheet->mergeCells('A'.$filaInicial.':A'.($filaFinal-1));
                                $sheet->mergeCells('B'.$filaInicial.':B'.($filaFinal-1));
                                $sheet->mergeCells('D'.$filaInicialInd.':D'.($filaFinalInd-1));
                                $sheet->mergeCells('C'.$filaInicialCat.':C'.($filaFinalCat-1));
                                for($c=ord($columnaInicio);$c<=ord($columnaFin);$c++){
                                    if($alumnosList[$c-ord($columnaInicio)] == 0)
                                        $sheet->cell(chr($c).$i, 'NA');
                                    else
                                        $sheet->cell(chr($c).$i, $porcentajeList[$c-ord($columnaInicio)]/$alumnosList[$c-ord($columnaInicio)]);
                                }
                                $sheet->setHeight($i, 20);
                                $sheet->cells('A'.$i.':'.$columnaFin.$i, function($cells) {    // manipulate the cell
                                    //$cells->setFontSize(13);
                                    $cells->setAlignment('center');
                                    $cells->setValignment('center');
                                    $cells->setBackground('#c8c8c8');
                                });
                                $i++;
                            }
                            
                            $sheet->cells('A'.$i.':'.$columnaFin.$i, function($cells) {    // manipulate the cell
                                //$cells->setFontSize(13);
                                $cells->setAlignment('center');
                                $cells->setValignment('center');
                                $cells->setBackground('#334185');
                                $cells->setFontColor('#FFFFFF');
                            });
                            $sheet->row($i++, array("CÓDIGO","RESULTADO","CATEGORÍA", "INDICADOR",
                                "CURSOS EVALUADOS","MEDIDA","META %", "ÓPTIMO"));
                            $contAux = 0;
                            while($contAux<(ord($columnaFin)-ord($columnaInicio)+1)){
                                $porcentajeList[$contAux] = 0;
                                $alumnosList[$contAux] = 0;
                                $contAux++;
                            }
                            $filaInicial=$i;
                            $filaEncabezados = $filaInicial - 1;
                        }
                        $filaInicialCat=$i;
                        $filaInicialInd=$i;
                    }
                    else if($nombreCategoria!=$fila->NOMBRE_CATEGORIA){
                        //solo la primera fila del resultado no lo hará, las siguientes verificarán si el 
                        if($i!=$filaInicial){
                            $sheet->mergeCells('C'.$filaInicialCat.':C'.($filaFinalCat-1));
                            $sheet->mergeCells('D'.$filaInicialInd.':D'.($filaFinalInd-1));
                        }
                        $filaInicialCat=$i;
                        $filaInicialInd=$i;
                    }
                    else if($nombreInd!=$fila->NOMBRE_INDICADOR){
                        //solo la primera fila del resultado no lo hará, las siguientes verificarán si el 
                        if($i!=$filaInicialCat){
                            $sheet->mergeCells('D'.$filaInicialInd.':D'.($filaFinalInd-1));
                        }
                        $filaInicialInd=$i;
                    }

                    if(($anhoActual*10+$cicloActual) < ($fila->ANHO*10+$fila->CICLO)){
                        $sheet->setHeight($i, 45);
                        $i++;
                        $codResultado=$fila->COD_RESULTADO;
                        $filaFinal=$i;
                        continue;
                    }
                    $ciclo = $fila->ID_SEMESTRE;
                    $sheet->row($i, array($fila->COD_RESULTADO,$fila->NOMBRE_RESULTADO,$fila->NOMBRE_CATEGORIA, $fila->NOMBRE_INDICADOR,
                            $fila->NOMBRE_CURSO, '%', '0.7', '1.0'));
                    $sheet->cell('H'.$i.':Z'.$i, function($cells) {    // manipulate the cell
                        $cells->setAlignment('center');
                        $cells->setValignment('center');
                    });
                    //$sheet->cell('I'.$filaInicial, $fila->ANHO.$fila->CICLO);
                    $aux = $columnaInicio;
                    
                    $anhoDif = 2*($anhoActual - $fila->ANHO); 
                    
                    $aux = chr(ord($aux)+$anhoDif);
                    
                    $anhoAux = $anhoActual;
                    $cicloAux = $cicloActual;
                    
                    if($fila->CICLO == 2){
                        if($cicloActual == 0 or $cicloActual == 1)
                            $aux = chr(ord($aux) - 1);
                        $cant = ord($columnaFin) - ord($columnaInicio) + 1;
                        
                        $columnRellenar = $columnaInicio;
                        
                        for ($itercolum=0; $itercolum < $cant ; $itercolum++) { 
                            $sheet->cell($columnRellenar.$i, 'NA');
                            //Llenando los encabezados de ciclo
                            $sheet->cell($columnRellenar.$filaEncabezados, $anhoAux.'-'.$cicloAux);
                            /*$sheet->cell($columnRellenar.$filaEncabezados, function($cells) {    // manipulate the cell
                                $cells->setAlignment('center');
                                $cells->setValignment('center');
                                $cells->setBackground('#334185');
                                $cells->setFontColor('#FFFFFF');
                            });*/
                            if($cicloAux == 1 or $cicloAux == 0){
                                $cicloAux = 2;
                                $anhoAux = $anhoAux - 1;
                            }
                            else{
                                $cicloAux = 1;
                            }
                            $columnRellenar++;
                        }
                        $sheet->cell($aux.$i, $fila->PORCENTAJE_APROBADOS);
                        if($fila->COUNT!=0){
                            if($fila->PORCENTAJE_APROBADOS<0.70) $sheet->cell($aux.$i, function($color){$color->setBackground('#fc3232');});
                            else if($fila->PORCENTAJE_APROBADOS<0.85) $sheet->cell($aux.$i, function($color){$color->setBackground('#ffe74d');});
                            else $sheet->cell($aux.$i, function($color){$color->setBackground('#13d604');});
                        
                        }
                        $porcentajeList[ord($aux)-ord($columnaInicio)]+=$fila->PORCENTAJE_APROBADOS*$fila->COUNT;
                        $alumnosList[ord($aux)-ord($columnaInicio)]+=$fila->COUNT;
                        
                        $sheet->cell($aux.$i, function($cells) {    // manipulate the cell
                            $cells->setAlignment('center');
                            $cells->setValignment('center');
                        });
                    }    
                    else{
                        if($cicloActual == 0 or $cicloActual == 1)
                            $aux = chr(ord($aux) - 1);
                        $cant = ord($columnaFin) - ord($columnaInicio) + 1;
                        $columnRellenar = $columnaInicio;
                        for ($itercolum=0; $itercolum < $cant ; $itercolum++) { 
                            $sheet->cell($columnRellenar.$i, 'NA');
                            
                            $sheet->cell($columnRellenar.$filaEncabezados, $anhoAux.'-'.$cicloAux);
                            if($cicloAux == 1 or $cicloAux == 0){
                                $cicloAux = 2;
                                $anhoAux = $anhoAux - 1;
                            }
                            else{
                                $cicloAux = 1;
                            }
                            $columnRellenar++;
                        }
                        
                        $aux2 = $aux++;
                        $aux2++;
                        $sheet->cell($aux2.$i, $fila->PORCENTAJE_APROBADOS);
                        if($fila->COUNT!=0){
                            if($fila->PORCENTAJE_APROBADOS<0.70) $sheet->cell($aux2.$i, function($color){$color->setBackground('#fc3232');});
                            else if($fila->PORCENTAJE_APROBADOS<0.85) $sheet->cell($aux2.$i, function($color){$color->setBackground('#ffe74d');});
                            else $sheet->cell($aux2.$i, function($color){$color->setBackground('#13d604');});
                            //modificación reciente
                            $porcentajeList[ord($aux2)-ord($columnaInicio)]+=$fila->PORCENTAJE_APROBADOS*$fila->COUNT;
                            $alumnosList[ord($aux2)-ord($columnaInicio)]+=$fila->COUNT;
                            //esto estaba abajo
                        }
                        
                        $sheet->getStyle($aux2.$filaInicial.':'.$aux2.$i)->applyFromArray($style);
                    }
                    $sheet->setHeight($i, 45);
                    $i++;
                    $codResultado=$fila->COD_RESULTADO;
                    $filaFinal=$i;
                    $nombreCategoria = $fila->NOMBRE_CATEGORIA;
                    $nombreInd = $fila->NOMBRE_INDICADOR;
                    $filaFinalCat=$i;
                    $filaFinalInd=$i;
                }  
                if(count($reporte)>0){
                    $sheet->mergeCells('A'.$filaInicial.':A'.($filaFinal-1));
                    $sheet->mergeCells('B'.$filaInicial.':B'.($filaFinal-1));
                    $sheet->mergeCells('D'.$filaInicialInd.':D'.($filaFinalInd-1));
                    $sheet->mergeCells('C'.$filaInicialCat.':C'.($filaFinalCat-1));
                    for($c=ord($columnaInicio);$c<=ord($columnaFin);$c++){
                        if($alumnosList[$c-ord($columnaInicio)] == 0)
                            $sheet->cell(chr($c).$i, 'NA');
                        else
                            $sheet->cell(chr($c).$i, $porcentajeList[$c-ord($columnaInicio)]/$alumnosList[$c-ord($columnaInicio)]);
                    }
                    $sheet->setHeight($i, 20);
                    $sheet->cells('A'.$i.':'.$columnaFin.$i, function($cells) {    // manipulate the cell
                        //$cells->setFontSize(13);
                        $cells->setAlignment('center');
                        $cells->setValignment('center');
                        $cells->setBackground('#c8c8c8');
                    });
                    $sheet->setBorder('A5:'.$columnaFin.$i, 'thin');
                    //dd('A'.$filaInicial.':A'.($filaFinal-1));    
                }
                //Centrado
                $sheet->cells('A2:G1000', function($cells) {   
                            $cells->setAlignment('center');
                            $cells->setValignment('center');

                });
            });
        })->download('xlsx');
    }

    static function getInfoResultadoAlumno($idResultado,$idCurso,$idAlumno,$idHorario){
        $model =new mIndicador();
        $reporte=$model->getInfoResultadoAlumno($idResultado,$idCurso,$idAlumno,$idHorario,self::getIdSemestre(),self::getEspecialidadUsuario())->get();
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