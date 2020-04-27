<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganizationWebsitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization_websites', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('website_name_ar')->nullable();
            $table->string('website_name_en')->nullable();
            $table->string('domain');
            $table->enum('domain_type', ['normal', 'premium']);
            $table->text('about_us_ar');
            $table->text('about_us_en');
            $table->string('address_ar');
            $table->string('address_en');
            $table->string('email');
            $table->string('background_image')->nullable();
            $table->integer('number_of_visits')->default(0);
            $table->enum('status', ['enabled', 'disabled'])->default('enabled');

            //social links
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('youtube')->nullable();
            $table->string('google_plus')->nullable();
            $table->string('behance')->nullable();
            $table->string('instagram')->nullable();
            $table->string('pinterest')->nullable();
            $table->string('vimeo')->nullable();
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
        Schema::dropIfExists('organization_websites');
    }
}
