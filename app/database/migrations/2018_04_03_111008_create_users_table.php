<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('email')->unique();
			$table->string('password');
			$table->text('permissions', 65535)->nullable()->default('NULL');
			$table->boolean('activated')->default(0);
			$table->string('activation_code')->nullable()->default('NULL')->index();
			$table->dateTime('activated_at')->nullable()->default('NULL');
			$table->dateTime('last_login')->nullable()->default('NULL');
			$table->string('persist_code')->nullable()->default('NULL');
			$table->string('reset_password_code')->nullable()->default('NULL')->index();
			$table->string('first_name')->nullable()->default('NULL');
			$table->string('last_name')->nullable()->default('NULL');
			$table->integer('company')->nullable()->default('NULL');
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
		Schema::drop('users');
	}

}
