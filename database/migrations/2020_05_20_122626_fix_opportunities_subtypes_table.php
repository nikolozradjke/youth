<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixOpportunitiesSubtypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('opportunity_subtypes', function(Blueprint $table) {
            $table->renameColumn('opportunit_type_id', 'opportunity_type_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('opportunity_subtypes', function(Blueprint $table) {
            $table->renameColumn('opportunity_type_id', 'opportunit_type_id');
        });
    }
}
