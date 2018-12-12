<?php

namespace App\Entity;

use \Illuminate\Pagination\LengthAwarePaginator as Paginator;
use App\Models\Proyecto as mProyecto;
use Jenssegers\Date\Date as Carbon;

class Proyecto extends \App\Entity\Base\Entity {

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
    static function getRutaProyectos($idHorario){
        return mProyecto::getRutaProyectos($idHorario);
    }

    function agregarMasivo($dataProyectos,$idUsuario){

        $model= new mProyecto();        

        $idHorario=$dataProyectos['horario'];
        $idSemestre=self::getIdSemestre();
        $idEspecialidad=self::getEspecialidadUsuario();
        $dataSubir=[];
        $i=0;
        foreach ($dataProyectos['archivos'] as $key => $proyecto) {
            $idAlumno=$key;
            $nombreArchivo = pathinfo($proyecto->getClientOriginalName(), PATHINFO_FILENAME);
            $extensionArchivo = pathinfo($proyecto->getClientOriginalName(), PATHINFO_EXTENSION);  //Get extension of file
            $proyecto->storePubliclyAs('upload', $nombreArchivo.'.'.$extensionArchivo, 'public');
            $ruta = base_path() . '\public\upload' . '\\' . $nombreArchivo.'.'.$extensionArchivo ;
            $fecha = date("Y-m-d H:i:s");
            $infoProyecto=array();
            $infoProyecto=['RUTA'=>$ruta,
                'FECHA_REGISTRO'=>$fecha,
                'FECHA_ACTUALIZACION'=>$fecha,
                'USUARIO_MODIF'=>$idUsuario,
                'ESTADO'=>1, 
                'NOMBRE'=>$nombreArchivo.'.'.$extensionArchivo,
                'ID_SEMESTRE'=>$idSemestre,
                'ID_ESPECIALIDAD'=>$idEspecialidad
            ];
        $dataSubir[$i]['PROYECTO']=$infoProyecto;

        $infoAlumnoHorario=array();
        $infoAlumnoHorario=[
            'ID_ALUMNO'=>$idAlumno, 
            'ID_HORARIO'=>$idHorario,
            'ID_PROYECTO'=>NULL,
            'ID_SEMESTRE'=>$idSemestre,
            'FECHA_REGISTRO'=>$fecha,
            'FECHA_ACTUALIZACION'=>$fecha,
            'USUARIO_MODIF'=>$idUsuario,
            'ESTADO'=>1,
            'ID_ESPECIALIDAD'=>$idEspecialidad];
        $dataSubir[$i]['ALUMNO']=$infoAlumnoHorario;
        $i++;
        }

        
        if ($model->agregarMasivo($dataSubir)){
            return true;
        }else{
            $this->setMessage('Hubo un error en el servidor de base de datos');
            return false;
        }

    } 
    
}