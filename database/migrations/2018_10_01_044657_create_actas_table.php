<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateActasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('actas', function(Blueprint $table)
		{
			$table->increments('ID_ACTA');
			$table->integer('ID_SEMESTRE')->unsigned()->index('FK_ACTAS_SEMESTRES1');
			$table->integer('ID_ESPECIALIDAD')->unsigned()->index('FK_ACTAS_ESPECIALIDADES1');
			$table->binary('ACTA', 16777215)->nullable();
			$table->dateTime('FECHA_REGISTRO')->nullable();
			$table->dateTime('FECHA_ACTUALIZACION')->nullable();
			$table->integer('USUARIO_MODIF')->nullable();
			$table->integer('ESTADO')->nullable();
			$table->primary(['ID_ACTA','ID_SEMESTRE','ID_ESPECIALIDAD']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('actas');
	}

}
