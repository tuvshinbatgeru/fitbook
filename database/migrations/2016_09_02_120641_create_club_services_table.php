<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClubServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('club_services', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('club_id')->unsigned()->index();
            $table->integer('service_id')->unsigned()->index();
            $table->integer('photo_id')->unsigned()->index()->default(0);
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
        Schema::drop('club_services');
    }
}
