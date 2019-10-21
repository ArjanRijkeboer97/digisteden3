<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CityTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('citygroups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->char('color', 7);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('cities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('group_id', false, true)->unsigned();
            $table->string('name');
            $table->string('domain');
            $table->char('color', 7);
            $table->timestamps();
            $table->softDeletes();

            // $table->foreign('group_id')->references('id')->on('citygroups')->delete('cascade');
        });

        Schema::create('citygroup_domains', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('group_id', false, true)->unsigned();
            $table->string('domain')->unique();
            $table->timestamps();
            $table->softDeletes();

            // $table->foreign('group_id')->references('id')->on('citygroups')->delete('cascade');
        });

        Schema::create('city_domains', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('city_id', false, true)->unsigned();
            $table->string('domain')->unique();
            $table->timestamps();
            $table->softDeletes();

            // $table->foreign('city_id')->references('id')->on('cities')->delete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('city_domains');
        Schema::dropIfExists('citygroup_domains');
        Schema::dropIfExists('cities');
        Schema::dropIfExists('citygroups');
    }
}
