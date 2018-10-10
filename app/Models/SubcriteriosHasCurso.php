<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 30 Sep 2018 22:12:14 +0000.
 */

namespace App\Models;
<<<<<<< HEAD
use DB;
=======

>>>>>>> AranaBranch
use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class SubcriteriosHasCurso
 * 
 * @property int $ID_SUBCRITERIO
 * @property int $ID_CRITERIO
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
		'ID_CRITERIO' => 'int',
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

<<<<<<< HEAD
	static function getSubCriteriosbyIdCurso($idCurso) {
		$sql = DB::table('SUBCRITERIOS_HAS_CURSOS')
				->leftJoin('SUBCRITERIOS', 'SUBCRITERIOS.ID_SUBCRITERIO', '=', 'SUBCRITERIOS_HAS_CURSOS.ID_SUBCRITERIO')
				->where('SUBCRITERIOS_HAS_CURSOS.ID_CURSO','=',$idCurso)
				->distinct();
        //dd($sql->get());
        return $sql;
	}
	

=======
>>>>>>> AranaBranch
	public function subcriterio()
	{
		return $this->belongsTo(\App\Models\Subcriterio::class, 'ID_SUBCRITERIO')
					->where('subcriterios.ID_SUBCRITERIO', '=', 'subcriterios_has_cursos.ID_SUBCRITERIO')
					->where('subcriterios.ID_CRITERIO', '=', 'subcriterios_has_cursos.ID_CRITERIO')
					->where('subcriterios.ID_ESPECIALIDAD', '=', 'subcriterios_has_cursos.ID_ESPECIALIDAD')
					->where('subcriterios.ID_SEMESTRE', '=', 'subcriterios_has_cursos.ID_SEMESTRE');
	}
}
