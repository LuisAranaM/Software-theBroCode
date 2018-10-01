<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProfesoresHasHorariosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('profesores_has_horarios', function(Blueprint $table)
		{
			$table->integer('ID_USUARIO')->unsigned();
			$table->integer('ID_HORARIO')->unsigned()->index('FK_PROFESORES_HAS_HORARIOS_HORARIOS1');
			$table->dateTime('FECHA_REGISTRO')->nullable();
			$table->dateTime('FECHA_ACTUALIZACION')->nullable();
			$table->integer('USUARIO_MODIF')->nullable();
			$table->integer('ESTADO')->nullable();
			$table->primary(['ID_USUARIO','ID_HORARIO']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('profesores_has_horarios');
	}

}
