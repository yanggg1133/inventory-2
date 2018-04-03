<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

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
			$table->dateTime('purchase_date');
			$table->string('order_id', 150)->unique('order_id');
			$table->integer('seller_id');
			$table->string('buyer_name');
			$table->string('email');
			$table->string('ship_address1');
			$table->string('ship_address2')->nullable()->default('NULL');
			$table->string('ship_city');
			$table->string('ship_state');
			$table->string('ship_zip');
			$table->string('ship_phone')->nullable()->default('NULL');
			$table->string('tracking')->nullable()->default('NULL');
			$table->string('purchase_source');
			$table->string('status')->default('\'pending\'');
			$table->dateTime('amazon_update')->nullable()->default('NULL');
			$table->timestamps();
			$table->index(['buyer_name','email'], 'buyer_name');
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
