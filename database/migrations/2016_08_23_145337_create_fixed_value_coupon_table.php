<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFixedValueCouponTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fixed_value_coupon', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('type'); //1 - Tugrug, 2 - Dollar
            $table->decimal('amount', 10);
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
        Schema::drop('fixed_value_coupon');
    }
}
