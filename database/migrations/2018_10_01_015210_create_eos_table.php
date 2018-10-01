<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('eos', function(Blueprint $table)
		{
			$table->increments('ID_EOS');
			$table->integer('ID_SEMESTRE')->unsigned()->index('FK_EOS_SEMESTRES1');
			$table->integer('ID_ESPECIALIDAD')->unsigned()->index('FK_EOS_ESPECIALIDADES1');
			$table->dateTime('FECHA_REGISTRO')->nullable();
			$table->dateTime('FECHA_ACTUALIZACION')->nullable();
			$table->integer('USUARIO_MODIF')->nullable();
			$table->integer('ESTADO')->nullable();
			$table->primary(['ID_EOS','ID_SEMESTRE','ID_ESPECIALIDAD']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('eos');
	}

}
