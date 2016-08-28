<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrainingPhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('training_photos', function (Blueprint $table) {
            $table->integer('training_id')->unsigned()->index();
            $table->integer('photo_id')->unsigned()->index();
            $table->enum('pinned', ['N','Y'])->default('N');
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
        Schema::drop('training_photos');
    }
}
