<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsuariosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('usuarios', function(Blueprint $table)
		{
			$table->increments('ID_USUARIO');
			$table->integer('ID_ROL')->unsigned()->index('FK_USUARIOS_ROLES1');
			$table->string('USUARIO', 45)->nullable();
			$table->string('PASS', 200)->nullable();
			$table->string('CORREO', 100)->nullable();
			$table->dateTime('FECHA_REGISTRO')->nullable();
			$table->dateTime('FECHA_ACTUALIZACION')->nullable();
			$table->integer('USUARIO_MODIF')->nullable();
			$table->integer('ESTADO')->nullable();
			$table->string('NOMBRES', 50)->nullable();
			$table->string('APELLIDO_PATERNO', 50)->nullable();
			$table->string('APELLIDO_MATERNO', 50)->nullable();
			$table->primary(['ID_USUARIO','ID_ROL']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('usuarios');
	}

}
