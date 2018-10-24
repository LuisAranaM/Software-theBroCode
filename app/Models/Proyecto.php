<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 30 Sep 2018 22:12:14 +0000.
 */

namespace App\Models;
use DB;
use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Proyecto
 * 
 * @property int $ID_PROYECTO
 * @property mediumblob $PROYECTO
 * @property \Carbon\Carbon $FECHA_REGISTRO
 * @property \Carbon\Carbon $FECHA_ACTUALIZACION
 * @property int $USUARIO_MODIF
 * @property int $ESTADO
 * 
 * @property \Illuminate\Database\Eloquent\Collection $alumnos_has_horarios
 *
 * @package App\Models
 */
class Proyecto extends Eloquent
{
    protected $primaryKey = 'ID_PROYECTO';
    public $timestamps = false;

    protected $casts = [
        'ID_SEMESTRE'=>'int',
        'ID_ESPECIALIDAD'=>'int',
        'PROYECTO' => 'mediumblob',
        'USUARIO_MODIF' => 'int',
        'ESTADO' => 'int'
    ];

    protected $dates = [
        'FECHA_REGISTRO',
        'FECHA_ACTUALIZACION'
    ];

    protected $fillable = [
        'PROYECTO',
        'FECHA_REGISTRO',
        'FECHA_ACTUALIZACION',
        'USUARIO_MODIF',
        'ESTADO'
    ];

    public function alumnos_has_horarios()
    {
        return $this->hasMany(\App\Models\AlumnosHasHorario::class, 'ID_PROYECTO', 'id_proyecto');
    }
    static public function getRutaProyectos($idHorario){
        $ans = DB::table('PROYECTOS')
            ->join('ALUMNOS_HAS_HORARIOS', 'ALUMNOS_HAS_HORARIOS.ID_PROYECTO', '=', 'PROYECTOS.ID_PROYECTO')
            ->select('PROYECTOS.*')
            ->orderBy('FECHA_ACTUALIZACION', 'desc')
            #->where('ALUMNOS_HAS_HORARIOS.ID_HORARIO','=',$idHorario)
            ->get()->toArray();
        return $ans;
    }
}
