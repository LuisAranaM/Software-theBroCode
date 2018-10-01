<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToActasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('actas', function(Blueprint $table)
		{
			$table->foreign('ID_ESPECIALIDAD', 'FK_ACTAS_ESPECIALIDADES1')->references('ID_ESPECIALIDAD')->on('especialidades')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('ID_SEMESTRE', 'FK_ACTAS_SEMESTRES1')->references('ID_SEMESTRE')->on('semestres')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('actas', function(Blueprint $table)
		{
			$table->dropForeign('FK_ACTAS_ESPECIALIDADES1');
			$table->dropForeign('FK_ACTAS_SEMESTRES1');
		});
	}

}
