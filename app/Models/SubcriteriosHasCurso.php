<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 30 Sep 2018 22:12:14 +0000.
 */

namespace App\Models;

use DB;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class SubcriteriosHasCurso
 * 
 * @property int $ID_SUBCRITERIO
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
class SubcriteriosHasCurso extends Eloquent
{
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'ID_SUBCRITERIO' => 'int',
		'ID_RESULTADO' => 'int',
		'ID_ESPECIALIDAD' => 'int',
		'ID_SEMESTRE' => 'int',
		'ID_CURSO' => 'int',
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

	public function curso()
	{
		return $this->belongsTo(\App\Models\Curso::class, 'ID_CURSO');
	}


	static function getSubCriteriosbyIdCurso($idCurso) {
		$sql = DB::table('INDICADORES_HAS_CURSOS')
				->where('INDICADORES_HAS_CURSOS.ID_CURSO','=',$idCurso)
				->leftJoin('INDICADORES', 'INDICADORES_HAS_CURSOS.ID_INDICADOR', '=', 'INDICADORES.ID_INDICADOR')
				->leftJoin('CATEGORIAS', 'INDICADORES.ID_CATEGORIA', '=', 'CATEGORIAS.ID_CATEGORIA')
				->leftJoin('RESULTADOS', 'RESULTADOS.ID_RESULTADO', '=', 'CATEGORIAS.ID_RESULTADO')
				->select('RESULTADOS.ID_RESULTADO', 'RESULTADOS.NOMBRE','INDICADORES.ID_INDICADOR','INDICADORES.NOMBRE')
				->distinct();
        //dd($sql->get());
        return $sql;
	}
	


	public function subcriterio()
	{
		return $this->belongsTo(\App\Models\Subcriterio::class, 'ID_SUBCRITERIO')
					->where('subcriterios.ID_SUBCRITERIO', '=', 'indicadores_has_cursos.ID_INDICADOR')
					->where('subcriterios.ID_RESULTADO', '=', 'indicadores_has_cursos.ID_RESULTADO')
					->where('subcriterios.ID_ESPECIALIDAD', '=', 'indicadores_has_cursos.ID_ESPECIALIDAD')
					->where('subcriterios.ID_SEMESTRE', '=', 'indicadores_has_cursos.ID_SEMESTRE');
	}
}
