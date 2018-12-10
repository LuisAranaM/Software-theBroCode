<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 30 Sep 2018 22:12:14 +0000.
 */

namespace App\Models;

use DB;
use Log;
use Reliese\Database\Eloquent\Model as Eloquent;
use Jenssegers\Date\Date as Carbon;

/**
 * Class SubcriteriosHasCurso
 * 
 * @property int $ID_INDICADOR
 * @property int $ID_RESULTADO
 * @property int $ID_ESPECIALIDAD
 * @property int $ID_SEMESTRE
 * @property int $ID_CURSO
 * @property \Carbon\Carbon $FECHA_REGISTRO
 * @property \Carbon\Carbon $FECHA_ACTUALIZACION
 * @property int $USUARIO_MODIF
 * @property int $ESTADO
 * 
 * @property \App\Models\Curso $curso
 * @property \App\Models\Subcriterio $subcriterio
 *
 * @package App\Models
 */
class IndicadoresHasAlumnosHasHorarios extends Eloquent
{
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'ID_INDICADOR' => 'int',
        'ID_HORARIO' => 'int',
        'ID_ALUMNOS' => 'int',
        'ID_DESCRIPCION' => 'int',
		'ID_ESPECIALIDAD' => 'int',
		'ID_SEMESTRE' => 'int',
		'ESCALA_CALIFICACION' =>'int',
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

	static function getValoresReporte1($idInd,$idHorario,$idSem,$idEsp) {
		//dd($idInd,$idHorario,$idSem,$idEsp);
		$sql = DB::table('INDICADORES_HAS_ALUMNOS_HAS_HORARIOS')
				->where('ID_HORARIO','=',$idHorario)
				->where('ID_INDICADOR','=',$idInd)
				->where('ID_SEMESTRE', '=', $idSem)
				->where('ID_ESPECIALIDAD', '=', $idEsp)
				->where('ESTADO', '=', 1);
		//dd($sql->get());
		$valores = array();
		$valores[0] = DB::table('INDICADORES_HAS_ALUMNOS_HAS_HORARIOS')
		->where('ID_HORARIO','=',$idHorario)
		->where('ID_INDICADOR','=',$idInd)
		->where('ID_SEMESTRE', '=', $idSem)
		->where('ID_ESPECIALIDAD', '=', $idEsp)
		->where('ESTADO', '=', 1)->sum('ESCALA_CALIFICACION');

		$valores[1] = DB::table('INDICADORES_HAS_ALUMNOS_HAS_HORARIOS')
		->where('ID_HORARIO','=',$idHorario)
		->where('ID_INDICADOR','=',$idInd)
		->where('ID_SEMESTRE', '=', $idSem)
		->where('ID_ESPECIALIDAD', '=', $idEsp)
		->where('ESTADO', '=', 1)
					->where('ESCALA_CALIFICACION', '=',3)
					->count();

		$valores[1] +=DB::table('INDICADORES_HAS_ALUMNOS_HAS_HORARIOS')
		->where('ID_HORARIO','=',$idHorario)
		->where('ID_INDICADOR','=',$idInd)
		->where('ID_SEMESTRE', '=', $idSem)
		->where('ID_ESPECIALIDAD', '=', $idEsp)
		->where('ESTADO', '=', 1)
					->where('ESCALA_CALIFICACION', '=',4)
					->count();

		$valores[2] = DB::table('INDICADORES_HAS_ALUMNOS_HAS_HORARIOS')
		->where('ID_HORARIO','=',$idHorario)
		->where('ID_INDICADOR','=',$idInd)
		->where('ID_SEMESTRE', '=', $idSem)
		->where('ID_ESPECIALIDAD', '=', $idEsp)
		->where('ESTADO', '=', 1)->count();
	    return $valores;
	}

}
