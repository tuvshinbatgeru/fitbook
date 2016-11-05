<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanPhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_photos', function (Blueprint $table) {
            $table->integer('plan_id')->unsigned();
            $table->integer('photo_id')->unsigned();
            $table->tinyInteger('top');
            $table->tinyInteger('left');
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
        Schema::drop('plan_photos');
    }
}
