<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToAlumnosHasHorariosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('alumnos_has_horarios', function(Blueprint $table)
		{
			$table->foreign('ID_ALUMNO', 'FK_ALUMNOS_HAS_HORARIOS_ALUMNOS1')->references('ID_ALUMNO')->on('alumnos')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('ID_HORARIO', 'FK_ALUMNOS_HAS_HORARIOS_HORARIOS1')->references('ID_HORARIO')->on('horario')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('ID_PROYECTO', 'FK_ALUMNOS_HAS_HORARIOS_PROYECTOS1')->references('ID_PROYECTO')->on('proyectos')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('SEMESTRES_ID_SEMESTRE', 'FK_ALUMNOS_HAS_HORARIOS_SEMESTRES1')->references('ID_SEMESTRE')->on('semestres')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('alumnos_has_horarios', function(Blueprint $table)
		{
			$table->dropForeign('FK_ALUMNOS_HAS_HORARIOS_ALUMNOS1');
			$table->dropForeign('FK_ALUMNOS_HAS_HORARIOS_HORARIOS1');
			$table->dropForeign('FK_ALUMNOS_HAS_HORARIOS_PROYECTOS1');
			$table->dropForeign('FK_ALUMNOS_HAS_HORARIOS_SEMESTRES1');
		});
	}

}
