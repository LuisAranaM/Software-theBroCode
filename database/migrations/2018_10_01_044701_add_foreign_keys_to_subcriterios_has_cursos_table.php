<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToSubcriteriosHasCursosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('subcriterios_has_cursos', function(Blueprint $table)
		{
			$table->foreign('ID_CURSO', 'FK_SUBCRITERIOS_HAS_CURSOS_CURSOS1')->references('ID_CURSO')->on('cursos')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('ID_SUBCRITERIO', 'FK_SUBCRITERIOS_HAS_CURSOS_SUBCRITERIOS1')->references('ID_SUBCRITERIO')->on('subcriterios')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('subcriterios_has_cursos', function(Blueprint $table)
		{
			$table->dropForeign('FK_SUBCRITERIOS_HAS_CURSOS_CURSOS1');
			$table->dropForeign('FK_SUBCRITERIOS_HAS_CURSOS_SUBCRITERIOS1');
		});
	}

}
