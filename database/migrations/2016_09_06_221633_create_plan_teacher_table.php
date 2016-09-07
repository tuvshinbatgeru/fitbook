<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanTeacherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_teacher', function (Blueprint $table) {
            $table->integer('plan_id')->unsigned()->index();
            $table->integer('teacher_id')->unsigned()->index();
            $table->timestamps();
            
            $table->primary(['plan_id', 'teacher_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('plan_teacher');
    }
}
