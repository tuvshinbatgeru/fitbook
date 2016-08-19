<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWidgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('widgets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('section_id')->unsigned(); //1. header 2.body 3.footer
            $table->string('content_map')->unique();
            $table->string('name');
            $table->string('name_en');
            $table->integer('price');
            $table->string('description')->nullable();
            $table->string('description_en')->nullable();
            $table->integer('photo_id')->unsigned();
            $table->integer('usage_id');
            $table->integer('total_used')->default(0);
            $table->enum('commercial_status', ['N', 'Y'])->default('Y');
            $table->enum('verified', ['N', 'Y'])->default('Y');
            $table->enum('is_default', ['N', 'Y'])->default('N');
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
        Schema::drop('widgets');
    }
}
