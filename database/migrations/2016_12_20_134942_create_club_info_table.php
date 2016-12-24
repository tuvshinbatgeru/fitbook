<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClubInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('club_info', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('club_id')->unsigned()->integer();
            $table->enum('is_fulltime', ['N', 'Y']);
            $table->timeTz('open_time');
            $table->timeTz('close_time');
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
        Schema::dropIfExists('club_info');
    }
}
