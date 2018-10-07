<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 30 Sep 2018 22:12:14 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class PlanesDeMejora
 * 
 * @property int $ID_PLAN
 * @property int $ID_SEMESTRE
 * @property int $ID_ESPECIALIDAD
 * @property mediumblob $PLAN
 * @property \Carbon\Carbon $FECHA_REGISTRO
 * @property \Carbon\Carbon $FECHA_ACTUALIZACION
 * @property int $USUARIO_MODIF
 * @property int $ESTADO
 * 
 * @property \App\Models\Especialidade $especialidade
 * @property \App\Models\Semestre $semestre
 *
 * @package App\Models
 */
class PlanesDeMejora extends Eloquent
{
    public $timestamps = false;

    protected $casts = [
        'ID_SEMESTRE' => 'int',
        'ID_ESPECIALIDAD' => 'int',
        'PLAN' => 'mediumblob',
        'USUARIO_MODIF' => 'int',
        'ESTADO' => 'int'
    ];

    protected $dates = [
        'FECHA_REGISTRO',
        'FECHA_ACTUALIZACION'
    ];

    protected $fillable = [
        'PLAN',
        'FECHA_REGISTRO',
        'FECHA_ACTUALIZACION',
        'USUARIO_MODIF',
        'ESTADO'
    ];

    public function especialidade()
    {
        return $this->belongsTo(\App\Models\Especialidade::class, 'ID_ESPECIALIDAD');
    }

    public function semestre()
    {
        return $this->belongsTo(\App\Models\Semestre::class, 'ID_SEMESTRE', 'id_semestre');
    }
}
