<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
			$table->decimal('cost_per_item', 10, 2);
			$table->decimal('total', 10, 2);
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
