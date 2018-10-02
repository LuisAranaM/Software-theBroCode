<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToEspecialidadesHasProfesoresTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('especialidades_has_profesores', function(Blueprint $table)
		{
			$table->foreign('ID_ESPECIALIDAD', 'FK_ESPECIALIDADES_HAS_PROFESORES_ESPECIALIDADES1')->references('ID_ESPECIALIDAD')->on('especialidades')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('ID_USUARIO', 'FK_ESPECIALIDADES_HAS_PROFESORES_USUARIOS1')->references('ID_USUARIO')->on('usuarios')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('especialidades_has_profesores', function(Blueprint $table)
		{
			$table->dropForeign('FK_ESPECIALIDADES_HAS_PROFESORES_ESPECIALIDADES1');
			$table->dropForeign('FK_ESPECIALIDADES_HAS_PROFESORES_USUARIOS1');
		});
	}

}
