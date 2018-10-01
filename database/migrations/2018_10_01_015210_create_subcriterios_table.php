<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSubcriteriosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('subcriterios', function(Blueprint $table)
		{
			$table->increments('ID_SUBCRITERIO');
			$table->integer('ID_CRITERIO')->unsigned();
			$table->integer('ID_ESPECIALIDAD')->unsigned();
			$table->integer('ID_SEMESTRE')->unsigned();
			$table->string('NOMBRE', 45)->nullable();
			$table->string('DESCRIPCION_1', 145)->nullable();
			$table->string('DESCRIPCION_2', 145)->nullable();
			$table->string('DESCRIPCION_3', 145)->nullable();
			$table->string('DESCRIPCION_4', 145)->nullable();
			$table->dateTime('FECHA_REGISTRO')->nullable();
			$table->dateTime('FECHA_ACTUALIZACON')->nullable();
			$table->integer('USUARIO_MODIF')->nullable();
			$table->integer('ESTADO')->nullable();
			$table->primary(['ID_SUBCRITERIO','ID_CRITERIO','ID_ESPECIALIDAD','ID_SEMESTRE']);
			$table->index(['ID_CRITERIO','ID_ESPECIALIDAD','ID_SEMESTRE'], 'FK_SUBCRITERIOS_CRITERIOS1');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('subcriterios');
	}

}
