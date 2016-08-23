<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_service', function (Blueprint $table) {
            $table->integer('plan_id')->unsigned();
            $table->integer('service_id')->unsigned();
            $table->timestamps();

            $table->primary(['plan_id', 'service_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('plan_service');
    }
}
