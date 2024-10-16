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
        Schema::create('players', function (Blueprint $table) {
            $table->increments('player_id');
            $table->unsignedInteger('match_id');
            $table->unsignedBigInteger('id');
            $table->unsignedInteger('club_id');
            $table->integer('match_position')->nullable();
            $table->time('on')->nullable();
            $table->time('off')->nullable();
	    $table->string('player_remarks', 400)->nullable();
            $table->timestamp('players_created_at');
	    $table->timestamp('players_updated_at')->nullable();

	    $table->foreign('match_id')->references('match_id')->on('matches');
	    $table->foreign('id')->references('id')->on('users');
	    $table->foreign('club_id')->references('club_id')->on('clubs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
