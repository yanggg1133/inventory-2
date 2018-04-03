<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateThrottleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('throttle', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned()->nullable()->default('NULL')->index();
			$table->string('ip_address')->nullable()->default('NULL');
			$table->integer('attempts')->default(0);
			$table->boolean('suspended')->default(0);
			$table->boolean('banned')->default(0);
			$table->dateTime('last_attempt_at')->nullable()->default('NULL');
			$table->dateTime('suspended_at')->nullable()->default('NULL');
			$table->dateTime('banned_at')->nullable()->default('NULL');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('throttle');
	}

}
