<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 30 Sep 2018 22:12:14 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class MenuHasRol
 * 
 * @property int $ID_MENU
 * @property int $ID_ROL
 * @property \Carbon\Carbon $FECHA_REGISTRO
 * @property \Carbon\Carbon $FECHA_ACTUALIZACION
 * @property int $USUARIO_MODIF
 * @property int $ESTADO
 * 
 * @property \App\Models\Menu $menu
 * @property \App\Models\Role $role
 *
 * @package App\Models
 */
class MenuHasRol extends Eloquent
{
	protected $table = 'menu_has_rol';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'ID_MENU' => 'int',
		'ID_ROL' => 'int',
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

	public function menu()
	{
		return $this->belongsTo(\App\Models\Menu::class, 'ID_MENU', 'id_menu');
	}

	public function role()
	{
		return $this->belongsTo(\App\Models\Role::class, 'ID_ROL', 'id_rol');
	}
}
