<?php

namespace App\Entity;

use \Illuminate\Pagination\LengthAwarePaginator as Paginator;
use App\Models\Alumno as mAlumno;
use Jenssegers\Date\Date as Carbon;

class Alumno extends \App\Entity\Base\Entity {

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

    static function getAlumnosByHorario($idHorario){
        return mAlumno::getAlumnosByHorarioStatic($idHorario);
    }

    public function insertarIndicadoresxAlumno($datosAlumno){
        mAlumno::insertarIndicadoresxAlumno($datosAlumno);
    }

    public function calificarAlumnos($data,$usuario){
        //dd($data['idAlumno']);
        $registro=['ID_ALUMNO'=>$data['idAlumno'],
            'ID_HORARIO'=>$data['idHorario'],
            'ID_INDICADOR'=>$data['idIndicador'],
            'ID_CATEGORIA'=>$data['idCategoria'],
            'ID_RESULTADO'=>$data['idResultado'],
            'ID_DESCRIPCION'=>$data['idDescripcion'],
            'ID_SEMESTRE'=>self::getIdSemestre(),
            'ID_ESPECIALIDAD'=>self::getEspecialidadUsuario(),
            'ESCALA_CALIFICACION'=>$data['escalaCalif'],
            'FECHA_REGISTRO'=>Carbon::now(),
            'FECHA_ACTUALIZACION'=>Carbon::now(),
            'USUARIO_MODIF'=>$usuario,
            'ESTADO'=>1];
        //Armamos lo que vamos a insertar
        $model= new mAlumno();

        if ($model->calificarAlumnos($registro)){
            return true;
        }else{
            $this->setMessage('Hubo un error en el servidor de base de datos');
            return false;
        }
    }
    
}