<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAlumnosHasHorariosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('alumnos_has_horarios', function(Blueprint $table)
		{
			$table->integer('ID_ALUMNO')->unsigned();
			$table->integer('ID_HORARIO')->unsigned()->index('FK_ALUMNOS_HAS_HORARIOS_HORARIOS1');
			$table->integer('ID_PROYECTO')->unsigned()->index('FK_ALUMNOS_HAS_HORARIOS_PROYECTOS1');
			$table->integer('SEMESTRES_ID_SEMESTRE')->unsigned()->index('FK_ALUMNOS_HAS_HORARIOS_SEMESTRES1_IDX');
			$table->dateTime('FECHA_REGISTRO')->nullable();
			$table->dateTime('FECHA_ACTUALIZACION')->nullable();
			$table->integer('USUARIO_MODIF')->nullable();
			$table->integer('ESTADO')->nullable();
			$table->primary(['ID_ALUMNO','ID_HORARIO','ID_PROYECTO','SEMESTRES_ID_SEMESTRE']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('alumnos_has_horarios');
	}

}
