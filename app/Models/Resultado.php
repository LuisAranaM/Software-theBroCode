<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 30 Sep 2018 22:12:14 +0000.
 */

namespace App\Models;
use DB;
use Reliese\Database\Eloquent\Model as Eloquent;
use Jenssegers\Date\Date as Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log as Log;

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
class Resultado extends Eloquent
{
	protected $table = 'resultados';
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

	static function getResultados($idSem,$idEsp) {
		//dd($idSem);
		$sql = DB::table('RESULTADOS')
		->select('ID_RESULTADO', 'NOMBRE', 'DESCRIPCION')
		->where('ESTADO','=',1)
		->where('ID_SEMESTRE','=',$idSem)
		->where('ID_ESPECIALIDAD','=',$idEsp)
		->orderBy('NOMBRE', 'ASC');
        //dd($sql->get());
		return $sql;

	}
	
	static function getResultadosbyIdCurso($idCurso,$idSem,$idEsp,$idResultado=null,$orden=null) {
		//dd($idCurso,$idSem,$idEsp);
		//if ($orden=='desc')dd($idResultado);
		$sql = DB::table('INDICADORES_HAS_CURSOS')
		->where('INDICADORES_HAS_CURSOS.ID_CURSO','=',$idCurso)
		->leftJoin('RESULTADOS', 'RESULTADOS.ID_RESULTADO', '=', 'INDICADORES_HAS_CURSOS.ID_RESULTADO')
		->select('RESULTADOS.ID_RESULTADO', 'RESULTADOS.NOMBRE', 'RESULTADOS.DESCRIPCION')
		->where('RESULTADOS.ID_SEMESTRE','=',$idSem)
		->where('RESULTADOS.ID_ESPECIALIDAD','=',$idEsp)
		->where('INDICADORES_HAS_CURSOS.ESTADO','=',1)
		->distinct();

		//Arana		
		if($idResultado!=NULL){
			if($orden!=NULL){
				if($orden=='desc'){
					$sql=$sql->where('RESULTADOS.ID_RESULTADO','<',$idResultado);	
					//dd($sql->get());	
				}						
				else
					$sql=$sql->where('RESULTADOS.ID_RESULTADO','>',$idResultado);
				
				$sql=$sql->orderBy('RESULTADOS.ID_RESULTADO',$orden)->first();
					//dd($sql);
				

			}	
			else{
				$sql=$sql->where('RESULTADOS.ID_RESULTADO','=',$idResultado)
				->orderBy('RESULTADOS.ID_RESULTADO', 'ASC')->first();
			}
		}
		else{
			$sql=$sql->get();
		}
        //dd($sql->get());
		return $sql;
	}
	
	static function getResultadosbyCurso($idCurso,$idSem,$idEsp){
		$sql = DB::table('INDICADORES_HAS_CURSOS')
		->where('INDICADORES_HAS_CURSOS.ID_CURSO','=',$idCurso)
		->leftJoin('RESULTADOS', 'RESULTADOS.ID_RESULTADO', '=', 'INDICADORES_HAS_CURSOS.ID_RESULTADO')
		->select('RESULTADOS.ID_RESULTADO', 'RESULTADOS.NOMBRE', 'RESULTADOS.DESCRIPCION')
		->where('RESULTADOS.ID_SEMESTRE','=',$idSem)
		->where('RESULTADOS.ID_ESPECIALIDAD','=',$idEsp)
		->where('INDICADORES_HAS_CURSOS.ESTADO','=',1)
		->distinct();
		//orden descendente por nombre
		$sql=$sql->orderBy('RESULTADOS.NOMBRE','ASC');
		return $sql;
	}


	public function insertResultado($nombre, $desc,$idSem,$idEsp){
		DB::beginTransaction();
		$id=-1;
		try {
			$id = DB::table('RESULTADOS')->insertGetId(
				['NOMBRE' => $nombre,
				'DESCRIPCION' => $desc,
				'ID_SEMESTRE' => $idSem,
				'ID_ESPECIALIDAD' => $idEsp,
				'FECHA_REGISTRO' => Carbon::now(),
				'FECHA_ACTUALIZACION' => Carbon::now(),		
				'USUARIO_MODIF' => Auth::id(),     	
				'ESTADO' => 1]);
			DB::commit();
		} catch (\Exception $e) {
			Log::error('BASE_DE_DATOS|' . $e->getMessage());
			DB::rollback();
		}	

		return $id;
	}
	static function updateResultado($id, $nombre, $desc){
		DB::beginTransaction();
		try {
			DB::table('RESULTADOS')->where('ID_RESULTADO',$id)
			->update(
				['NOMBRE' => $nombre,
				'DESCRIPCION' => $desc,
				'FECHA_ACTUALIZACION' => Carbon::now(),		
				'USUARIO_MODIF' => Auth::id()]);
			DB::commit();
		} catch (\Exception $e) {
			Log::error('BASE_DE_DATOS|' . $e->getMessage());
			DB::rollback();
		}	
	}
	static function deleteResultado($id){
		DB::beginTransaction();
		try {
        	//dd($id);
			DB::table('RESULTADOS')->where('ID_RESULTADO',$id)
			->update(
				['ESTADO' => 0]);
			DB::commit();
		} catch (\Exception $e) {
			Log::error('BASE_DE_DATOS|' . $e->getMessage());
			DB::rollback();
		}	
	}

	static function getInformacionRubrica($idSemestre,$idEspecialidad){
		$sql=DB::table(DB::Raw("(SELECT 
			RES.ID_ESPECIALIDAD,RES.ID_SEMESTRE,
			RES.ID_RESULTADO,RES.NOMBRE AS NOMBRE_RES,RES.DESCRIPCION AS DESCRIPCION_RES,
			CAT.ID_CATEGORIA,CAT.NOMBRE AS NOMBRE_CAT,
			IND.ID_INDICADOR,IND.NOMBRE AS NOMBRE_IND,IND.VALORIZACION AS VAL_IND, 
			DES.ID_DESCRIPCION,DES.NOMBRE AS NOMBRE_DES,DES.VALORIZACION AS VAL_DES,DES.NOMBRE_VALORIZACION AS NOMB_VAL_DES
			FROM RESULTADOS RES
			LEFT JOIN CATEGORIAS CAT ON  CAT.ID_RESULTADO=RES.ID_RESULTADO
			LEFT JOIN INDICADORES IND ON IND.ID_CATEGORIA=CAT.ID_CATEGORIA
			LEFT JOIN DESCRIPCIONES DES ON DES.ID_INDICADOR=IND.ID_INDICADOR
			WHERE RES.ESTADO=1
			AND CAT.ESTADO=1
			AND IND.ESTADO=1
			AND DES.ESTADO=1 ORDER BY RES.ID_RESULTADO,CAT.ID_CATEGORIA,IND.ID_INDICADOR, DES.ID_DESCRIPCION) AS A"))
		->where('ID_SEMESTRE','=',$idSemestre)
		->where('ID_ESPECIALIDAD','=',$idEspecialidad);

    	//dd($sql->get());
		return $sql;
	}

	function copiarRubrica($idSemestre,$idEspecialidad,$rubrica,$idUsuario){
		DB::beginTransaction();
		$status=true;
		$idResultadoIngresar=-1;
		$idCategoriaIngresar=-1;
		$idIndicadorIngresar=-1;
		$idDescripcionIngresar=-1;
        //dd($rubrica);
		//dd($resultadoIngresar);
		try {
			foreach ($rubrica as $resultado) {
        	//dd($resultado);
				$resultadoIngresar=[
					'ID_SEMESTRE'=>$idSemestre,
					'ID_ESPECIALIDAD'=>$idEspecialidad,
					'NOMBRE'=>$resultado['RESULTADO'],
					'DESCRIPCION'=>$resultado['DESCRIPCION'],
					'FECHA_REGISTRO'=>Carbon::now(),
					'FECHA_ACTUALIZACION'=>Carbon::now(),
					'USUARIO_MODIF'=>$idUsuario,
					'ESTADO'=>1,
				];
				$idResultadoIngresar= DB::table('RESULTADOS')->insertGetId($resultadoIngresar);
        	//dd($resultadoIngresar);
				foreach ($resultado['CATEGORIAS'] as $categorias) {
        		//dd($categorias);
					$categoriaIngresar=[
						'ID_RESULTADO'=>$idResultadoIngresar,
						'ID_SEMESTRE'=>$idSemestre,
						'ID_ESPECIALIDAD'=>$idEspecialidad,
						'NOMBRE'=>$categorias['NOMBRE_CATEGORIA'],
						'FECHA_REGISTRO'=>Carbon::now(),
						'FECHA_ACTUALIZACION'=>Carbon::now(),
						'USUARIO_MODIF'=>$idUsuario,
						'ESTADO'=>1,
					];
					$idCategoriaIngresar= DB::table('CATEGORIAS')->insertGetId($categoriaIngresar);
        		//dd($categoriaIngresar);
					foreach($categorias['INDICADORES'] as $indicadores){
        			//dd($indicadores);
						$indicadoresIngresar=[
							'ID_CATEGORIA'=>$idCategoriaIngresar,
							'ID_SEMESTRE'=>$idSemestre,
							'ID_ESPECIALIDAD'=>$idEspecialidad,
							'NOMBRE'=>$indicadores['NOMBRE_INDICADOR'],
							'VALORIZACION'=>$indicadores['VALORIZACION'],
							'FECHA_REGISTRO'=>Carbon::now(),
							'FECHA_ACTUALIZACION'=>Carbon::now(),
							'USUARIO_MODIF'=>$idUsuario,
							'ESTADO'=>1,
						];
						$idIndicadorIngresar= DB::table('INDICADORES')->insertGetId($indicadoresIngresar);
        			//dd($indicadoresIngresar);
						foreach ($indicadores['DESCRIPCIONES'] as $descripciones) {
        				//dd($descripciones);
							$descripcionesIngresar=[
								'ID_INDICADOR'=>$idIndicadorIngresar,        			
								'NOMBRE'=>$descripciones['NOMBRE_DESCRIPCION'],
								'VALORIZACION'=>$descripciones['VALORIZACION'],
								'NOMBRE_VALORIZACION'=>$descripciones['NOMBRE_VALORIZACION'],
								'FECHA_REGISTRO'=>Carbon::now(),
								'FECHA_ACTUALIZACION'=>Carbon::now(),
								'USUARIO_MODIF'=>$idUsuario,
								'ESTADO'=>1,
							];
        			//dd($descripcionesIngresar);
							$idDescripcionIngresar= DB::table('DESCRIPCIONES')->insertGetId($descripcionesIngresar);
						}
					}
				}
			}

			DB::commit();
		} catch (\Exception $e) {
			$status=false;
			Log::error('BASE_DE_DATOS|' . $e->getMessage());
			DB::rollback();
		}	

		return $status;
	}
	public function especialidad()
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
