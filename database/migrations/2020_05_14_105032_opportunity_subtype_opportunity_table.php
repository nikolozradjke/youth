<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OpportunitySubtypeOpportunityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opportunity_opportunity_subtype', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('opportunity_id');
            $table->bigInteger('opportunity_subtype_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('opportunity_opportunity_subtype');
    }
}
