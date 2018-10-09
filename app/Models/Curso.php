<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 04 Oct 2018 18:18:52 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class CURSO
 * 
 * @property int $ID_CURSO
 * @property int $ID_ESPECIALIDAD
 * @property int $SEMESTRES_ID_SEMESTRE
 * @property string $NOMBRE
 * @property string $CODIGO_CURSO
 * @property \Carbon\Carbon $FECHA_REGISTRO
 * @property \Carbon\Carbon $FECHA_ACTUALIZACION
 * @property int $ESTADO_ACREDITACION
 * @property int $USUARIO_MODIF
 * @property int $ESTADO
 * 
 * @property \App\Models\ESPECIALIDADE $e_s_p_e_c_i_a_l_i_d_a_d_e
 * @property \App\Models\SEMESTRE $s_e_m_e_s_t_r_e
 * @property \Illuminate\Database\Eloquent\Collection $h_o_r_a_r_i_o_s
 * @property \Illuminate\Database\Eloquent\Collection $s_u_b_c_r_i_t_e_r_i_o_s
 *
 * @package App\Models
 */
class CURSO extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'ID_ESPECIALIDAD' => 'int',
		'SEMESTRES_ID_SEMESTRE' => 'int',
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

	public function e_s_p_e_c_i_a_l_i_d_a_d_e()
	{
		return $this->belongsTo(\App\Models\ESPECIALIDADE::class, 'ID_ESPECIALIDAD');
	}

	public function s_e_m_e_s_t_r_e()
	{
		return $this->belongsTo(\App\Models\SEMESTRE::class, 'SEMESTRES_ID_SEMESTRE');
	}

	public function h_o_r_a_r_i_o_s()
	{
		return $this->hasMany(\App\Models\HORARIO::class, 'ID_CURSO');
	}

	public function s_u_b_c_r_i_t_e_r_i_o_s()
	{
		return $this->belongsToMany(\App\Models\SUBCRITERIO::class, 'SUBCRITERIOS_HAS_CURSOS', 'ID_CURSO', 'ID_SUBCRITERIO')
					->withPivot('ID_CRITERIO', 'ID_ESPECIALIDAD', 'ID_SEMESTRE', 'FECHA_REGISTRO', 'FECHA_ACTUALIZACION', 'USUARIO_MODIF', 'ESTADO');
	}
}
