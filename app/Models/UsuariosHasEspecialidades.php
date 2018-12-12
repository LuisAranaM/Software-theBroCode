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
 * Class UsuariosHasEspecialidades
 * 
 * @property int $ID_ESPECIALIDAD
 * @property int $ID_USUARIO
 * @property \Carbon\Carbon $FECHA_REGISTRO
 * @property \Carbon\Carbon $FECHA_ACTUALIZACION
 * @property int $USUARIO_MODIF
 * @property int $ESTADO
 * 
 * @property \App\Models\Usuario $usuario
 * @property \App\Models\Especialidade $especialidade
 *
 * @package App\Models
 */
class UsuariosHasEspecialidades extends Eloquent
{
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'ID_ESPECIALIDAD' => 'int',
		'ID_USUARIO' => 'int',
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

	public function usuario()
	{
		return $this->belongsTo(\App\Models\Usuario::class, 'ID_USUARIO', 'id_usuario');
	}

	public function especialidad()
	{
		return $this->belongsTo(\App\Models\Especialidad::class, 'ID_ESPECIALIDAD');
	}

	function verComoEspecialidad($data){
		//dd(Carbon::now());    
		DB::beginTransaction();
		$status = true;

		try {

			DB::table('USUARIOS_HAS_ESPECIALIDADES')                
			->where('ID_USUARIO','=',$data['ID_USUARIO'])
			->where('ESTADO','=',1)
			->delete();

			DB::table('USUARIOS_HAS_ESPECIALIDADES')                
			->insert($data);

			DB::commit();
		} catch (\Exception $e) {
			Log::error('BASE_DE_DATOS|' . $e->getMessage());
			$status = false;
			DB::rollback();
		}
		return $status;
    }
}
