<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 30 Sep 2018 22:12:14 +0000.
 */

namespace App\Models;

use DB;
use Log;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Alumno
 * 
 * @property int $ID_ALUMNO
 * @property string $NOMBRES
 * @property string $APELLIDO_PATERNO
 * @property string $APELLIDO_MATERNO
 * @property string $CODIGO
 * @property \Carbon\Carbon $FECHA_REGISTRO
 * @property \Carbon\Carbon $FECHA_ACTUALIZACION
 * @property int $USUARIO_MODIF
 * @property int $ESTADO
 * 
 * @property \Illuminate\Database\Eloquent\Collection $horarios
 *
 * @package App\Models
 */
class Alumno extends Eloquent
{
	protected $primaryKey = 'ID_ALUMNO';
	public $timestamps = false;

	protected $casts = [
		'USUARIO_MODIF' => 'int',
		'ESTADO' => 'int'
	];

	protected $dates = [
		'FECHA_REGISTRO',
		'FECHA_ACTUALIZACION'
	];

	protected $fillable = [
		'NOMBRES',
		'APELLIDO_PATERNO',
		'APELLIDO_MATERNO',
		'CODIGO',
		'FECHA_REGISTRO',
		'FECHA_ACTUALIZACION',
		'USUARIO_MODIF',
		'ESTADO'
	];

	public function horarios()
	{
		return $this->belongsToMany(\App\Models\Horario::class, 'alumnos_has_horarios', 'ID_ALUMNO', 'ID_HORARIO')
					->withPivot('ID_PROYECTO', 'ID_SEMESTRE', 'FECHA_REGISTRO', 'FECHA_ACTUALIZACION', 'USUARIO_MODIF', 'ESTADO');
	}

	static function getAlumnosByHorarioStatic($idHorario){
		$ans = DB::table('ALUMNOS')
            ->join('ALUMNOS_HAS_HORARIOS', 'ALUMNOS.ID_ALUMNO', '=', 'ALUMNOS_HAS_HORARIOS.ID_ALUMNO')
            ->select('ALUMNOS.*')
            ->where('ALUMNOS_HAS_HORARIOS.ID_HORARIO','=',$idHorario)
            ->get();
        return $ans;
	}

	public function getAlumnosByHorario($idHorario){
		$ans = DB::table('ALUMNOS')
            ->join('ALUMNOS_HAS_HORARIOS', 'ALUMNOS.ID_ALUMNO', '=', 'ALUMNOS_HAS_HORARIOS.ID_ALUMNO')
            ->select('ALUMNOS.*')
            ->where('ALUMNOS_HAS_HORARIOS.ID_HORARIO','=',$idHorario)
            ->get();
        return $ans;
	}

	public function insertarIndicadoresxAlumno($datosAlumno){
		DB::table('INDICADORES_HAS_ALUMNOS_HAS_HORARIOS')->insertarIndicadoresxAlumno($datosAlumno);
	}

	function calificarAlumnos($registro){
        //dd($registro);    
        DB::beginTransaction();
        $status = true;
       
        try {
            DB::table('INDICADORES_HAS_ALUMNOS_HAS_HORARIOS')
                ->where('ID_ALUMNO','=',$registro['ID_ALUMNO'])
				->where('ID_HORARIO','=',$registro['ID_HORARIO'])
				->where('ID_INDICADOR','=',$registro['ID_INDICADOR'])
				->where('ID_CATEGORIA','=',$registro['ID_CATEGORIA'])
				//->where('ID_RESULTADO','=',$registro['ID_RESULTADO'])
				//->where('ID_DESCRIPCION','=',$registro['ID_DESCRIPCION'])
				->where('ID_SEMESTRE','=',$registro['ID_SEMESTRE'])
				->where('ID_ESPECIALIDAD','=',$registro['ID_ESPECIALIDAD'])
				//->where('ESTADO','=',1)
				->delete();
                /*->update(['ESTADO'=>0,
                        'FECHA_ACTUALIZACION'=>$registro['FECHA_ACTUALIZACION'],
                        'USUARIO_MODIF'=>$registro['USUARIO_MODIF']]);*/

            DB::table('INDICADORES_HAS_ALUMNOS_HAS_HORARIOS')->insert($registro);   

            DB::commit();
        } catch (\Exception $e) {
            Log::error('BASE_DE_DATOS|' . $e->getMessage());
            $status = false;
            DB::rollback();
        }
        //dd($status);
        return $status;
        //dd($sql->get());
    }


}
