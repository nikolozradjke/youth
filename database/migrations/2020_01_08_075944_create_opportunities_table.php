<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOpportunitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opportunities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->json('name');
            $table->json('date');
            $table->json('description');
            $table->json('address');
            $table->text('latitude');
            $table->text('longitude');
            $table->string('phone');
            $table->datetime('start_date');
            $table->datetime('end_date');
            $table->datetime('schedule_date');
            $table->bigInteger('opportunity_status_id');
            $table->bigInteger('company_id');
            $table->string('image')->nullable();
            $table->integer('order')->nullable();
            $table->string('fb_page')->nullable();
            $table->string('linkedin_page')->nullable();
            $table->string('web_page')->nullable();
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
        Schema::dropIfExists('opportunities');
    }
}
