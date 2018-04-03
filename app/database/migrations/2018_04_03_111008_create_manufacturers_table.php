<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateManufacturersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('manufacturers', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('seller_id');
			$table->string('title');
			$table->string('image')->nullable()->default('NULL');
			$table->string('phone')->nullable()->default('NULL');
			$table->string('email')->nullable()->default('NULL');
			$table->string('website')->nullable()->default('NULL');
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
		Schema::drop('manufacturers');
	}

}
