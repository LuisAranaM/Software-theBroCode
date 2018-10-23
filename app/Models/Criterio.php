<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 30 Sep 2018 22:12:14 +0000.
 */

namespace App\Models;
use DB;
use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Criterio
 * 
 * @property int $ID_RESULTADO
 * @property int $ID_ESPECIALIDAD
 * @property int $ID_SEMESTRE
 * @property string $NOMBRE
 * @property \Carbon\Carbon $FECHA_REGISTRO
 * @property \Carbon\Carbon $FECHA_ACTUALIZACION
 * @property int $USUARIO_MODIF
 * @property int $ESTADO
 * 
 * @property \App\Models\Especialidade $especialidade
 * @property \App\Models\Semestre $semestre
 * @property \Illuminate\Database\Eloquent\Collection $subcriterios
 *
 * @package App\Models
 */
class Criterio extends Eloquent
{
	protected $table = 'criterio';
	public $timestamps = false;

	protected $casts = [
		'ID_ESPECIALIDAD' => 'int',
		'ID_SEMESTRE' => 'int',
		'USUARIO_MODIF' => 'int',
		'ESTADO' => 'int'
	];

	protected $dates = [
		'FECHA_REGISTRO',
		'FECHA_ACTUALIZACION'
	];

	protected $fillable = [
		'NOMBRE',
		'FECHA_REGISTRO',
		'FECHA_ACTUALIZACION',
		'USUARIO_MODIF',
		'ESTADO'
	];

	static function getCriterios() {
        $sql = DB::table('CATEGORIAS')
                ->select('ID_CATEGORIA', 'NOMBRE', 'DESCRIPCION')
                ->where('ESTADO','=',1);
        //dd($sql->get());
        return $sql;

	}
	
	static function getCriteriosbyIdCurso($idCurso) {
		$sql = DB::table('INDICADORES_HAS_CURSOS')
				->where('INDICADORES_HAS_CURSOS.ID_CURSO','=',$idCurso)
				->leftJoin('INDICADORES', 'INDICADORES_HAS_CURSOS.ID_INDICADOR', '=', 'INDICADORES.ID_INDICADOR')
				->leftJoin('CATEGORIAS', 'INDICADORES.ID_CATEGORIA', '=', 'CATEGORIAS.ID_CATEGORIA')
				->leftJoin('RESULTADOS', 'RESULTADOS.ID_RESULTADO', '=', 'CATEGORIAS.ID_RESULTADO')
				->select('RESULTADOS.ID_RESULTADO', 'RESULTADOS.NOMBRE')
				->distinct();
        //dd($sql->get());
        return $sql;
	}
	

	public function insertCriterio($nombre, $desc){
		$id = DB::table('CATEGORIAS')->insertGetId(
		    	['NOMBRE' => $nombre,
		     	'DESCRIPCION' => $desc,
				 'ESTADO' => 1]);

		DB::commit();

		return $id;
	}

	public function especialidade()
	{
		return $this->belongsTo(\App\Models\Especialidad::class, 'ID_ESPECIALIDAD', 'id_especialidad');
	}

	public function semestre()
	{
		return $this->belongsTo(\App\Models\Semestre::class, 'ID_SEMESTRE', 'id_semestre');
	}

	public function subcriterios()
	{
		return $this->hasMany(\App\Models\Subcriterio::class, 'ID_RESULTADO');
	}
}
