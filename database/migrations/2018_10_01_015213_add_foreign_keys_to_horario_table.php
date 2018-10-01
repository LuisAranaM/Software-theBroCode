<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToHorarioTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('horario', function(Blueprint $table)
		{
			$table->foreign('ID_CURSO', 'FK_HORARIOS_CURSOS1')->references('ID_CURSO')->on('cursos')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('SEMESTRES_ID_SEMESTRE', 'FK_HORARIO_SEMESTRES1')->references('ID_SEMESTRE')->on('semestres')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('horario', function(Blueprint $table)
		{
			$table->dropForeign('FK_HORARIOS_CURSOS1');
			$table->dropForeign('FK_HORARIO_SEMESTRES1');
		});
	}

}
