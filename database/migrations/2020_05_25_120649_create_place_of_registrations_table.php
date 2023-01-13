<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlaceOfRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('place_of_registrations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('is_georgia')->default(1);
            $table->text('address_text');
            $table->bigInteger('company_id');
            $table->bigInteger('region_id')->nullable();
            $table->bigInteger('municipality_id')->nullable();
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
        Schema::dropIfExists('place_of_residences');
    }
}
