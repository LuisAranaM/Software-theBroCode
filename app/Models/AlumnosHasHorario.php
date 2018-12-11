<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 30 Sep 2018 22:12:14 +0000.
 */

namespace App\Models;
use DB;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class AlumnosHasHorario
 * 
 * @property int $ID_ALUMNO
 * @property int $ID_HORARIO
 * @property int $ID_PROYECTO
 * @property int $ID_SEMESTRE
 * @property \Carbon\Carbon $FECHA_REGISTRO
 * @property \Carbon\Carbon $FECHA_ACTUALIZACION
 * @property int $USUARIO_MODIF
 * @property int $ESTADO
 * 
 * @property \App\Models\Alumno $alumno
 * @property \App\Models\Horario $horario
 * @property \App\Models\Proyecto $proyecto
 * @property \App\Models\Semestre $semestre
 * @property \Illuminate\Database\Eloquent\Collection $subcriterios
 *
 * @package App\Models
 */
class AlumnosHasHorario extends Eloquent
{
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'ID_ALUMNO' => 'int',
		'ID_HORARIO' => 'int',
		'ID_PROYECTO' => 'int',
		'ID_SEMESTRE' => 'int',
		'ID_ESPECIALIDAD' => 'int',
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

	public function alumno()
	{
		return $this->belongsTo(\App\Models\Alumno::class, 'ID_ALUMNO');
	}

	public function horario()
	{
		return $this->belongsTo(\App\Models\Horario::class, 'ID_HORARIO', 'id_horario');
	}

	public function proyecto()
	{
		return $this->belongsTo(\App\Models\Proyecto::class, 'ID_PROYECTO', 'id_proyecto');
	}

	public function semestre()
	{
		return $this->belongsTo(\App\Models\Semestre::class, 'ID_SEMESTRE');
	}



	static public function getAll($idSemestre){
		$ans = DB::table('ALUMNOS_HAS_HORARIOS')
				->select('*')
				->where('ID_SEMESTRE','=',$idSemestre)
				->where('ESTADO','=',1)
				->get();
		return $ans;
	}

	static public function getFull($idSemestre){
		$ans = DB::table('ALUMNOS_HAS_HORARIOS')
				->select('*')
				->where('ID_SEMESTRE','=',$idSemestre)
				->get();
		return $ans;
	}

	static public function getAlumnosByIdHorario($idHorario){
          
        $ans = DB::select("SELECT *, MAX(a1.ID_PROYECTO) as ID_PROYECTO2 from ALUMNOS_HAS_HORARIOS a1
			JOIN ALUMNOS a on (a.ID_ALUMNO = a1.ID_ALUMNO )

			WHERE a1.ID_HORARIO = $idHorario  and a1.ESTADO=1

			group by a1.ID_ALUMNO
			order by CODIGO asc;");
		//dd($ans);
        
        /*$sql=DB::Table('ALUMNOS_HAS_HORARIOS AS A1')
        	->select('A1.*','A2.*',DB::Raw('MAX(A1.ID_PROYECTO) AS ID_PROYECTO2'))
	        ->leftJoin('ALUMNOS AS A2',function($join){
            $join->on('A1.ID_ALUMNO','=','A2.ID_ALUMNO');
        })
	    ->where('A1.ID_HORARIO','=',$idHorario)
	    ->where('A1.ESTADO','=',1)
	    ->groupBy('A1.ID_ALUMNO')
	    ->orderBy('CODIGO');*/
	    
        return $ans;
	}
	static public function getAlumnoXHorario($idHorario){
		$ans = DB::table('ALUMNOS_HAS_HORARIOS')
            ->select('ALUMNOS_HAS_HORARIOS.*')
            ->where('ALUMNOS_HAS_HORARIOS.ID_HORARIO','=',$idHorario)
            ->orderBy('FECHA_ACTUALIZACION', 'desc')
            ->get()->toArray();
        return $ans;
	}



	static public function getAvanceByAlumno($idHorario,$idCurso){
		
		$sql=DB::table('ALUMNOS_HAS_HORARIOS AS AHH')
			->select('AHH.ID_ALUMNO','RES.ID_RESULTADO','RES.CUENTA_TOTAL',DB::raw('IFNULL(IND.CUENTA_ALUMNO,0) AS CUENTA_ALUMNO'))
		->leftJoin(DB::Raw("(
			SELECT ID_CURSO,ID_RESULTADO,COUNT(ID_INDICADOR) CUENTA_TOTAL
			FROM indicadores_has_cursos 
			WHERE ESTADO=1
			GROUP BY ID_CURSO,ID_RESULTADO
		) AS RES"), function ($join){
			$join->on(DB::Raw('1'),'=',DB::Raw('1'));
		})
		->leftJoin(DB::Raw("(
			SELECT ID_HORARIO,ID_ALUMNO,ID_RESULTADO,COUNT(ID_INDICADOR) CUENTA_ALUMNO
			FROM desarrollo.indicadores_has_alumnos_has_horarios
			GROUP BY ID_HORARIO,ID_ALUMNO,ID_RESULTADO
		) AS IND"), function ($join){
			$join->on('IND.ID_ALUMNO','=','AHH.ID_ALUMNO');
			$join->on('AHH.ID_HORARIO', '=' ,'IND.ID_HORARIO');
			$join->on('IND.ID_RESULTADO','=','RES.ID_RESULTADO');
		})
		->where('AHH.ESTADO','=',1)
		->where('AHH.ID_HORARIO','=',$idHorario)
		->where('RES.ID_CURSO','=',$idCurso)
		->orderBy('AHH.ID_ALUMNO');
		return $sql;
	}
}
