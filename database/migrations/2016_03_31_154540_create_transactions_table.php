<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTransactionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('transactions', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('user_id');
			$table->decimal('amount', 30)->default(0.00);
			$table->text('description', 65535)->nullable();
			$table->integer('reference_number')->nullable();
			$table->date('date')->nullable();
			$table->string('payable_type', 50)->nullable();
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
		Schema::drop('transactions');
	}

}
