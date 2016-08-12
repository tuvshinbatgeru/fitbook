<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClubWidgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('club_widgets', function (Blueprint $table) {
            $table->integer('club_id')->unsigned()->index();
            $table->integer('widget_id')->unsigned()->index();
            $table->tinyInteger('view_order');
            $table->date('expired_date');
            $table->enum('licensed', ['N', 'Y'])->default('Y');
            $table->enum('is_active', ['N', 'Y'])->default('N');
            $table->timestamps();

            $table->foreign('club_id')->references('id')->on('club')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('widget_id')->references('id')->on('widgets')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['club_id', 'widget_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('club_widgets');
    }
}
