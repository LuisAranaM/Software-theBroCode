<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToSubcriteriosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('subcriterios', function(Blueprint $table)
		{
			$table->foreign('ID_CRITERIO', 'FK_SUBCRITERIOS_CRITERIOS1')->references('ID_CRITERIO')->on('criterio')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('subcriterios', function(Blueprint $table)
		{
			$table->dropForeign('FK_SUBCRITERIOS_CRITERIOS1');
		});
	}

}
