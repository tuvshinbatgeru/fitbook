<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMentionablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mentionables', function (Blueprint $table) {
            $table->integer('mention_id')->unsigned()->index();
            $table->string('mention_type');
            $table->integer('mentionable_id')->unsigned()->index();
            $table->string('mentionable_type');
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
        Schema::drop('mentionables');
    }
}
