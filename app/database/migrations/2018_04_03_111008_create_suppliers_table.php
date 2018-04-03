<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

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
			$table->integer('seller_id');
			$table->string('title');
			$table->string('image')->nullable()->default('NULL');
			$table->string('rep')->nullable()->default('NULL');
			$table->string('phone');
			$table->string('email');
			$table->string('website');
			$table->string('address1')->nullable()->default('NULL');
			$table->string('address2')->nullable()->default('NULL');
			$table->string('city');
			$table->string('state');
			$table->string('zip')->nullable()->default('NULL');
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
