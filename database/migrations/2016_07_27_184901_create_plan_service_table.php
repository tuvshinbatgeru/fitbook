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
            $table->integer('plan_id')->unsigned()->index();
            $table->integer('club_service_id')->unsigned()->index();
            $table->timestamps();

            $table->primary(['plan_id', 'club_service_id']);
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
