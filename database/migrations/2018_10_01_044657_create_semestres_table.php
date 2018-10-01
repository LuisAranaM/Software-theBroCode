<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSemestresTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('semestres', function(Blueprint $table)
		{
			$table->increments('ID_SEMESTRE');
			$table->dateTime('FECHA_INICIO')->nullable();
			$table->dateTime('FECHA_FIN')->nullable();
			$table->dateTime('FECHA_ALERTA')->nullable();
			$table->integer('ANHO')->nullable();
			$table->integer('CICLO')->nullable();
			$table->dateTime('FECHA_REGISTRO')->nullable();
			$table->dateTime('FECHA_ACTUALIZACION')->nullable();
			$table->integer('USUARIO_MODIF')->nullable();
			$table->integer('ESTADO')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('semestres');
	}

}
