<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserApiProfilesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_api_profiles', function(Blueprint $table)
		{
			$table->integer('seller_id');
			$table->string('provider');
			$table->text('api_cred1', 65535);
			$table->text('api_cred2', 65535)->nullable()->default('NULL');
			$table->text('api_cred3', 65535)->nullable()->default('NULL');
			$table->text('api_cred4', 65535)->nullable()->default('NULL');
			$table->text('api_cred5', 65535)->nullable()->default('NULL');
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
		Schema::drop('user_api_profiles');
	}

}
