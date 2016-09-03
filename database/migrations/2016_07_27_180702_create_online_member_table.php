<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOnlineMemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('online_members', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->index();
            $table->integer('club_id')->unsigned()->index();
            $table->integer('subscription_id')->unsigned()->index();
            $table->timestamp('start_time');
            $table->timestamps();

            $table->primary(['club_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('online_members');
    }
}
