<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHorarioTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('horario', function(Blueprint $table)
		{
			$table->increments('ID_HORARIO');
			$table->integer('ID_CURSO')->unsigned();
			$table->integer('ID_ESPECIALIDAD')->unsigned();
			$table->integer('SEMESTRES_ID_SEMESTRE')->unsigned()->index('FK_HORARIO_SEMESTRES1_IDX');
			$table->string('NOMBRE', 70)->nullable();
			$table->dateTime('FECHA_REGISTRO')->nullable();
			$table->dateTime('FECHA_ACTUALIZACION')->nullable();
			$table->integer('USUARIO_MODIF')->nullable();
			$table->integer('ESTADO')->nullable();
			$table->primary(['ID_HORARIO','ID_CURSO','ID_ESPECIALIDAD','SEMESTRES_ID_SEMESTRE']);
			$table->index(['ID_CURSO','ID_ESPECIALIDAD'], 'FK_HORARIOS_CURSOS1');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('horario');
	}

}
