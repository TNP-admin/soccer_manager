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
        Schema::create('matches', function (Blueprint $table) {
            $table->increments('match_id');
	    $table->string('match_name', 60)->nullable();
            $table->unsignedInteger('match_status');
            $table->date('match_date');
            $table->time('schedule_start');
            $table->time('regulation_time');
            $table->timestamp('match_start')->nullable();
            $table->unsignedInteger('half');
            $table->unsignedInteger('home');
            $table->unsignedInteger('home_2')->nullable();
            $table->unsignedInteger('home_3')->nullable();
            $table->unsignedInteger('home_4')->nullable();
            $table->unsignedInteger('home_5')->nullable();
            $table->unsignedInteger('away');
            $table->unsignedInteger('away_2')->nullable();
            $table->unsignedInteger('away_3')->nullable();
            $table->unsignedInteger('away_4')->nullable();
            $table->unsignedInteger('away_5')->nullable();
            $table->unsignedInteger('pitch_id');
            $table->unsignedInteger('a_side');
            $table->unsignedInteger('home_formation');
            $table->unsignedInteger('away_formation');
            $table->integer('weather')->nullable();
            $table->integer('temperature')->nullable();
            $table->integer('humidity')->nullable();
	    $table->string('wind', 60)->nullable();
            $table->integer('grass')->nullable();
	    $table->string('condition', 60)->nullable();
            $table->integer('cancel');
	    $table->string('movie_url', 400)->nullable();
	    $table->string('match_remarks', 255)->nullable();
            $table->unsignedInteger('confirm');
            $table->unsignedInteger('home_confirm');
            $table->unsignedInteger('away_confirm');
            $table->timestamp('matches_created_at')->useCurrent();
	    $table->timestamp('matches_updated_at')->nullable();

	    $table->foreign('home')->references('club_id')->on('clubs');
	    $table->foreign('home_2')->references('club_id')->on('clubs');
	    $table->foreign('home_3')->references('club_id')->on('clubs');
	    $table->foreign('home_4')->references('club_id')->on('clubs');
	    $table->foreign('home_5')->references('club_id')->on('clubs');
	    $table->foreign('away')->references('club_id')->on('clubs');
	    $table->foreign('away_2')->references('club_id')->on('clubs');
	    $table->foreign('away_3')->references('club_id')->on('clubs');
	    $table->foreign('away_4')->references('club_id')->on('clubs');
	    $table->foreign('away_5')->references('club_id')->on('clubs');
	    $table->foreign('pitch_id')->references('pitch_id')->on('pitches');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matches');
    }
};
