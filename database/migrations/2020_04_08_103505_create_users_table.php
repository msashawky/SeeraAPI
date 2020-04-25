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
            $table->string('name_ar')->nullable();
            $table->string('name_en')->nullable();
            $table->string('email',128)->unique();
            $table->string('password');
            $table->string('username',128)->unique()->nullable();
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['male', 'female']);
            $table->enum('martial_status', ['single', 'married'])->default('single');
            $table->integer('country_id')->unsigned()->nullable();
            $table->foreign('country_id')->references('id')->on('countries');
            $table->string('city')->nullable();
            $table->string('job_title_ar')->nullable();
            $table->string('job_title_en')->nullable();
            $table->string('biography_ar')->nullable();
            $table->string('biography_en')->nullable();
            $table->string('photo')->nullable();
            $table->date('career_started_at')->nullable();
            $table->boolean('is_activated')->default(0);
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
