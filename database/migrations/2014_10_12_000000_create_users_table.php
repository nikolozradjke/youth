<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->bigIncrements('id');
            $table->json('first_name');
            $table->json('last_name');
            $table->date('birth_date')->nullable();
            $table->string('private_number')->nullable();
            $table->string('gender')->nullable();
            $table->string('image')->default('images/default-avatar.png');
            $table->string('email')->unique();
            //$table->timestamp('email_verified_at')->nullable();
            $table->string('phone')->unique()->nullable();
            $table->string('password');
            $table->boolean('is_complete');
            $table->string('provider_id')->nullable();
            $table->string('provider')->nullable();
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
