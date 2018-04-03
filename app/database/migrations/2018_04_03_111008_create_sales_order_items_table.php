<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSalesOrderItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sales_order_items', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('so_id');
			$table->string('aid');
			$table->integer('quantity');
			$table->decimal('weight', 10)->nullable()->default('NULL');
			$table->decimal('cost_per_item', 10);
			$table->decimal('total', 10);
			$table->decimal('shipping', 10)->nullable()->default('NULL');
			$table->decimal('tax', 10)->nullable()->default('NULL');
			$table->decimal('fee', 10)->nullable()->default('NULL');
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
		Schema::drop('sales_order_items');
	}

}
