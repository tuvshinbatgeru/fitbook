<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupon', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->integer('couponable_id')->unsigned()->index();
            $table->integer('user_id')->unsigned()->index();
            $table->string('couponable_type');
            $table->string('coupon_pass');
            $table->timestamp('expired_date');
            $table->enum('is_active', ['Y','N'])->default('Y');
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
        Schema::drop('coupon');
    }
}
