<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 30 Sep 2018 22:12:14 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;
use DB;

/**
 * Class ProfesoresHasHorario
 * 
 * @property int $ID_USUARIO
 * @property int $ID_HORARIO
 * @property \Carbon\Carbon $FECHA_REGISTRO
 * @property \Carbon\Carbon $FECHA_ACTUALIZACION
 * @property int $USUARIO_MODIF
 * @property int $ESTADO
 * 
 * @property \App\Models\Usuario $usuario
 * @property \App\Models\Horario $horario
 *
 * @package App\Models
 */
class ProfesoresHasHorario extends Eloquent
{
    public $incrementing = false;
    public $timestamps = false;

    protected $casts = [
        'ID_USUARIO' => 'int',
        'ID_HORARIO' => 'int',
        'USUARIO_MODIF' => 'int',
        'ESTADO' => 'int'
    ];

    protected $dates = [
        'FECHA_REGISTRO',
        'FECHA_ACTUALIZACION'
    ];

    protected $fillable = [
        'FECHA_REGISTRO',
        'FECHA_ACTUALIZACION',
        'USUARIO_MODIF',
        'ESTADO'
    ];

    public function usuario()
    {
        return $this->belongsTo(\App\Models\Usuario::class, 'ID_USUARIO', 'id_usuario');
    }

    public function horario()
    {
        return $this->belongsTo(\App\Models\Horario::class, 'ID_HORARIO');
    }

    static function getProfesorHorario($idHorario){
        $sql=DB::Table('PROFESORES_HAS_HORARIOS AS PH')
        ->select(DB::Raw("CONCAT(US.NOMBRES ,' ',US.APELLIDO_PATERNO,' ',US.APELLIDO_MATERNO) 
            AS NOMBRES_COMPLETOS"))
        ->leftJoin('USUARIOS AS US',function($join){
            $join->on('US.ID_USUARIO','=','PH.ID_USUARIO');
        })
        ->where('PH.ID_HORARIO','=',$idHorario)
        ->where('PH.ESTADO','=',1);
        //dd($idHorario,$sql->get());
        //dd($sql->first()->NOMBRES_COMPLETOS);
        return $sql;
    }
}
