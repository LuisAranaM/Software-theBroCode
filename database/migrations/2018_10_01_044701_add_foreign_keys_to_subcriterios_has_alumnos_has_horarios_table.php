<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToSubcriteriosHasAlumnosHasHorariosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('subcriterios_has_alumnos_has_horarios', function(Blueprint $table)
		{
			$table->foreign('ID_ALUMNO', 'FK_SUBCRITERIOS_HAS_ALUMNOS_HAS_HORARIOS_ALUMNOS_HAS_HORARIOS1')->references('ID_ALUMNO')->on('alumnos_has_horarios')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('ID_ESCALA', 'FK_SUBCRITERIOS_HAS_ALUMNOS_HAS_HORARIOS_ESCALACALIFICACION1')->references('ID_ESCALA')->on('escala_calificacion')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('SEMESTRES_ID_SEMESTRE', 'FK_SUBCRITERIOS_HAS_ALUMNOS_HAS_HORARIOS_SEMESTRES1')->references('ID_SEMESTRE')->on('semestres')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('ID_SUBCRITERIO', 'FK_SUBCRITERIOS_HAS_ALUMNOS_HAS_HORARIOS_SUBCRITERIOS1')->references('ID_SUBCRITERIO')->on('subcriterios')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('subcriterios_has_alumnos_has_horarios', function(Blueprint $table)
		{
			$table->dropForeign('FK_SUBCRITERIOS_HAS_ALUMNOS_HAS_HORARIOS_ALUMNOS_HAS_HORARIOS1');
			$table->dropForeign('FK_SUBCRITERIOS_HAS_ALUMNOS_HAS_HORARIOS_ESCALACALIFICACION1');
			$table->dropForeign('FK_SUBCRITERIOS_HAS_ALUMNOS_HAS_HORARIOS_SEMESTRES1');
			$table->dropForeign('FK_SUBCRITERIOS_HAS_ALUMNOS_HAS_HORARIOS_SUBCRITERIOS1');
		});
	}

}
