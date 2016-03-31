<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePropertiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('properties', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('user_id')->nullable();
			$table->string('address');
			$table->string('city');
			$table->string('state');
			$table->integer('zip');
			$table->decimal('purchase_price', 30)->nullable();
			$table->date('purchase_date')->nullable();
			$table->decimal('closing_costs', 30)->nullable();
			$table->decimal('insurance', 30)->nullable();
			$table->decimal('expenses', 30)->nullable();
			$table->decimal('taxes', 30)->nullable();
			$table->integer('down_payment')->nullable();
			$table->decimal('mortgage_rate', 30, 3)->nullable();
			$table->integer('mortgage_term')->nullable();
			$table->decimal('value', 30)->nullable();
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
		Schema::drop('properties');
	}

}
