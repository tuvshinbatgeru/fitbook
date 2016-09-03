<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('club_id')->unsigned()->index();
            $table->integer('frequency_type'); //1. Dayly 2.Weakly 3.Monthly 4.Yearly
            $table->integer('planable_id')->unsigned()->index();
            $table->string('planable_type'); //App/ConstantPlan, App/LoyaltyPlan
            $table->enum('trainerless', ['N', 'Y'])->default('N');
            $table->string('name');
            $table->string('description')->nullable();
            $table->decimal('price', 10);
            $table->integer('trainer_count');
            $table->integer('length');
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
        Schema::drop('plan');
    }
}
