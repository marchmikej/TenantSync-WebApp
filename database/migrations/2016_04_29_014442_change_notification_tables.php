<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeNotificationTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 30);
            $table->timestamps();
        });

        Schema::table('managers', function (Blueprint $table) {
            $table->dropColumn('email')->change();
            $table->dropColumn('email');

            $table->integer('email_notifications');
            $table->integer('text_notifications');
        });

        Schema::create('manager_notification', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id', 20);
            $table->string('notification_id', 20);
            $table->timestamps();
        });

        Schema::table('manager_property', function(Blueprint $table) {
            $table->dropColumn('email_message');
            $table->dropColumn('app_message');
            $table->dropColumn('email_maintenance');
            $table->dropColumn('app_maintenance');
            $table->dropColumn('email_payment');
            $table->dropColumn('app_payment');
            $table->dropColumn('email_missed_payment');
            $table->dropColumn('app_missed_payment');
        });

        Schema::rename('landlord_devices', 'user_devices');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('notifications');
        Schema::drop('manager_notification');
        Schema::table('manager', function(Blueprint $table) {
            $table->dropColumn('email_notifications');
            $table->dropColumn('text_notifications');
            $table->string('email');
        });
    }
}
