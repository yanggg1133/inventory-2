<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateShipmentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shipments', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('so_id');
			$table->string('main_tracking', 50);
			$table->string('package_tracking', 50)->nullable()->default('NULL');
			$table->decimal('charges', 10);
			$table->decimal('negotiated_charges', 10);
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
		Schema::drop('shipments');
	}

}
