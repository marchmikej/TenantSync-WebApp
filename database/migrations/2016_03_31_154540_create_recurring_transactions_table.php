<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRecurringTransactionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('recurring_transactions', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->nullable();
			$table->integer('amount')->nullable();
			$table->string('description')->nullable()->default('');
			$table->integer('day')->nullable();
			$table->string('schedule', 20)->default('');
			$table->date('last_ran');
			$table->string('payable_type', 20)->nullable();
			$table->integer('payable_id')->nullable();
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
		Schema::drop('recurring_transactions');
	}

}
