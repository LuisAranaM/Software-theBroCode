<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEspecialidadesHasProfesoresTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('especialidades_has_profesores', function(Blueprint $table)
		{
			$table->integer('ID_ESPECIALIDAD')->unsigned();
			$table->integer('ID_USUARIO')->unsigned()->index('FK_ESPECIALIDADES_HAS_PROFESORES_USUARIOS1');
			$table->dateTime('FECHA_REGISTRO')->nullable();
			$table->dateTime('FECHA_ACTUALIZACION')->nullable();
			$table->integer('USUARIO_MODIF')->nullable();
			$table->integer('ESTADO')->nullable();
			$table->primary(['ID_ESPECIALIDAD','ID_USUARIO']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('especialidades_has_profesores');
	}

}
