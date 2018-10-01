<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToSosHasEosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('sos_has_eos', function(Blueprint $table)
		{
			$table->foreign('ID_EOS', 'FK_SOS_HAS_EOS_EOS1')->references('ID_EOS')->on('eos')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('ID_SOS', 'FK_SOS_HAS_EOS_SOS1')->references('ID_SOS')->on('sos')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('sos_has_eos', function(Blueprint $table)
		{
			$table->dropForeign('FK_SOS_HAS_EOS_EOS1');
			$table->dropForeign('FK_SOS_HAS_EOS_SOS1');
		});
	}

}
