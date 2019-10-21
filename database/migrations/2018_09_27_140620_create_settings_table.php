<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('city_id');
            $table->string('favicon');
            $table->string('logo');
            $table->string('logoBig');
            $table->string('banner');
            $table->string('slogan', 50);
            $table->string('email');
            $table->string('recaptcha_key');
            $table->string('recaptcha_secret');
            $table->string('leaflet_key');
            $table->text('vacature_show_cities');
            $table->text('footer_1');
            $table->text('footer_2');
            $table->text('footer_3');
            $table->text('footer_4');
            $table->text('contact_1');
            $table->text('news_text');
        });

        Schema::create('citygroup_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('citygroup_id');
            $table->string('favicon');
            $table->string('logo');
            $table->string('logoBig');
            $table->string('banner');
            $table->string('slogan', 50);
            $table->string('email');
            $table->string('recaptcha_key');
            $table->string('recaptcha_secret');
            $table->string('leaflet_key');
            $table->text('footer_1');
            $table->text('footer_2');
            $table->text('footer_3');
            $table->text('footer_4');
            $table->text('contact_1');
            $table->text('news_text');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
        Schema::dropIfExists('citygroup_settings');
    }
}
