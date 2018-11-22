<?php

namespace App\Entity;

use \Illuminate\Pagination\LengthAwarePaginator as Paginator;
use App\Models\Curso as mCurso;
use Jenssegers\Date\Date as Carbon;

class Curso extends \App\Entity\Base\Entity {

	protected $_fechaRegistro;
    
    function setProperties($data) {
        $this->setValues([
            '_fechaRegistro' => $data->FECHA_REGISTRO,
        ]);
    }

    function setValueToTable() {
        return $this->cleanArray([
            'FECHA_REGISTRO' => $this->_fechaRegistro,
        ]);
    }

    static function getIdCurso2($codCurso){
        return mCurso::getIdCurso2($codCurso);
    }

    static function getCursosYHorarios($usuario=null){
        return mCurso::getCursosYHorarios(self::getEspecialidadUsuario(),self::getIdSemestre(),$usuario);
    }

    static function getCursosbyIdSemestre($idSemestre) {
        $model = new mCurso();
        return mCurso::getCursos($idSemestre, self::getEspecialidadUsuario())->get();
    }

    static function getCursosByIdIndicador($idIndicador) {
        $model = new mCurso();
        return mCurso::getCursosByIdIndicador($idIndicador)->get();
    }

 static function getCursoByIdHorario($idHorario) {
         $model = new mCurso();
         return mCurso::getCursoByIdHorario($idHorario)->get();
}
    static function getCursosAcreditacion() {
        //Aquí consigo los cursos de la 
        //especialidad y que se acreditarán
        $model = new mCurso();
        return mCurso::getCursos(self::getIdSemestre(), self::getEspecialidadUsuario())->get();

    }

    static function buscarCursos($nomCurso=null,$acreditacion=false){
        $model= new mCurso();
        return $model->buscarCursos(self::getIdSemestre(), 
                                    self::getEspecialidadUsuario(),
                                    $nomCurso,$acreditacion)->get();
    }

     function agregarAcreditar($checks,$usuario){
        
        $model= new mCurso();
        

        if ($model->agregarAcreditar(self::getIdSemestre(),self::getEspecialidadUsuario(),$checks,$usuario)){

            return true;
        }else{
            $this->setMessage('Hubo un error en el servidor de base de datos');
            return false;
        }

    } 

    function eliminarAcreditar($codigoCurso,$usuario){
        
        $model= new mCurso();
        
        if ($model->eliminarAcreditar(self::getIdSemestre(),$codigoCurso,$usuario)){
            return true;
        }else{
            $this->setMessage('Hubo un error en el servidor de base de datos');
            return false;
        }

    }

    public function getIdCurso($codCurso){
        $model = new mCurso();
        if ($model->getIdCurso($codCurso,self::getIdSemestre(),self::getEspecialidadUsuario())->first())
            return $model->getIdCurso($codCurso,self::getIdSemestre(),self::getEspecialidadUsuario())->first()->ID_CURSO;
        else
            return $model->getIdCurso($codCurso,self::getIdSemestre(),self::getEspecialidadUsuario())->first();
    }

    static function getCursosByResultado($idSemestre,$idResultado){
        //Para gráfico de Ronie 
        $model = new mCurso();
        return $model->getCursosByResultado(self::getEspecialidadUsuario(),$idSemestre,$idResultado)->get();
    }

}