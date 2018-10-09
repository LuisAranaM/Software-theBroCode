<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCursosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Cursos', function(Blueprint $table)
		{
			$table->increments('ID_CURSO');
			$table->integer('ID_ESPECIALIDAD')->unsigned()->index('FK_CURSOS_ESPECIALIDADES1');
			$table->integer('SEMESTRES_ID_SEMESTRE')->unsigned()->index('FK_CURSOS_SEMESTRES1_IDX');
			$table->string('NOMBRE', 45)->nullable();
			$table->string('CODIGO_CURSO', 45)->nullable();
			$table->dateTime('FECHA_REGISTRO')->nullable();
			$table->dateTime('FECHA_ACTUALIZACION')->nullable();
			$table->integer('ESTADO_ACREDITACION')->nullable();
			$table->integer('USUARIO_MODIF')->nullable();
			$table->integer('ESTADO')->nullable();
			$table->primary(['ID_CURSO','ID_ESPECIALIDAD','SEMESTRES_ID_SEMESTRE']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('Cursos');
	}

}
