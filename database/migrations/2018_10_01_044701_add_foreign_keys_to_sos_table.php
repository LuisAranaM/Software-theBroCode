<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToSosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('sos', function(Blueprint $table)
		{
			$table->foreign('ID_ESPECIALIDAD', 'FK_SOS_ESPECIALIDADES1')->references('ID_ESPECIALIDAD')->on('especialidades')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('ID_SEMESTRE', 'FK_SOS_SEMESTRES1')->references('ID_SEMESTRE')->on('semestres')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('sos', function(Blueprint $table)
		{
			$table->dropForeign('FK_SOS_ESPECIALIDADES1');
			$table->dropForeign('FK_SOS_SEMESTRES1');
		});
	}

}
