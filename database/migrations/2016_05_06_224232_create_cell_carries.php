<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCellCarries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cell_carriers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 20);
            $table->string('email_suffix', 40);
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->integer('cell_carrier')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('cell_carriers');
        Schema::table('users', function(Blueprint $table) {
            $table->dropColumn('cell_carrier');
        });
    }
}
