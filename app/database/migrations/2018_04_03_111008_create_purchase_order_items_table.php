<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePurchaseOrderItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('purchase_order_items', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('po_id');
			$table->string('aid');
			$table->integer('quantity');
			$table->decimal('cost_per_item', 10);
			$table->date('estimated_arrival');
			$table->string('tracking');
			$table->string('status');
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
		Schema::drop('purchase_order_items');
	}

}
