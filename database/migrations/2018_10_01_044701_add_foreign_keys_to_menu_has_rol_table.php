<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToMenuHasRolTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('menu_has_rol', function(Blueprint $table)
		{
			$table->foreign('ID_MENU', 'FK_MENU_HAS_ROL_MENU')->references('ID_MENU')->on('menus')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('ID_ROL', 'FK_MENU_HAS_ROL_ROL1')->references('ID_ROL')->on('roles')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('menu_has_rol', function(Blueprint $table)
		{
			$table->dropForeign('FK_MENU_HAS_ROL_MENU');
			$table->dropForeign('FK_MENU_HAS_ROL_ROL1');
		});
	}

}
