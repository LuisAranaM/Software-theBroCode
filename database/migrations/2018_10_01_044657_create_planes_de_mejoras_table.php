<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePlanesDeMejorasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('planes_de_mejoras', function(Blueprint $table)
		{
			$table->increments('ID_PLAN');
			$table->integer('ID_SEMESTRE')->unsigned()->index('FK_PLANDEMEJORAS_SEMESTRES1');
			$table->integer('ID_ESPECIALIDAD')->unsigned()->index('FK_PLANDEMEJORAS_ESPECIALIDADES1');
			$table->binary('PLAN', 16777215)->nullable();
			$table->dateTime('FECHA_REGISTRO')->nullable();
			$table->dateTime('FECHA_ACTUALIZACION')->nullable();
			$table->integer('USUARIO_MODIF')->nullable();
			$table->integer('ESTADO')->nullable();
			$table->primary(['ID_PLAN','ID_SEMESTRE','ID_ESPECIALIDAD']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('planes_de_mejoras');
	}

}
