<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVirtualProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('virtual_products', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('seller_id');
			$table->string('asin', 100);
			$table->string('title', 150);
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
		Schema::drop('virtual_products');
	}

}
