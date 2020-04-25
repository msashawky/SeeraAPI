<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInfoWebsiteContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('info_website_contents', function (Blueprint $table) {
            $table->increments('id');
            $table->string('info_website_name_ar');
            $table->string('info_website_name_en');
            $table->string('info_website_url');
            $table->string('logo');
            $table->string('favicon');
            $table->text('about_us_ar');
            $table->text('about_us_en');
            $table->text('terms_and_conditions_ar');
            $table->text('terms_and_conditions_en');
            $table->text('privacy_policy_ar');
            $table->text('privacy_policy_en');
            $table->string('address_ar');
            $table->string('address_en');
            $table->string('phone_number');
            $table->string('email');
            $table->string('facebook');
            $table->string('twitter')->nullable();
            $table->string('instagram')->nullable();
            $table->string('youtube')->nullable();
            $table->string('linkedin')->nullable();
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
        Schema::dropIfExists('info_website_contents');
    }
}
