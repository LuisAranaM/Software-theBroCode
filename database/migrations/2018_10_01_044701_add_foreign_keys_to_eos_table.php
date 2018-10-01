<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToEosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('eos', function(Blueprint $table)
		{
			$table->foreign('ID_ESPECIALIDAD', 'FK_EOS_ESPECIALIDADES1')->references('ID_ESPECIALIDAD')->on('especialidades')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('ID_SEMESTRE', 'FK_EOS_SEMESTRES1')->references('ID_SEMESTRE')->on('semestres')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('eos', function(Blueprint $table)
		{
			$table->dropForeign('FK_EOS_ESPECIALIDADES1');
			$table->dropForeign('FK_EOS_SEMESTRES1');
		});
	}

}
