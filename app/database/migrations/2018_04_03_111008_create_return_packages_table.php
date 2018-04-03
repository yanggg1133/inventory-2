<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateReturnPackagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('return_packages', function(Blueprint $table)
		{
			$table->integer('ship_id');
			$table->string('tracking_num', 150);
			$table->string('label_fmt', 50);
			$table->text('label_img', 65535);
			$table->integer('scanned');
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('return_packages');
	}

}
