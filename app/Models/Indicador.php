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
 * Class Subcriterio
 * 
 * @property int $ID_SUBCRITERIO
 * @property int $ID_RESULTADO
 * @property int $ID_ESPECIALIDAD
 * @property int $ID_SEMESTRE
 * @property string $NOMBRE
 * @property string $DESCRIPCION_1
 * @property string $DESCRIPCION_2
 * @property string $DESCRIPCION_3
 * @property string $DESCRIPCION_4
 * @property \Carbon\Carbon $FECHA_REGISTRO
 * @property \Carbon\Carbon $FECHA_ACTUALIZACON
 * @property int $USUARIO_MODIF
 * @property int $ESTADO
 * 
 * @property \App\Models\Criterio $criterio
 * @property \Illuminate\Database\Eloquent\Collection $alumnos_has_horarios
 * @property \Illuminate\Database\Eloquent\Collection $cursos
 *
 * @package App\Models
 */
class Indicador extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'ID_CATEGORIA' => 'int',
		'ID_ESPECIALIDAD' => 'int',
		'ID_SEMESTRE' => 'int',
		'USUARIO_MODIF' => 'int',
		'ESTADO' => 'int',
		'VALORIZACION' => 'int'
	];

	protected $dates = [
		'FECHA_REGISTRO',
		'FECHA_ACTUALIZACON'
	];

	protected $fillable = [
		'NOMBRE',
		'DESCRIPCION_1',
		'DESCRIPCION_2',
		'DESCRIPCION_3',
		'DESCRIPCION_4',
		'FECHA_REGISTRO',
		'FECHA_ACTUALIZACON',
		'USUARIO_MODIF',
		'ESTADO'
	];

	public function criterio()
	{
		return $this->belongsTo(\App\Models\Criterio::class, 'ID_RESULTADO')
					->where('criterio.ID_RESULTADO', '=', 'subcriterios.ID_RESULTADO')
					->where('criterio.ID_ESPECIALIDAD', '=', 'subcriterios.ID_ESPECIALIDAD')
					->where('criterio.ID_SEMESTRE', '=', 'subcriterios.ID_SEMESTRE');
	}

	public function alumnos_has_horarios()
	{
		return $this->belongsToMany(\App\Models\AlumnosHasHorario::class, 'subcriterios_has_alumnos_has_horarios', 'ID_SUBCRITERIO', 'ID_ALUMNO')
					->withPivot('ID_CRITERIO', 'ID_ESPECIALIDAD', 'ID_SEMESTRE', 'ID_HORARIO', 'ID_ESCALA', 'ID_SEMESTRE', 'FECHA_REGISTRO', 'FECHA_ACTUALIZACION', 'USUARIO_MODIF', 'ESTADO');
	}

	public function cursos()
	{
		return $this->belongsToMany(\App\Models\Curso::class, 'indicadores_has_cursos', 'ID_SUBCRITERIO', 'ID_CURSO')
					->withPivot('ID_RESULTADO', 'ID_ESPECIALIDAD', 'ID_SEMESTRE', 'FECHA_REGISTRO', 'FECHA_ACTUALIZACION', 'USUARIO_MODIF', 'ESTADO');
	}


	static function getIndicadoresId($idCat) {
        $sql = DB::table('INDICADORES')
                ->where('ID_CATEGORIA', '=', $idCat)
                ->where('.ESTADO','=', 1);
        //dd($sql->get());
        return $sql;
    }
	static function getIndicadoresByRes($idRes){
		$sql = DB::table('INDICADORES')
                ->join('CATEGORIAS', 'INDICADORES.ID_CATEGORIA', '=', 'CATEGORIAS.ID_CATEGORIA')
                ->select('INDICADORES.*')
                ->where('INDICADORES.ESTADO','=', 1)
                ->where('CATEGORIAS.ID_RESULTADO','=', $idRes);
        return $sql;
	}
    static function getIndicador() {
        $sql = DB::table('INDICADORES')
                ->join('CATEGORIAS', 'INDICADORES.ID_CATEGORIA', '=', 'CATEGORIAS.ID_CATEGORIA')
                ->select('INDICADORES.*','CATEGORIAS.ID_CATEGORIA')
                ->where('INDICADORES.ESTADO','=', 1);

        //dd($sql->get());
        return $sql;
    }

	static function getIndicadores($idSem,$idEsp) {
		$sql = DB::table('INDICADORES')
				->select('RESULTADOS.ID_RESULTADO', 'RESULTADOS.NOMBRE','INDICADORES.ID_INDICADOR','INDICADORES.VALORIZACION','INDICADORES.NOMBRE')
				->leftJoin('CATEGORIAS', 'INDICADORES.ID_CATEGORIA', '=', 'CATEGORIAS.ID_CATEGORIA')
				->leftJoin('RESULTADOS', 'RESULTADOS.ID_RESULTADO', '=', 'CATEGORIAS.ID_RESULTADO')
				->where('RESULTADOS.ID_SEMESTRE', '=', $idSem)
				->where('RESULTADOS.ID_ESPECIALIDAD', '=', $idEsp)
				->where('RESULTADOS.ESTADO', '=', 1)
				->where('INDICADORES.ESTADO', '=', 1)
				->distinct()
				->orderBy('RESULTADOS.NOMBRE', 'ASC')
				->orderBy('INDICADORES.VALORIZACION', 'ASC');
		//dd($sql->get());
        return $sql;
    }
	public function insertIndicador($idCat,$nombre,$orden, $idSem,$idEsp){

		DB::beginTransaction();
        $id=-1;
        try {
        	$id = DB::table('INDICADORES')->insertGetId(
		    	['ID_CATEGORIA' => $idCat,
		     	 'NOMBRE' => $nombre,
		     	 'VALORIZACION'=> $orden,
		     	 'ID_SEMESTRE'=> $idSem,
		     	 'ID_ESPECIALIDAD'=>$idEsp,
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
	static function getIndicadorId($idInd){
		$sql = DB::table('INDICADORES')
                ->select('*')
                ->where('ID_INDICADOR', '=', $idInd);
        //dd($sql->get());
        return $sql;
    }
    static function updateIndicador($id, $nombre, $orden){
		DB::beginTransaction();
		$response= -1;
        try {
            DB::table('INDICADORES')->where('ID_INDICADOR',$id)
            	->update(
		    	['NOMBRE' => $nombre,
		    	 'VALORIZACION'=> $orden,
		     	'FECHA_ACTUALIZACION' => Carbon::now(),		
		     	'USUARIO_MODIF' => Auth::id()]);
			DB::commit();
			$response=1;
        } catch (\Exception $e) {
            Log::error('BASE_DE_DATOS|' . $e->getMessage());
            DB::rollback();
        }
        return $response;
    }
    static function deleteIndicador($id){
    	DB::beginTransaction();
        try {
            DB::table('INDICADORES')->where('ID_INDICADOR',$id)
            	->update(
		    	['ESTADO' => 0]);
			DB::commit();
        } catch (\Exception $e) {
            Log::error('BASE_DE_DATOS|' . $e->getMessage());
            DB::rollback();
        }	
	}

	static function getDataGraficoResultadosxCurso($idSemestre,$idCurso,$idEspecialidad){
		$sql=DB::table('INDICADORES_HAS_CURSOS AS IHC')
    	->select('RES.ID_RESULTADO','RES.NOMBRE',
				DB::Raw('IFNULL(SUM(CASE WHEN ESCALA_CALIFICACION>2 THEN 1 ELSE 0 END)/(CASE WHEN COUNT(ESCALA_CALIFICACION)=0 THEN 1 ELSE COUNT(ESCALA_CALIFICACION) END),0) AS PORCENTAJE'))		
		->leftJoin('RESULTADOS AS RES',function($join){
			$join->on('RES.ID_RESULTADO','=','IHC.ID_RESULTADO');
		})
		->leftJoin('INDICADORES AS IND',function($join){
			$join->on('IND.ID_INDICADOR','=','IHC.ID_INDICADOR');
		})
		->leftJoin('CATEGORIAS AS CAT',function($join){
			$join->on('CAT.ID_CATEGORIA','=','IHC.ID_CATEGORIA');
		})
		->leftJoin('CURSOS AS CUR',function($join){
			$join->on('CUR.ID_CURSO','=','IHC.ID_CURSO');
		})
		->leftJoin('HORARIOS AS HOR',function($join){
			$join->on('HOR.ID_CURSO','=','CUR.ID_CURSO');
			$join->on('HOR.ID_SEMESTRE','=','IHC.ID_SEMESTRE');
		})
		->leftJoin('INDICADORES_HAS_ALUMNOS_HAS_HORARIOS AS IHAH',function($join){
			$join->on('IND.ID_INDICADOR','=','IHAH.ID_INDICADOR');
		})
		->where('IHC.ID_SEMESTRE','=',$idSemestre)  
		->where('IHC.ID_ESPECIALIDAD','=',$idEspecialidad)  
		->where('CUR.ESTADO_ACREDITACION','=',1)  
		->where('IHC.ESTADO','=',1)  
		->where('RES.ESTADO','=',1)  
		->where('IND.ESTADO','=',1)  
		->where('CAT.ESTADO','=',1)  
		->where('HOR.ESTADO','=',1)
		->where('CUR.ID_CURSO','=',$idCurso)
		->groupBy('RES.ID_RESULTADO','RES.NOMBRE','RES.DESCRIPCION')
		->havingRaw('count(ESCALA_CALIFICACION) > ?', [0]);

		return $sql;
	}
	
	static function getDataGraficoReporteResultadosCiclo($idSemestre,$idEspecialidad){
		$indicadores=(DB::table('INDICADORES_HAS_CURSOS AS IHC')
    	->select('IHC.ID_RESULTADO','IHC.ID_INDICADOR',
				DB::Raw('IFNULL(SUM(CASE WHEN ESCALA_CALIFICACION>2 THEN 1 ELSE 0 END)/(CASE WHEN COUNT(ESCALA_CALIFICACION)=0 THEN 1 ELSE COUNT(ESCALA_CALIFICACION) END),0) AS PORCENTAJE_PONDERADO'))
		->leftJoin('CURSOS AS CUR',function($join){
			$join->on('CUR.ID_CURSO','=','IHC.ID_CURSO');
		})
		->leftJoin('HORARIOS AS HOR',function($join){
			$join->on('HOR.ID_CURSO','=','CUR.ID_CURSO');
			$join->on('HOR.ID_SEMESTRE','=','IHC.ID_SEMESTRE');
		})
		->leftJoin('INDICADORES_HAS_ALUMNOS_HAS_HORARIOS AS IHAH',function($join){
			$join->on('IHAH.ID_INDICADOR','=','IHC.ID_INDICADOR');
		})
		->where('IHC.ID_SEMESTRE','=',$idSemestre)  
		->where('IHC.ID_ESPECIALIDAD','=',$idEspecialidad)  
		->where('CUR.ESTADO_ACREDITACION','=',1)  
		->where('IHC.ESTADO','=',1)   
		->where('HOR.ESTADO','=',1)
		->groupBy('IHC.ID_RESULTADO','IHC.ID_INDICADOR'))
		->havingRaw('count(ESCALA_CALIFICACION) > ?', [0]);
		$sql = DB::table('RESULTADOS')
        			->joinSub($indicadores, 'indicadores', function ($join) {
					$join->on('indicadores.ID_RESULTADO', '=', 'RESULTADOS.ID_RESULTADO');})
					->select('RESULTADOS.ID_RESULTADO','RESULTADOS.NOMBRE','RESULTADOS.DESCRIPCION',
					DB::Raw('IFNULL(SUM(indicadores.PORCENTAJE_PONDERADO)/(CASE WHEN COUNT(indicadores.PORCENTAJE_PONDERADO)=0 THEN 1 ELSE COUNT(indicadores.PORCENTAJE_PONDERADO) END),0) AS PORCENTAJE'))
					->groupBy('indicadores.ID_RESULTADO');
		//dd($sql->get());
		return $sql;
    }
	static function exportarReporteResultadosCiclo($filtros,$idSemestre,$idEspecialidad){
    	$sql=DB::table('INDICADORES_HAS_CURSOS AS IHC')
    	->select('RES.ID_RESULTADO','RES.NOMBRE AS COD_RESULTADO','RES.DESCRIPCION AS NOMBRE_RESULTADO','CAT.ID_CATEGORIA',
    			'CAT.NOMBRE AS NOMBRE_CATEGORIA','IND.ID_INDICADOR','IND.VALORIZACION','IND.NOMBRE AS NOMBRE_INDICADOR','IHAH.ID_INDICADOR',
				DB::Raw('IFNULL(SUM(CASE WHEN ESCALA_CALIFICACION>2 THEN 1 ELSE 0 END)/(CASE WHEN COUNT(ESCALA_CALIFICACION)=0 THEN 1 ELSE COUNT(ESCALA_CALIFICACION) END),0) AS PORCENTAJE_PONDERADO'))		
		->leftJoin('RESULTADOS AS RES',function($join){
			$join->on('RES.ID_RESULTADO','=','IHC.ID_RESULTADO');
		})
		->leftJoin('INDICADORES AS IND',function($join){
			$join->on('IND.ID_INDICADOR','=','IHC.ID_INDICADOR');
		})
		->leftJoin('CATEGORIAS AS CAT',function($join){
			$join->on('CAT.ID_CATEGORIA','=','IHC.ID_CATEGORIA');
		})
		->leftJoin('CURSOS AS CUR',function($join){
			$join->on('CUR.ID_CURSO','=','IHC.ID_CURSO');
		})
		->leftJoin('HORARIOS AS HOR',function($join){
			$join->on('HOR.ID_CURSO','=','CUR.ID_CURSO');
			$join->on('HOR.ID_SEMESTRE','=','IHC.ID_SEMESTRE');
		})
		->leftJoin('INDICADORES_HAS_ALUMNOS_HAS_HORARIOS AS IHAH',function($join){
			$join->on('IND.ID_INDICADOR','=','IHAH.ID_INDICADOR');
		})
		->leftJoin('ALUMNOS AS ALU',function($join){
			$join->on('ALU.ID_ALUMNO','=','IHAH.ID_ALUMNO');
		})
		->leftJoin('ALUMNOS_HAS_HORARIOS AS AHH',function($join){
			$join->on('AHH.ID_ALUMNO','=','IHAH.ID_ALUMNO');
		})
		->where('IHC.ID_SEMESTRE','=',$idSemestre)  
		->where('IHC.ID_ESPECIALIDAD','=',$idEspecialidad)  
		->where('CUR.ESTADO_ACREDITACION','=',1)  
		->where('IHC.ESTADO','=',1)  
		->where('RES.ESTADO','=',1)  
		->where('IND.ESTADO','=',1)  
		->where('CAT.ESTADO','=',1)  
		->where('HOR.ESTADO','=',1)
		->where('ALU.ESTADO','=',1)
		->where('AHH.ESTADO','=',1)
		->groupBy('RES.ID_RESULTADO','RES.NOMBRE','RES.DESCRIPCION','CAT.ID_CATEGORIA','CAT.NOMBRE' ,
		'IND.ID_INDICADOR','IND.NOMBRE','IHAH.ID_INDICADOR');

		return $sql;
    }

    static function getReporteCursosResultado($filtros,$idSemestre,$idEspecialidad){
    	$sql=DB::table('INDICADORES_HAS_CURSOS AS IHC')
    	->select('RES.ID_RESULTADO','RES.NOMBRE AS COD_RESULTADO','RES.DESCRIPCION AS NOMBRE_RESULTADO','CAT.ID_CATEGORIA',
    			'CAT.NOMBRE AS NOMBRE_CATEGORIA','IND.ID_INDICADOR','IND.NOMBRE AS NOMBRE_INDICADOR','CUR.ID_CURSO',
    			'CUR.CODIGO_CURSO','CUR.NOMBRE AS NOMBRE_CURSO','IHAH.ID_INDICADOR',DB::Raw('IFNULL(AVG(IHAH.ESCALA_CALIFICACION),0) AS PROMEDIO_CALIF'),
				DB::Raw('IFNULL(SUM(CASE WHEN IHAH.ESCALA_CALIFICACION>2 THEN 1 ELSE 0 END)/(CASE WHEN COUNT(IHAH.ESCALA_CALIFICACION)=0 THEN 1 ELSE COUNT(ESCALA_CALIFICACION) END),0) AS PORCENTAJE_APROBADOS'))		
		->leftJoin('RESULTADOS AS RES',function($join){
			$join->on('RES.ID_RESULTADO','=','IHC.ID_RESULTADO');
		})
		->leftJoin('INDICADORES AS IND',function($join){
			$join->on('IND.ID_INDICADOR','=','IHC.ID_INDICADOR');
		})
		->leftJoin('CATEGORIAS AS CAT',function($join){
			$join->on('CAT.ID_CATEGORIA','=','IHC.ID_CATEGORIA');
		})
		->leftJoin('CURSOS AS CUR',function($join){
			$join->on('CUR.ID_CURSO','=','IHC.ID_CURSO');
		})

		->leftJoin('ALUMNOS AS ALU',function($join){
			$join->on('ALU.ID_ALUMNO','=','IHC.ID_ALUMNO');
		})

		->leftJoin('HORARIOS AS HOR',function($join){
			$join->on('HOR.ID_CURSO','=','CUR.ID_CURSO');
			$join->on('HOR.ID_SEMESTRE','=','IHC.ID_SEMESTRE');
		})
		->leftJoin('INDICADORES_HAS_ALUMNOS_HAS_HORARIOS AS IHAH',function($join){
			$join->on('IHAH.ID_HORARIO','=','HOR.ID_HORARIO');
			$join->on('IND.ID_INDICADOR','=','IHAH.ID_INDICADOR');
		})
		->leftJoin('ALUMNOS AS ALU',function($join){
			$join->on('ALU.ID_ALUMNO','=','IHAH.ID_ALUMNO');
		})
		->leftJoin('ALUMNOS_HAS_HORARIOS AS AHH',function($join){
			$join->on('AHH.ID_ALUMNO','=','IHAH.ID_ALUMNO');
		})
		->where('IHC.ID_SEMESTRE','=',$idSemestre)  
		->where('IHC.ID_ESPECIALIDAD','=',$idEspecialidad)  
		->where('CUR.ESTADO_ACREDITACION','=',1)  
		->where('IHC.ESTADO','=',1)  
		->where('RES.ESTADO','=',1)  
		->where('IND.ESTADO','=',1)  
		->where('CAT.ESTADO','=',1)  
		->where('HOR.ESTADO','=',1)
		->where('ALU.ESTADO','=',1)
		->where('AHH.ESTADO','=',1)
		->groupBy('RES.ID_RESULTADO','RES.NOMBRE','RES.DESCRIPCION','CAT.ID_CATEGORIA','CAT.NOMBRE' ,
		'IND.ID_INDICADOR','IND.NOMBRE','CUR.ID_CURSO','CUR.CODIGO_CURSO','CUR.NOMBRE','IHAH.ID_INDICADOR');
		return $sql;
    }

    static function getInfoResultadoAlumno($idResultado,$idCurso,$idAlumno,$idHorario,$idSemestre,$idEspecialidad){

    	$sql=DB::table('INDICADORES_HAS_CURSOS AS IHC')
    	->select(/*'RES.ID_RESULTADO','RES.NOMBRE AS COD_RESULTADO','RES.DESCRIPCION AS NOMBRE_RESULTADO',*/
    			'IND.ID_INDICADOR','IND.NOMBRE AS NOMBRE_INDICADOR',
    			'DES.ID_DESCRIPCION','DES.NOMBRE AS NOMBRE_DESCRIPCION','DES.VALORIZACION','DES.NOMBRE_VALORIZACION',

    			'IHAH.ESCALA_CALIFICACION','CAT.ID_CATEGORIA','IND.VALORIZACION AS VALORIZACION_INDICADOR')	

		->leftJoin('RESULTADOS AS RES',function($join){
			$join->on('RES.ID_RESULTADO','=','IHC.ID_RESULTADO');
		})
		->leftJoin('INDICADORES AS IND',function($join){
			$join->on('IND.ID_INDICADOR','=','IHC.ID_INDICADOR');
		})
		->leftJoin('DESCRIPCIONES AS DES',function($join){
			$join->on('DES.ID_INDICADOR','=','IHC.ID_INDICADOR');
		})
		->leftJoin('CATEGORIAS AS CAT',function($join){
			$join->on('CAT.ID_CATEGORIA','=','IHC.ID_CATEGORIA');
		})
		->leftJoin('CURSOS AS CUR',function($join){
			$join->on('CUR.ID_CURSO','=','IHC.ID_CURSO');
		})
		->leftJoin('HORARIOS AS HOR',function($join){
			$join->on('HOR.ID_CURSO','=','CUR.ID_CURSO');
			$join->on('HOR.ID_SEMESTRE','=','IHC.ID_SEMESTRE');
		})
		->leftJoin('INDICADORES_HAS_ALUMNOS_HAS_HORARIOS AS IHAH',function($join) use($idAlumno){
			$join->on('IHAH.ID_HORARIO','=','HOR.ID_HORARIO');
			$join->on('IND.ID_INDICADOR','=','IHAH.ID_INDICADOR');
			$join->on('IHAH.ID_ALUMNO','=',DB::Raw($idAlumno));
			$join->on('IHAH.ESTADO','=',DB::Raw(1));
			$join->on('IHAH.ESCALA_CALIFICACION','=','DES.VALORIZACION');
		})
		->where('IHC.ID_RESULTADO','=',$idResultado)
		->where('HOR.ID_HORARIO','=',$idHorario)
		->where('IHC.ID_CURSO','=',$idCurso)
		->where('IHC.ID_SEMESTRE','=',$idSemestre)  
		->where('IHC.ID_ESPECIALIDAD','=',$idEspecialidad)  
		->where('CUR.ESTADO_ACREDITACION','=',1)  
		->where('IHC.ESTADO','=',1)  
		->where('RES.ESTADO','=',1)  
		->where('DES.ESTADO','=',1)  
		->where('IND.ESTADO','=',1)  
		->where('CAT.ESTADO','=',1)  
		->where('HOR.ESTADO','=',1)
		->orderBy('IND.ID_INDICADOR','ASC')
		->orderBy('DES.VALORIZACION','ASC');

		return $sql;
    }
}
