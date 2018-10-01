<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToProfesoresHasHorariosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('profesores_has_horarios', function(Blueprint $table)
		{
			$table->foreign('ID_HORARIO', 'FK_PROFESORES_HAS_HORARIOS_HORARIOS1')->references('ID_HORARIO')->on('horario')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('ID_USUARIO', 'FK_PROFESORES_HAS_HORARIOS_USUARIOS1')->references('ID_USUARIO')->on('usuarios')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('profesores_has_horarios', function(Blueprint $table)
		{
			$table->dropForeign('FK_PROFESORES_HAS_HORARIOS_HORARIOS1');
			$table->dropForeign('FK_PROFESORES_HAS_HORARIOS_USUARIOS1');
		});
	}

}
