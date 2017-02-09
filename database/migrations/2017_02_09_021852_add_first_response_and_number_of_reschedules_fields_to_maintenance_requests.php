<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFirstResponseAndNumberOfReschedulesFieldsToMaintenanceRequests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('maintenance_requests', function(Blueprint $table) {
            $table->timestamp('first_response_at')->nullable();
            $table->integer('times_scheduled')->default(0);
            $table->timestamp('closed_at')->nullable();
            $table->timestamp('scheduled_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('maintenance_requests', function(Blueprint $table) {
            $table->dropColumn('first_response_at');
            $table->dropColumn('times_scheduled');
            $table->dropColumn('closed_at');
            $table->dropColumn('scheduled_at');
        });
    }
}
