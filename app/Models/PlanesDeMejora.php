<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 30 Sep 2018 22:12:14 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;
use DB;
use Log;
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

    public function especialidad()
    {
        return $this->belongsTo(\App\Models\Especialidad::class, 'ID_ESPECIALIDAD');
    }

    public function semestre()
    {
        return $this->belongsTo(\App\Models\Semestre::class, 'ID_SEMESTRE', 'id_semestre');
    }
    static function buscarDocumentos() {
        $sql = DB::table('DOCUMENTOS_REUNIONES')
                ->orderBy('DOCUMENTO_ANHO','DESC')
                ->orderBy('DOCUMENTO_SEMESTRE','DESC')
                ->get()->toArray();
        //dd($acreditacion);
        //dd($sql);
        return $sql;
    }

    static function resultadosFiltroDocs($anhoInicio,$semIni,$anhoFin,$semFin){
        
        $ans = DB::table('DOCUMENTOS_REUNIONES')
            ->select('DOCUMENTOS_REUNIONES.*')
            ->where('DOCUMENTO_ANHO*10 + DOCUMENTO_SEMESTRE','>=',$anhoInicio*10 + $semIni)
            ->where('DOCUMENTO_ANHO*10 + DOCUMENTO_SEMESTRE','<=',$anhoFin*10 + $semFin)
            ->orderBy('DOCUMENTO_ANHO*10 + DOCUMENTO_SEMESTRE', 'desc')
            ->get()->toArray();
        return $ans;
    }
}
