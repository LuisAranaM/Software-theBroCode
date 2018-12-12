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
        //dd(self::getIdSemestre());
        //dd($cursos);
        foreach ($cursos as $curso){
            $cursoTemp= [];

            array_push($cursoTemp, $curso->CODIGO_CURSO, $curso->NOMBRE);
            $resultadosTemp = [];
            $resultadosTemp = mResultado::getResultadosByCursoExcel($curso->ID_CURSO,self::getIdSemestre(),self::getEspecialidadUsuario())->get();            
            $resultados = [];
            foreach($resultadosTemp as $resultado){
                $resultadoTemp = [];
                $indicadoresTemp = [];
                $indicadoresTemp = mIndicador::getIndicadoresbyResultadoOrdenado($resultado->ID_RESULTADO,self::getIdSemestre(),self::getEspecialidadUsuario())->get();
                //Countamos los indicadores
                $numIndicadores=count($indicadoresTemp);
                array_push($resultadoTemp,$resultado->NOMBRE,$resultado->DESCRIPCION,$numIndicadores);
                
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

    static function getColumnaExcel($numCol){
        $caracterIni='A';
        $caracter=$caracterIni;

        for($i=1;$i<$numCol;$i++){
            $caracter++;
            if($i==26) $caracter='A';
        }
        if($i>26) $caracter=$caracterIni.$caracter;
        return $caracter;
    }
    static function generarExcelIndicadoresByCurso(){
        //dd("HOLI");
        //dd(self::getColumnaExcel(30));
        $cursos=self::getIndicadoresByCursos();
        
        $nombreEspecialidad=self::getNombreEspecialidadUsuario();
        $semestre=self::getSemestreByIdSemestre(self::getIdSemestre());
        $nombreExcel='Mapeo_Cursos_'.$nombreEspecialidad.'_'.$semestre;

        Excel::create($nombreExcel, function($excel) use ($nombreEspecialidad,$semestre,$cursos){

            $excel->setTitle('Mapeo de indicadores');
            $excel->sheet('CURSOS VS INDICADORES', function($sheet) use ($cursos){
                $sheet->setAutoSize(true);
                $i=1;
                
                $resultados=[];
                $indicadores=[];
                $longitudIndicadores=[];
                foreach ($cursos as $curso) {
                    $resultados=$curso[2];
                    foreach ($resultados as $resultado) {
                        $nombreResultado=$resultado[0];
                        $descripcionResultado=$resultado[1];
                        $numIndicadores=$resultado[2];
                        $longitudIndicadores[]=$numIndicadores;
                        $indicadores=$resultado[3];
                        if(count($indicadores)==0){
                            $resultadosImprimir['CODIGO'][]=$nombreResultado;
                            $resultadosImprimir['DESCRIPCION'][]=$descripcionResultado;
                        }
                        else{
                            foreach ($indicadores as $indicador) {
                                $valorizacion=$indicador[0];
                                $resultadosImprimir['CODIGO'][]=$nombreResultado;
                                $resultadosImprimir['DESCRIPCION'][]=$descripcionResultado;
                                $indicadoresImprimir[]=$nombreResultado.$valorizacion;                            
                            }
                        }
                    }
                    break;
                }
                $columnaMerge=2;


                //dd($resultadosImprimir,$indicadoresImprimir);
                $sheet->row($i++,array_merge(["Curso/Resultado"],$resultadosImprimir['CODIGO']));
                $sheet->row($i++,array_merge([""],$resultadosImprimir['DESCRIPCION']));
                $sheet->row($i++,array_merge([""],$indicadoresImprimir));
                //dd($longitudIndicadores);
                foreach ($longitudIndicadores as $longitud){       
                    if($longitud==0)$longitud=1;
                    $sheet->mergeCells(self::getColumnaExcel($columnaMerge).'1:'.self::getColumnaExcel($columnaMerge+$longitud-1).'1');
                    $sheet->mergeCells(self::getColumnaExcel($columnaMerge).'2:'.self::getColumnaExcel($columnaMerge+$longitud-1).'2');
                    $columnaMerge=$columnaMerge+$longitud;
                }
        //dd($cursos,$longitudIndicadores);
                for ($j=1;$j<=$columnaMerge;$j++){
                    $sheet->setWidth(self::getColumnaExcel($j), 5);
                }

                //Columnas y Filas Fijas
                $sheet->mergeCells('A1:A3');
                $sheet->setWidth('A',60);
                $sheet->setHeight(2,90);

                foreach ($cursos as $curso) {
                    $filaCurso=[];
                    $filaCurso[]=$curso[0].'-'.$curso[1]; //Nombre y código
                    $resultados=$curso[2];
                    //dd($resultados);
                    foreach ($resultados as $resultado) {
                        $indicadores=$resultado[3];
                        foreach ($indicadores as $indicador) {
                            $tieneIndicador=$indicador[2];
                            if($tieneIndicador)
                                $filaCurso[]="X";
                            else
                                $filaCurso[]="";
                        }
                    }
                    $sheet->row($i++,$filaCurso);
                }

                $sheet->getStyle('B2:AZ2')->getAlignment()->setWrapText(true);
                 $sheet->cells('A1:'.self::getColumnaExcel($columnaMerge-1).'3', function($cells) {    // manipulate the cell
                    $cells->setFontSize(12);
                    $cells->setBackground('#FFBE3C');

                });

                $sheet->cells('A1:A100', function($cells) {    // manipulate the cell
                    $cells->setFontSize(12);                 
                });

                $sheet->setBorder('A1:'.self::getColumnaExcel($columnaMerge-1).($i-1), 'thin');

                $sheet->cells('B1:AZ1000', function($cells) {   
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                });
            });
})->download('xlsx');
}



}