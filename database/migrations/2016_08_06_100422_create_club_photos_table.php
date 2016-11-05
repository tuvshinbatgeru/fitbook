<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClubPhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('club_photos', function (Blueprint $table) {
            $table->integer('club_id')->unsigned()->index();
            $table->integer('photo_id')->unsigned()->index();
            $table->tinyInteger('type'); //1 - Logo, 2 - Cover, 3 - Slide
            $table->tinyInteger('top');
            $table->tinyInteger('left');
            $table->tinyInteger('view_order');    
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
        Schema::drop('club_photos');
    }
}
