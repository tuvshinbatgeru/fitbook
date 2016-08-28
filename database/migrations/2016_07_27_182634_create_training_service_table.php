<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrainingServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('training_service', function (Blueprint $table) {
            $table->integer('training_id')->unsigned()->index();
            $table->integer('service_id')->unsigned()->index();
            $table->timestamps();

            $table->primary(['training_id', 'service_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('training_service');
    }
}
