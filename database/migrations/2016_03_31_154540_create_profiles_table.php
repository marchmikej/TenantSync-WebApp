<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProfilesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('profiles', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('user_id');
			$table->string('first_name', 15);
			$table->string('last_name', 15);
			$table->string('phone', 15);
			$table->string('company', 30);
			$table->string('address', 40)->nullable();
			$table->string('city', 40)->nullable();
			$table->string('state', 5)->nullable();
			$table->string('zip', 20)->nullable();
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
		Schema::drop('profiles');
	}

}
