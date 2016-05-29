<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOverdueUsage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('overdue_usages', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('device_id');
            $table->integer('overdue_type_id');
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
        Schema::drop('overdue_usages');
    }
}
