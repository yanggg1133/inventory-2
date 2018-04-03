<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

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
			$table->integer('seller_id');
			$table->string('aid');
			$table->string('sku');
			$table->string('mfp');
			$table->string('qbid', 15)->nullable()->default('NULL');
			$table->string('amazon_asin', 15)->nullable()->default('NULL');
			$table->string('title');
			$table->string('image')->nullable()->default('NULL');
			$table->integer('manufacturer_id');
			$table->integer('supplier_id');
			$table->decimal('msrp', 10);
			$table->decimal('cost', 10);
			$table->decimal('price', 10);
			$table->decimal('weight', 10);
			$table->decimal('length', 10);
			$table->decimal('width', 10);
			$table->decimal('height', 10);
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
