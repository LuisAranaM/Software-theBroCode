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

    static function insertIndicador($idCrit,$idEsp,$idSem,$nombre, $desc1,$desc2,$desc3,$desc4){
        $model =new mIndicador();
        $model->insertIndicador($idCrit,$idEsp,$idSem,$nombre, $desc1,$desc2,$desc3,$desc4);
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
    static function updateIndicador($indicador){
        $model =new mIndicador();
        return $model::updateIndicador($indicador);
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


                $sheet->row($i++, array('Reporte Resultados por Curso del semestre '.$semestre));
                $sheet->cells('A1:G1', function($cells) {    // manipulate the cell
                            $cells->setBackground('#1FD7C1');
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
}