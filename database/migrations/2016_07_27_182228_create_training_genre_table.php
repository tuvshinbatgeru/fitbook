<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrainingGenreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('training_genre', function (Blueprint $table) {
            $table->integer('training_id')->unsigned();
            $table->integer('genre_id')->unsigned();
            $table->timestamps();

            $table->primary(['training_id', 'genre_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('training_genre');
    }
}
