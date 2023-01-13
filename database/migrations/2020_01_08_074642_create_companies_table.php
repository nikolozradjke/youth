<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->json('name');
            $table->string('email')->unique();
            //$table->timestamp('email_verified_at')->nullable();
            $table->string('phone')->unique();
            $table->string('phone2')->unique()->nullable();
            $table->string('registration_id')->unique();
            $table->bigInteger('number_of_employees_id');
            $table->json('address');
            $table->string('password');
            $table->json('description1');
            $table->json('description2');
            $table->string('fb_page');
            $table->string('linkedin_page');
            $table->string('web_page');
            $table->string('document')->nullable();
            $table->string('image')->default('images/default-avatar.png');
            $table->boolean('approved')->default(0);
            $table->boolean('is_complete')->default(0);
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
        Schema::dropIfExists('companies');
    }
}
