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
            $table->integer('training_id')->unsigned()->index();
            $table->integer('genre_id')->unsigned()->index();
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
