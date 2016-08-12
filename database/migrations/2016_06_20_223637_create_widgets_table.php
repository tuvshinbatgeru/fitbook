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
            $table->string('tag')->unique();
            $table->string('tag_en')->unique();
            $table->string('name')->unique();
            $table->string('name_en')->unique();
            $table->integer('price');
            $table->integer('price_en');
            $table->string('description')->nullable();
            $table->string('description_en')->nullable();
            $table->string('img_url');
            $table->integer('usage_id');
            $table->integer('total_used')->default(0);
            $table->decimal('star_count', 1, 1);
            $table->enum('commercial_status', ['N', 'Y'])->default('N');
            $table->enum('verified', ['N', 'Y'])->default('N');
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
