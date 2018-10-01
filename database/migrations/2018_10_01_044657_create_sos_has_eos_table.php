<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSosHasEosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sos_has_eos', function(Blueprint $table)
		{
			$table->integer('ID_SOS')->unsigned();
			$table->integer('ID_ESPECIALIDAD')->unsigned();
			$table->integer('ID_SEMESTRE')->unsigned();
			$table->integer('ID_EOS')->unsigned()->index('FK_SOS_HAS_EOS_EOS1');
			$table->dateTime('FECHA_REGISTRO')->nullable();
			$table->dateTime('FECHA_ACTUALIZACION')->nullable();
			$table->integer('USUARIO_MODIF')->nullable();
			$table->integer('ESTADO')->nullable();
			$table->primary(['ID_SOS','ID_ESPECIALIDAD','ID_SEMESTRE','ID_EOS']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('sos_has_eos');
	}

}
