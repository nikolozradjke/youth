<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEduNameToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('edu_name')->after('email')->nullable();
            $table->string('edu_grade')->after('email')->nullable();
            $table->string('edu_info')->after('email')->nullable();
            $table->string('study_status')->after('email')->nullable();
            $table->integer('sphere_id')->after('email')->nullable();
            $table->integer('sector_id')->after('email')->nullable();
            $table->string('other_sector')->after('email')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('edu_name');
            $table->dropColumn('edu_grade');
            $table->dropColumn('edu_info');
            $table->dropColumn('study_status');
            $table->dropColumn('sphere_id');
            $table->dropColumn('sector_id');
            $table->dropColumn('other_sector');
        });
    }
}
