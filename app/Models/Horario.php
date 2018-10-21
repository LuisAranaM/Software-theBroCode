<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 30 Sep 2018 22:12:14 +0000.
 */

namespace App\Models;

use DB;
use Log;
use App\Entity\Alumno as Alumno;
use Reliese\Database\Eloquent\Model as Eloquent;
use Jenssegers\Date\Date as Carbon;

/**
 * Class Horario
 * 
 * @property int $ID_HORARIO
 * @property int $ID_CURSO
 * @property int $ID_ESPECIALIDAD
 * @property int $semestres_ID_SEMESTRE
 * @property string $NOMBRE
 * @property \Carbon\Carbon $FECHA_REGISTRO
 * @property \Carbon\Carbon $FECHA_ACTUALIZACION
 * @property int $USUARIO_MODIF
 * @property int $ESTADO
 * 
 * @property \App\Models\Curso $curso
 * @property \App\Models\Semestre $semestre
 * @property \Illuminate\Database\Eloquent\Collection $alumnos
 * @property \Illuminate\Database\Eloquent\Collection $profesores_has_horarios
 *
 * @package App\Models
 */
class Horario extends Eloquent
{
	protected $table = 'horario';
	public $timestamps = false;

	protected $casts = [
		'ID_CURSO' => 'int',
		'ID_ESPECIALIDAD' => 'int',
		'semestres_ID_SEMESTRE' => 'int',
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

	public function curso()
	{
		return $this->belongsTo(\App\Models\Curso::class, 'ID_CURSO')
					->where('cursos.ID_CURSO', '=', 'horario.ID_CURSO')
					->where('cursos.ID_ESPECIALIDAD', '=', 'horario.ID_ESPECIALIDAD');
	}

	public function semestre()
	{
		return $this->belongsTo(\App\Models\Semestre::class, 'semestres_ID_SEMESTRE');
	}

	public function alumnos()
	{
		return $this->belongsToMany(\App\Models\Alumno::class, 'alumnos_has_horarios', 'ID_HORARIO', 'ID_ALUMNO')
					->withPivot('ID_PROYECTO', 'semestres_ID_SEMESTRE', 'FECHA_REGISTRO', 'FECHA_ACTUALIZACION', 'USUARIO_MODIF', 'ESTADO');
	}

	public function profesores_has_horarios()
	{
		return $this->hasMany(\App\Models\ProfesoresHasHorario::class, 'ID_HORARIO');
	}


	static function getAvance($idHorario){
		$tot = DB::table('SUBCRITERIOS_HAS_ALUMNOS_HAS_HORARIOS')
				->select('*')
				->whereRaw('ID_HORARIO = ? AND ESTADO = 1',[$idHorario])
				->count();
		$part = DB::table('SUBCRITERIOS_HAS_ALUMNOS_HAS_HORARIOS')
				->select('*')
				->whereRaw('ID_HORARIO = ? AND ID_ESCALA <> 0 AND ESTADO = 1',[$idHorario])
				->count();
		$part *= 100;
		if($tot == 0)
			return 0;
		$ans = $part / $tot;
		return $ans;
	}

	static function getAlumnosCalif($idHorario){
		$alumnos = Alumno::getAlumnosByHorario($idHorario);
		$ans = 0;
		foreach($alumnos as $x){
			$current = DB::table('SUBCRITERIOS_HAS_ALUMNOS_HAS_HORARIOS')
						->select('*')
						->whereRaw('ID_HORARIO = ? AND ID_ALUMNO = ? AND ID_ESCALA <> 0', [$idHorario,$x->ID_ALUMNO])
						->count();
			if($current == 4) 
				++$ans;
		}
		return $ans;
	}

	static function getCantAlumnos($idHorario){
		$tot = DB::table('ALUMNOS_HAS_HORARIOS')
				->select('*')
				->whereRaw('ID_HORARIO = ? AND ESTADO = 1',[$idHorario])
				->count();
		return $tot;
	}

	static function getHorariosCompleto($idCurso,$idSemestre){
		//Tiene que ser por el ID del usuario
		$sql = DB::table('HORARIO')
				->select('*')
				->where('ID_CURSO','=',$idCurso)
				->where('SEMESTRES_ID_SEMESTRE','=',$idSemestre)
				->get();
		return $sql;
	}


	static function getHorarios($idCurso) {
		//dd($idCurso);
        $sql = DB::table('HORARIO AS H')
				->select('H.ID_HORARIO', 'P.ID_USUARIO', 'H.NOMBRE AS NOMBRE_HORARIO', 'H.ESTADO AS ESTADO',DB::Raw('CONCAT(P.NOMBRES, " " , P.APELLIDO_PATERNO) AS NOMBRE_PROFESOR'))
                ->leftJoin('PROFESORES_HAS_HORARIOS AS PH', function ($join) {
					$join->on('H.ID_HORARIO', '=', 'PH.ID_HORARIO');
				})
				->leftJoin('USUARIOS AS P', function ($join) {
					$join->on('PH.ID_USUARIO', '=', 'P.ID_USUARIO');
				})

				->where('H.ID_CURSO', '=', $idCurso);

        //dd($sql->get());
        return $sql;
	}

	static function getHorarioByIdHorario($idHorario){
		//dd($idCurso);
        $sql = DB::table('HORARIO AS H')
				->select('H.*')
				->where('H.ID_HORARIO', '=', $idHorario)

				;

        //dd($sql->get());
        return $sql;

	}
		
	
	function actualizarHorarios($idHorarios,$estadoEv,$usuario){
		DB::beginTransaction();
		//dd($idHorarios,$estadoEv,$usuario);
        $status = true;
		try {
			foreach(array_combine($idHorarios,$estadoEv) as  $idHorario => $estado ){
				DB::table('HORARIO AS H')
				->where('H.ID_HORARIO', $idHorario)
				->update(['H.ESTADO' => (int)$estado,
						'H.FECHA_ACTUALIZACION'=>Carbon::now(),
						'H.USUARIO_MODIF'=>$usuario]);
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

	function eliminarEvaluacion($idSemestre,$idHorario,$usuario){
    	 	
    	DB::beginTransaction();
        $status = true;
       
        try {
			DB::table('HORARIO AS H')
				->where('H.ID_HORARIO', (int)$idHorario)
    			->update(['H.ESTADO'=> 0,
	    				'H.FECHA_ACTUALIZACION'=>Carbon::now(),
	    				'H.USUARIO_MODIF'=>$usuario]);
			DB::commit();
			dd($idSemestre,$idHorario,$usuario);  
        } catch (\Exception $e) {
            Log::error('BASE_DE_DATOS|' . $e->getMessage());
            $status = false;
            DB::rollback();
		}
		
        return $status;
        dd($sql->get());
    }


}
