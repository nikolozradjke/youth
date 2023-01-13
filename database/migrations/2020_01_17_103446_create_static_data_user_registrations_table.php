<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaticDataUserRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('static_data_user_registrations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->json('confidentiality_title');
            $table->json('confidentiality_text');
            $table->json('terms_title');
            $table->json('terms_text');
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
        Schema::dropIfExists('static_data_user_registrations');
    }
}
