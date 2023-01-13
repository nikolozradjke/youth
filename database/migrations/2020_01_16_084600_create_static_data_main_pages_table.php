<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaticDataMainPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('static_data_main_pages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->json('user_section_title')->nullable();
            $table->json('user_section_subtitle')->nullable();
            $table->json('user_section_text')->nullable();
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
        Schema::dropIfExists('static_data_main_pages');
    }
}
