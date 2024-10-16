<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('scores', function (Blueprint $table) {
            $table->increments('score_id');
            $table->unsignedInteger('match_id');
            $table->unsignedBigInteger('id');
            $table->unsignedBigInteger('assist_id')->nullable();
            $table->unsignedInteger('club_id');
            $table->time('score_time');
            $table->integer('owngoal');
            $table->timestamp('scores_created_at');
	    $table->timestamp('scores_updated_at')->nullable();

	    $table->foreign('match_id')->references('match_id')->on('matches');
	    $table->foreign('id')->references('id')->on('users');
	    $table->foreign('assist_id')->references('id')->on('users');
	    $table->foreign('club_id')->references('club_id')->on('clubs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scores');
    }
};
