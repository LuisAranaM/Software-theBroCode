<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCursosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('cursos', function(Blueprint $table)
		{
			$table->foreign('ID_ESPECIALIDAD', 'FK_CURSOS_ESPECIALIDADES1')->references('ID_ESPECIALIDAD')->on('especialidades')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('SEMESTRES_ID_SEMESTRE', 'FK_CURSOS_SEMESTRES1')->references('ID_SEMESTRE')->on('semestres')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('cursos', function(Blueprint $table)
		{
			$table->dropForeign('FK_CURSOS_ESPECIALIDADES1');
			$table->dropForeign('FK_CURSOS_SEMESTRES1');
		});
	}

}
