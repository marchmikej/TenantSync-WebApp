<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCellCarrierManager extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('managers', function (Blueprint $table) {
            $table->integer('cell_carrier')->nullable();
        });

        Schema::table('users', function(Blueprint $table) {
            $table->dropColumn('cell_carrier');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('managers', function(Blueprint $table) {
            $table->dropColumn('cell_carrier');
        });
    }
}
