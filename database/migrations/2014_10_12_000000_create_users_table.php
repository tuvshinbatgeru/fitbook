<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username', 200)->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->nullable();
            $table->string('socialite_id', 30)->nullable();
            $table->integer('socialite_type');
            $table->string('avatar_url', 1000)->nullable();
            $table->date('birthday')->nullable();
            $table->string('password')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->enum('is_active', ['N', 'Y']);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
