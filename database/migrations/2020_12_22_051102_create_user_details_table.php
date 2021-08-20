<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if (!Schema::hasTable('user_details')) {
        Schema::create('user_details', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->unsignedBigInteger('user_id'); 
          $table->string('address')->nullable();
          $table->string('mobile')->nullable();
          $table->string('fax_no')->nullable();
          $table->string('city')->nullable();
          $table->string('state')->nullable();
          $table->string('zipcode')->nullable();
          $table->date('dob')->nullable();
          $table->binary('profile_picture')->nullable();
          $table->string('imagetype')->nullable();
          $table->tinyInteger('status')->nullable();
          $table->timestamps();
          $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
      }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_details');
    }
}
