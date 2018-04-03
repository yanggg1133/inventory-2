<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateShipmentPackagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shipment_packages', function(Blueprint $table)
		{
			$table->integer('ship_id');
			$table->string('tracking_num', 50);
			$table->string('label_fmt', 25);
			$table->text('label_img', 65535);
			$table->integer('scanned')->default(0);
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
		Schema::drop('shipment_packages');
	}

}
