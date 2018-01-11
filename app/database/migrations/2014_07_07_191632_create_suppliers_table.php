<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuppliersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('suppliers', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('title');
			$table->string('image');
			$table->string('rep');
			$table->string('phone');
			$table->string('email');
			$table->string('website');
			$table->string('address1');
			$table->string('address2');
			$table->string('city');
			$table->string('state');
			$table->string('zip');
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
		Schema::drop('suppliers');
	}

}
