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
 * Class Curso
 * 
 * @property int $ID_CURSO
 * @property int $ID_ESPECIALIDAD
 * @property int $semestres_ID_SEMESTRE
 * @property string $NOMBRE
 * @property string $CODIGO_CURSO
 * @property \Carbon\Carbon $FECHA_REGISTRO
 * @property \Carbon\Carbon $FECHA_ACTUALIZACION
 * @property int $ESTADO_ACREDITACION
 * @property int $USUARIO_MODIF
 * @property int $ESTADO
 * 
 * @property \App\Models\Especialidade $especialidade
 * @property \App\Models\Semestre $semestre
 * @property \Illuminate\Database\Eloquent\Collection $horarios
 * @property \Illuminate\Database\Eloquent\Collection $subcriterios
 *
 * @package App\Models
 */
class Curso extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'ID_ESPECIALIDAD' => 'int',
		'semestres_ID_SEMESTRE' => 'int',
		'ESTADO_ACREDITACION' => 'int',
		'USUARIO_MODIF' => 'int',
		'ESTADO' => 'int'
	];

	protected $dates = [
		'FECHA_REGISTRO',
		'FECHA_ACTUALIZACION'
	];

	protected $fillable = [
		'NOMBRE',
		'CODIGO_CURSO',
		'FECHA_REGISTRO',
		'FECHA_ACTUALIZACION',
		'ESTADO_ACREDITACION',
		'USUARIO_MODIF',
		'ESTADO'
	];

	public function especialidade()
	{
		return $this->belongsTo(\App\Models\Especialidade::class, 'ID_ESPECIALIDAD', 'id_especialidad');
	}

	public function semestre()
	{
		return $this->belongsTo(\App\Models\Semestre::class, 'semestres_ID_SEMESTRE');
	}

	public function horarios()
	{
		return $this->hasMany(\App\Models\Horario::class, 'ID_CURSO');
	}

	public function subcriterios()
	{
		return $this->belongsToMany(\App\Models\Subcriterio::class, 'subcriterios_has_cursos', 'ID_CURSO', 'ID_SUBCRITERIO')
					->withPivot('ID_CRITERIO', 'ID_ESPECIALIDAD', 'ID_SEMESTRE', 'FECHA_REGISTRO', 'FECHA_ACTUALIZACION', 'USUARIO_MODIF', 'ESTADO');
	}

	static function getCursos($idSemestre,$idEspecialidad) {
        $sql = DB::table('CURSOS AS CURSOS')
                ->select('ID_CURSO', 'NOMBRE', 'CODIGO_CURSO')
                ->where('ID_SEMESTRE','=',$idSemestre)
                ->where('ID_ESPECIALIDAD','=',$idEspecialidad)
                ->where('ESTADO','=',1)
                ->where('ESTADO_ACREDITACION','=',1);

        return $sql;
    }

    static function buscarCursos($idSemestre,$idEspecialidad,$nomCurso,$acreditacion=false) {
        $sql = DB::table('CURSOS AS CURSOS')
                ->select('ID_CURSO', 'NOMBRE', 'CODIGO_CURSO')
                ->where('ID_SEMESTRE','=',$idSemestre)
                ->where('ID_ESPECIALIDAD','=',$idEspecialidad)
                ->where('ESTADO','=',1)      
                ->where('NOMBRE','like','%'.$nomCurso.'%');

        if($acreditacion)
        	$sql=$sql->where('ESTADO_ACREDITACION','=',0);
        return $sql;
    }

    function agregarAcreditar($idSemestre,$codigos,$usuario){
    	//dd(Carbon::now());   	
    	DB::beginTransaction();
        $status = true;
       
        try {
			DB::table('CURSOS AS CURSOS')
				->whereIn('CODIGO_CURSO',$codigos)
    			->update(['ESTADO_ACREDITACION'=>1,
	    				'FECHA_ACTUALIZACION'=>Carbon::now(),
	    				'USUARIO_MODIF'=>$usuario]);
            DB::commit();
        } catch (\Exception $e) {
            Log::error('BASE_DE_DATOS|' . $e->getMessage());
            $status = false;
            DB::rollback();
        }
        return $status;
        //dd($sql->get());
    }


}
