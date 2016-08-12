<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoyaltyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loyalty', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('club_id')->unsigned()->index();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->integer('type'); //1. Constant 2.Between 3.Member count required
            $table->integer('trainer_limit');
            $table->date('start_date');
            $table->date('finish_date');
            $table->enum('is_active',['N' , 'Y'])->default('Y');
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
        Schema::drop('loyalty');
    }
}
