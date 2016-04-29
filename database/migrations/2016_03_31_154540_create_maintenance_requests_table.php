<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMaintenanceRequestsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('maintenance_requests', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id');
			$table->integer('device_id')->nullable();
			$table->integer('transaction_id')->nullable();
			$table->text('request', 65535)->nullable();
			$table->text('response', 65535)->nullable();
			$table->decimal('cost', 30)->nullable();
			$table->dateTime('appointment_date')->nullable();
			$table->string('status', 20)->nullable();
			$table->timestamps();
			$table->string('update_key', 30)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('maintenance_requests');
	}

}
