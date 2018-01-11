<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sales_orders', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('store_id');
			$table->string('name');
			$table->string('email');
			$table->string('ship_address1');
			$table->string('ship_address2');
			$table->string('ship_city');
			$table->string('ship_state');
			$table->string('ship_zip');
			$table->string('ship_phone');
			$table->string('bill_address1');
			$table->string('bill_address2');
			$table->string('bill_city');
			$table->string('bill_state');
			$table->string('bill_zip');
			$table->string('bill_phone');
			$table->decimal('sub_total', 10, 2);
			$table->decimal('tax', 10, 2);
			$table->decimal('shipping', 10, 2);
			$table->decimal('total', 10, 2);
			$table->string('tracking');
			$table->string('purchase_source');
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
		Schema::drop('sales_orders');
	}

}
