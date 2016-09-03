<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserActivityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_activity', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->index();
            $table->integer('club_id')->unsigned()->index();
            $table->integer('subscription_id')->unsigned()->index();
            $table->timestamp('start_time');
            $table->timestamp('finish_time');
            $table->integer('duration'); //as a minute
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
        Schema::drop('user_activity');
    }
}
