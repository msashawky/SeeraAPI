<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganizationWebsitePortfoliosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization_website_portfolios', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('organization_website_id')->unsigned();
            $table->foreign('organization_website_id')->references('id')->on('organization_websites');
            $table->string('name_ar');
            $table->string('name_en');
            $table->string('image');
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
        Schema::dropIfExists('organization_website_portfolios');
    }
}
