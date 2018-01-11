<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('products', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('store_id');
			$table->string('aid');
			$table->string('sku');
			$table->string('mfp');
			$table->string('title');
			$table->integer('manufacturer_id');
			$table->integer('supplier_id');
			$table->decimal('msrp', 10, 2);
			$table->decimal('cost', 10, 2);
			$table->decimal('price', 10, 2);
			$table->decimal('weight', 10, 2);
			$table->decimal('length', 10, 2);
			$table->decimal('width', 10, 2);
			$table->decimal('height', 10, 2);
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
		Schema::drop('products');
	}

}
