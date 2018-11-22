<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 30 Sep 2018 22:12:14 +0000.
 */

namespace App\Models;
use DB;
use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Especialidade
 * 
 * @property int $ID_ESPECIALIDAD
 * @property string $NOMBRE
 * @property \Carbon\Carbon $FECHA_REGISTRO
 * @property \Carbon\Carbon $FECHA_ACTUALIZACION
 * @property int $USUARIO_MODIF
 * @property int $ESTADO
 * 
 * @property \Illuminate\Database\Eloquent\Collection $actas
 * @property \Illuminate\Database\Eloquent\Collection $criterios
 * @property \Illuminate\Database\Eloquent\Collection $cursos
 * @property \Illuminate\Database\Eloquent\Collection $eos
 * @property \Illuminate\Database\Eloquent\Collection $especialidades_has_profesores
 * @property \Illuminate\Database\Eloquent\Collection $planes_de_mejoras
 * @property \Illuminate\Database\Eloquent\Collection $sos
 *
 * @package App\Models
 */
class Especialidad extends Eloquent
{
	protected $primaryKey = 'ID_ESPECIALIDAD';
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
		'NOMBRE',
		'FECHA_REGISTRO',
		'FECHA_ACTUALIZACION',
		'USUARIO_MODIF',
		'ESTADO'
	];

	static function fix($cad){
		$cad = lcfirst($cad);
		return ucwords($cad);
	}

	static function getNombreEspecialidad($idEspecialidad){
		$ans = DB::table('ESPECIALIDADES')
				->where('ID_ESPECIALIDAD','=',$idEspecialidad)
				->get()
				->toArray();
		$cad = $ans[0]->NOMBRE;
		return Especialidad::fix($cad);
	}

	public function getEspecialidadUsuario($id_usuario)
	{	
		$sql=DB::table('USUARIOS AS US')
				->select('ES.ID_ESPECIALIDAD','ESPE.NOMBRE AS NOMBRE_ESPECIALIDAD')
				->leftJoin('USUARIOS_HAS_ESPECIALIDADES AS ES',function($join){
					$join->on('US.ID_USUARIO','=','ES.ID_USUARIO');
				})
				->leftJoin('ESPECIALIDADES AS ESPE',function($join){
					$join->on('ES.ID_ESPECIALIDAD','=','ESPE.ID_ESPECIALIDAD');
				})
				->where('US.ID_USUARIO','=',$id_usuario);
		return $sql->first();
	}

	static function getEspecialidadess()
	{	
		$sql=DB::table('ESPECIALIDADES')
				->select()
				->where('ESTADO','=',1)
				->get();
		return $sql;
	}

	public function getEspecialidades()
	{	
		$sql=DB::table('ESPECIALIDADES')
				->select()
				->where('ESTADO','=',1);
		return $sql;
	}	

	public function actas()
	{
		return $this->hasMany(\App\Models\Acta::class, 'ID_ESPECIALIDAD', 'id_especialidad');
	}

	public function criterios()
	{
		return $this->hasMany(\App\Models\Criterio::class, 'ID_ESPECIALIDAD', 'id_especialidad');
	}

	public function cursos()
	{
		return $this->hasMany(\App\Models\Curso::class, 'ID_ESPECIALIDAD', 'id_especialidad');
	}

	public function eos()
	{
		return $this->hasMany(\App\Models\Eos::class, 'ID_ESPECIALIDAD', 'id_especialidad');
	}

	public function usuarios_has_especialidades()
	{
		return $this->hasMany(\App\Models\UsuariosHasEspecialidades::class, 'ID_ESPECIALIDAD');
	}

	public function planes_de_mejoras()
	{
		return $this->hasMany(\App\Models\PlanesDeMejoras::class, 'ID_ESPECIALIDAD');
	}

	public function sos()
	{
		return $this->hasMany(\App\Models\Sos::class, 'ID_ESPECIALIDAD');
	}
}
