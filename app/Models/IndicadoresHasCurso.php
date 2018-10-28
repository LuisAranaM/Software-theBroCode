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
class IndicadoresHasCurso extends Eloquent
{
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'ID_INDICADOR' => 'int',
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


	static function getIndicadoresbyIdCurso($idCurso,$idSem,$idEsp) {
		$sql = DB::table('INDICADORES_HAS_CURSOS')
				->where('INDICADORES_HAS_CURSOS.ID_CURSO','=',$idCurso)
				->leftJoin('INDICADORES', 'INDICADORES_HAS_CURSOS.ID_INDICADOR', '=', 'INDICADORES.ID_INDICADOR')
				->leftJoin('CATEGORIAS', 'INDICADORES.ID_CATEGORIA', '=', 'CATEGORIAS.ID_CATEGORIA')
				->leftJoin('RESULTADOS', 'RESULTADOS.ID_RESULTADO', '=', 'CATEGORIAS.ID_RESULTADO')
				->select('RESULTADOS.ID_RESULTADO', 'RESULTADOS.NOMBRE','INDICADORES.ID_INDICADOR','INDICADORES.NOMBRE')
				->where('RESULTADOS.ID_SEMESTRE', '=', $idSem)
				->where('RESULTADOS.ID_ESPECIALIDAD', '=', $idEsp)
				->distinct();
        //dd($sql->get());
        return $sql;
	}
	
	static function actualizarIndicadoresCurso($idIndicadores,$estadoIndicadores,$idCurso, $usuario,$sem){
		DB::beginTransaction();
        $status = true;
		try {
			foreach(array_combine($idIndicadores,$estadoIndicadores) as  $idIndicador => $estado ){
				$sql = DB::table('INDICADORES_HAS_CURSOS')
						->where('H.ID_CURSO', $idCurso)
						->where('H.ID_INDICADOR', $idIndicador)
						->where('H.ID_SEMESTRE', $sem)
						->select('*');

				if($sql){
				DB::table('INDICADORES_HAS_CURSOS')
				->where('H.ID_CURSO', $idCurso)
				->where('H.ID_INDICADOR', $idIndicador)
				->where('H.ID_SEMESTRE', $sem)
				->update(['H.ESTADO' => (int)$estado,
						'H.FECHA_ACTUALIZACION'=>Carbon::now(),
						'H.USUARIO_MODIF'=>$usuario]);
				}
				else{
				$sql = DB::table('INDICADORES_HAS_CURSOS')->insert(
					['ID_CURSO' => $idCat,
					'ID_INDICADOR' => $nombre,
					'ID_SEMESTRE' => $sem,
					'ID_ESPECIALIDAD' => 1,
					'FECHA_REGISTRO' => Carbon::now(),
					'FECHA_ACTUALIZACION' => Carbon::now(),		
					'USUARIO_MODIF' => Auth::id(), 
					'ESTADO' => 1]);
				}
			}
			DB::commit(); 
		} catch (\Exception $e) {
			Log::error('BASE_DE_DATOS|' . $e->getMessage());
			$status = false;
			DB::rollback();
		}
		dd($idHorario,$estadoEv);
		
		return $status;

	}

	public function indicador()
	{
		return $this->belongsTo(\App\Models\Indicador::class, 'ID_INDICADOR')
					->where('indicadores.ID_INDICADOR', '=', 'indicadores_has_cursos.ID_INDICADOR')
					->where('indicadores.ID_RESULTADO', '=', 'indicadores_has_cursos.ID_RESULTADO')
					->where('indicadores.ID_ESPECIALIDAD', '=', 'indicadores_has_cursos.ID_ESPECIALIDAD')
					->where('indicadores.ID_SEMESTRE', '=', 'indicadores_has_cursos.ID_SEMESTRE');
	}
}
