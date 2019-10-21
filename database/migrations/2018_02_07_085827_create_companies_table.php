<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_type', function (Blueprint $table) {
            $table->increments('id');
            $table->softDeletes();

            $table->string('name');
        });

        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
            $table->softDeletes();

            $table->string('name');
            $table->string('address');
            $table->string('zip_code');
            $table->string('city')->nullable();
            $table->string('telephone');
            $table->string('email');
            $table->string('video')->nullable();
            $table->text('website')->nullable();
            $table->text('description')->nullable();
            $table->decimal('lat', 10, 8)->nullable();
            $table->decimal('lng', 11, 8)->nullable();
            $table->string('slug');
            $table->integer('type_id')->default(1)->unsigned();
            $table->integer('subCategory_id')->default(1)->unsigned();
            $table->integer('city_id')->unsigned();
            $table->integer('clicks')->default(0);
            $table->boolean('is_published');
            $table->boolean('is_highlighted');
            $table->string('logo')->nullable();
            $table->timestamps();

            // $table->foreign('type_id')->references('company_type')->on('id');
            // $table->foreign('city_id')->references('cities')->on('id');

        });

        Schema::create('company_shadow', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->nullable();
            $table->integer('is_new');

            $table->string('name');
            $table->string('address');
            $table->string('zip_code');
            $table->string('city');
            $table->string('telephone');
            $table->string('email')->nullable();
            $table->string('video')->nullable();
            $table->text('website')->nullable();
            $table->text('description')->nullable();
            $table->decimal('lat', 10, 8);
            $table->decimal('lng', 11, 8);
            $table->string('slug');
            $table->integer('type_id')->default(1)->unsigned();
            $table->integer('subCategory_id')->default(1)->unsigned();
            $table->integer('city_id')->unsigned();
            $table->boolean('is_published')->nullable();
            $table->boolean('is_highlighted')->nullable();
            $table->string('logo')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('mutation_mail_templates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('type_id');
            $table->text('subject');
            $table->text('message_top');
            $table->text('message_bottom');
            $table->timestamps();
            $table->softDeletes();
        });


        Schema::create('company_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('company_subcategories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('category_id');
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('company_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('title');
            $table->text('body');
            $table->string('rating')->nullable();
            $table->integer('company_id')->nullable();
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
        Schema::dropIfExists('companies');
        Schema::dropIfExists('company_shadow');
        Schema::dropIfExists('company_type');
        Schema::dropIfExists('company_comments');
        Schema::dropIfExists('company_categories');
        Schema::dropIfExists('company_subcategories');
        Schema::dropIfExists('company_address');
        Schema::dropIfExists('mutation_mail_templates');
    }
}
