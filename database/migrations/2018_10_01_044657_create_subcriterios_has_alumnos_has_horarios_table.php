<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSubcriteriosHasAlumnosHasHorariosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('subcriterios_has_alumnos_has_horarios', function(Blueprint $table)
		{
			$table->integer('ID_SUBCRITERIO')->unsigned();
			$table->integer('ID_CRITERIO')->unsigned();
			$table->integer('ID_ESPECIALIDAD')->unsigned();
			$table->integer('ID_SEMESTRE')->unsigned();
			$table->integer('ID_ALUMNO')->unsigned();
			$table->integer('ID_HORARIO')->unsigned();
			$table->integer('ID_ESCALA')->unsigned()->index('FK_SUBCRITERIOS_HAS_ALUMNOS_HAS_HORARIOS_ESCALACALIFICACION1');
			$table->integer('SEMESTRES_ID_SEMESTRE')->unsigned()->index('FK_SUBCRITERIOS_HAS_ALUMNOS_HAS_HORARIOS_SEMESTRES1_IDX');
			$table->dateTime('FECHA_REGISTRO')->nullable();
			$table->dateTime('FECHA_ACTUALIZACION')->nullable();
			$table->integer('USUARIO_MODIF')->nullable();
			$table->integer('ESTADO')->nullable();
			$table->primary(['ID_SUBCRITERIO','ID_CRITERIO','ID_ESPECIALIDAD','ID_SEMESTRE','ID_ALUMNO','ID_HORARIO','ID_ESCALA','SEMESTRES_ID_SEMESTRE']);
			$table->index(['ID_ALUMNO','ID_HORARIO'], 'FK_SUBCRITERIOS_HAS_ALUMNOS_HAS_HORARIOS_ALUMNOS_HAS_HORARIOS1');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('subcriterios_has_alumnos_has_horarios');
	}

}
