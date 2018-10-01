<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sos', function(Blueprint $table)
		{
			$table->increments('ID_SOS');
			$table->integer('ID_ESPECIALIDAD')->unsigned()->index('FK_SOS_ESPECIALIDADES1');
			$table->integer('ID_SEMESTRE')->unsigned()->index('FK_SOS_SEMESTRES1');
			$table->string('DESCRIPCION', 100)->nullable();
			$table->dateTime('FECHA_REGISTRO')->nullable();
			$table->dateTime('FECHA_ACTUALIZACION')->nullable();
			$table->integer('USUARIO_MODIF')->nullable();
			$table->integer('ESTADO')->nullable();
			$table->primary(['ID_SOS','ID_ESPECIALIDAD','ID_SEMESTRE']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('sos');
	}

}
