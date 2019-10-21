<?php

use Illuminate\Support\Facades\Schema;
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
            $table->string('name');
            $table->string('username')->nullable()->unique();
            $table->string('email')->nullable();
            $table->text('bio')->nullable();
            $table->string('img_src')->nullable();
            $table->string('password');
            $table->boolean('needs_check')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('city_user', function (Blueprint $table) {
            $table->increments('id');
            $table->softDeletes();
            $table->integer('city_id', false, true)->unsigned();
            $table->integer('user_id', false, true)->unsigned();

            $table->unique(['city_id', 'user_id']);

            // $table->foreign('city_id')->references('id')->on('cities')->delete('cascade');
            // $table->foreign('user_id')->references('id')->on('users')->delete('cascade');
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
        Schema::dropIfExists('city_user');
    }
}
