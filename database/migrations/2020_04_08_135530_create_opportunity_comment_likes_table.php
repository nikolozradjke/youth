<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOpportunityCommentLikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opportunity_comment_likes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('opportunity_comment_id');
            $table->bigInteger('user_id');
            $table->boolean('like'); // if true ? like else dislike
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
        Schema::dropIfExists('opportunity_comment_likes');
    }
}
