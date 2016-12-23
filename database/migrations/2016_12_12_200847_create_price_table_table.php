<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePriceTableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price_table', function (Blueprint $table) {
            $table->integer('plan_id')->unsigned()->index();
            $table->integer('frequency_type'); //1. Dayly 2.Weakly 3.Monthly 4.Yearly
            $table->integer('frequency_length');
            $table->decimal('price', 18);
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
        Schema::dropIfExists('price_table');
    }
}
