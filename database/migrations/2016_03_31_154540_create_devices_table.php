<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDevicesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('devices', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('user_id')->nullable();
			$table->integer('property_id')->nullable();
			$table->string('routing_id')->nullable();
			$table->string('serial', 30)->nullable()->default('');
			$table->string('token', 80);
			$table->integer('monthly_cost')->default(0);
			$table->string('location', 40)->default('');
			$table->float('rent_amount', 30);
			$table->date('rent_due')->nullable();
			$table->float('late_fee', 30);
			$table->integer('grace_period');
			$table->string('contact_name', 20)->nullable();
			$table->string('contact_phone', 20)->nullable();
			$table->integer('vacant');
			$table->string('status', 15)->nullable();
			$table->integer('alarm_id');
			$table->dateTime('last_contact');
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
		Schema::drop('devices');
	}

}
