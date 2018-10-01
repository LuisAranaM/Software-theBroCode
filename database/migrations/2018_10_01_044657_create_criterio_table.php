<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCriterioTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('criterio', function(Blueprint $table)
		{
			$table->increments('ID_CRITERIO');
			$table->integer('ID_ESPECIALIDAD')->unsigned()->index('FK_CRITERIOS_ESPECIALIDADES1');
			$table->integer('ID_SEMESTRE')->unsigned()->index('FK_CRITERIOS_SEMESTRES1');
			$table->string('NOMBRE', 45)->nullable();
			$table->dateTime('FECHA_REGISTRO')->nullable();
			$table->dateTime('FECHA_ACTUALIZACION')->nullable();
			$table->integer('USUARIO_MODIF')->nullable();
			$table->integer('ESTADO')->nullable();
			$table->primary(['ID_CRITERIO','ID_ESPECIALIDAD','ID_SEMESTRE']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('criterio');
	}

}
