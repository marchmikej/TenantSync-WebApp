<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateManagerPropertyTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('manager_property', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('manager_id');
			$table->integer('property_id');
			$table->integer('email_message')->default(0);
			$table->integer('app_message')->default(0);
			$table->integer('email_maintenance')->default(0);
			$table->integer('app_maintenance')->default(0);
			$table->integer('email_payment')->default(0);
			$table->integer('app_payment')->default(0);
			$table->integer('email_missed_payment')->default(0);
			$table->integer('app_missed_payment')->default(0);
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
		Schema::drop('manager_property');
	}

}
