<?php

namespace App\Entity;

use \Illuminate\Pagination\LengthAwarePaginator as Paginator;
use App\Models\IndicadoresHasCurso as mIndicadoresHasCurso;
use App\Models\Curso as mCurso;
use App\Models\Resultado as mResultado;
use App\Models\Indicador as mIndicador;
use Jenssegers\Date\Date as Carbon;

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

    static function getResultadosByIndicadores(){
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
        dd($final);
    }
    
}