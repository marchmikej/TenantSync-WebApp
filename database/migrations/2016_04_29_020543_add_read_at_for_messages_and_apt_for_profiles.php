<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReadAtForMessagesAndAptForProfiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('messages', function(Blueprint $table) {
            $table->timestamp('read_at');
            $table->dropColumn('read');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('messages', function(Blueprint $table) {
            $table->dropColumn('read_at');
            $table->integer('read');
        });

        Schema::table('profiles', function(Blueprint $table) {
            $table->dropColumn('apt');
        });
    }
}
