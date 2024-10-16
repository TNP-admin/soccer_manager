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
        Schema::create('fouls', function (Blueprint $table) {
            $table->increments('foul_id');
            $table->unsignedInteger('match_id');
            $table->unsignedBigInteger('id');
            $table->unsignedInteger('club_id');
            $table->unsignedInteger('foul_cards');
            $table->time('foul_time');
            $table->timestamp('fouls_created_at');
	    $table->timestamp('fouls_updated_at')->nullable();

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
        Schema::dropIfExists('fouls');
    }
};
