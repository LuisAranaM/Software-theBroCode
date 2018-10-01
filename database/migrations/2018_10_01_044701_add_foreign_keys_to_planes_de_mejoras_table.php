<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToPlanesDeMejorasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('planes_de_mejoras', function(Blueprint $table)
		{
			$table->foreign('ID_ESPECIALIDAD', 'FK_PLANDEMEJORAS_ESPECIALIDADES1')->references('ID_ESPECIALIDAD')->on('especialidades')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('ID_SEMESTRE', 'FK_PLANDEMEJORAS_SEMESTRES1')->references('ID_SEMESTRE')->on('semestres')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('planes_de_mejoras', function(Blueprint $table)
		{
			$table->dropForeign('FK_PLANDEMEJORAS_ESPECIALIDADES1');
			$table->dropForeign('FK_PLANDEMEJORAS_SEMESTRES1');
		});
	}

}
