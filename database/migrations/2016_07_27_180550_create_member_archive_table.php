<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberArchiveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_archive', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('club_id')->unsigned()->index();
            $table->integer('user_id')->unsigned()->index();
            $table->tinyInteger('type');
            $table->date('since_date');
            $table->date('left_date');
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
        Schema::drop('member_archive');
    }
}
