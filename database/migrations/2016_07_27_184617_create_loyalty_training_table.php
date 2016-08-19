<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoyaltyTrainingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loyalty_training', function (Blueprint $table) {
            $table->integer('loyalty_id')->unsigned();
            $table->integer('training_id')->unsigned();
            $table->timestamps();

            $table->primary(['training_id', 'loyalty_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('loyalty_training');
    }
}
