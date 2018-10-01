<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSubcriteriosHasCursosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('subcriterios_has_cursos', function(Blueprint $table)
		{
			$table->integer('ID_SUBCRITERIO')->unsigned();
			$table->integer('ID_CRITERIO')->unsigned();
			$table->integer('ID_ESPECIALIDAD')->unsigned();
			$table->integer('ID_SEMESTRE')->unsigned();
			$table->integer('ID_CURSO')->unsigned()->index('FK_SUBCRITERIOS_HAS_CURSOS_CURSOS1');
			$table->dateTime('FECHA_REGISTRO')->nullable();
			$table->dateTime('FECHA_ACTUALIZACION')->nullable();
			$table->integer('USUARIO_MODIF')->nullable();
			$table->integer('ESTADO')->nullable();
			$table->primary(['ID_SUBCRITERIO','ID_CRITERIO','ID_ESPECIALIDAD','ID_SEMESTRE','ID_CURSO']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('subcriterios_has_cursos');
	}

}
