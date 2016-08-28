<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanTrainingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_training', function (Blueprint $table) {
            $table->integer('plan_id')->unsigned()->index();
            $table->integer('training_id')->unsigned()->index();
            $table->timestamps();

            $table->primary(['training_id', 'plan_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('plan_training');
    }
}
