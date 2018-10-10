<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 30 Sep 2018 22:12:14 +0000.
 */

namespace App\Models;
use DB;
use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Subcriterio
 * 
 * @property int $ID_SUBCRITERIO
 * @property int $ID_CRITERIO
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
class Subcriterio extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'ID_CRITERIO' => 'int',
		'ID_ESPECIALIDAD' => 'int',
		'ID_SEMESTRE' => 'int',
		'USUARIO_MODIF' => 'int',
		'ESTADO' => 'int'
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
		return $this->belongsTo(\App\Models\Criterio::class, 'ID_CRITERIO')
					->where('criterio.ID_CRITERIO', '=', 'subcriterios.ID_CRITERIO')
					->where('criterio.ID_ESPECIALIDAD', '=', 'subcriterios.ID_ESPECIALIDAD')
					->where('criterio.ID_SEMESTRE', '=', 'subcriterios.ID_SEMESTRE');
	}

	public function alumnos_has_horarios()
	{
		return $this->belongsToMany(\App\Models\AlumnosHasHorario::class, 'subcriterios_has_alumnos_has_horarios', 'ID_SUBCRITERIO', 'ID_ALUMNO')
					->withPivot('ID_CRITERIO', 'ID_ESPECIALIDAD', 'ID_SEMESTRE', 'ID_HORARIO', 'ID_ESCALA', 'semestres_ID_SEMESTRE', 'FECHA_REGISTRO', 'FECHA_ACTUALIZACION', 'USUARIO_MODIF', 'ESTADO');
	}

	public function cursos()
	{
		return $this->belongsToMany(\App\Models\Curso::class, 'subcriterios_has_cursos', 'ID_SUBCRITERIO', 'ID_CURSO')
					->withPivot('ID_CRITERIO', 'ID_ESPECIALIDAD', 'ID_SEMESTRE', 'FECHA_REGISTRO', 'FECHA_ACTUALIZACION', 'USUARIO_MODIF', 'ESTADO');
	}

	static function getSubcriteriosId($idCat) {
        $sql = DB::table('SUBCRITERIOS')
                ->join('CRITERIO', 'SUBCRITERIOS.ID_CRITERIO', '=', 'CRITERIO.ID_CRITERIO')
                ->select('SUBCRITERIOS.*','CRITERIO.ID_CATEGORIA')
                ->where('SUBCRITERIOS.ID_CRITERIO', '=', $idCat)
                ->where('SUBCRITERIOS.ESTADO','=', 1);
        //dd($sql->get());
        return $sql;
    }

    static function getSubcriterios() {
        $sql = DB::table('SUBCRITERIOS')
                ->join('CRITERIO', 'SUBCRITERIOS.ID_CRITERIO', '=', 'CRITERIO.ID_CRITERIO')
                ->select('SUBCRITERIOS.*','CRITERIO.ID_CATEGORIA')
                ->where('SUBCRITERIOS.ESTADO','=', 1);
        //dd($sql->get());
        return $sql;
    }

	public function insertSubCriterio($idCrit,$idEsp,$idSem,$nombre, $desc1,$desc2,$desc3,$desc4){
		//Falta añadir excepción
		$id = DB::table('SUBCRITERIOS')->insertGetId(
		    	['ID_CRITERIO' => $idCrit,
		     	 'ID_ESPECIALIDAD' => $idEsp,
		     	 'ID_SEMESTRE' => $idSem,
		     	 'NOMBRE' => $nombre,
		     	 'DESCRIPCION_1' => $desc1,
		     	 'DESCRIPCION_2' => $desc2,
		     	 'DESCRIPCION_3' => $desc3,
		     	 'DESCRIPCION_4' => $desc4,
				 'ESTADO' => 1]);
		DB::commit();
		return $id;
	}
}
