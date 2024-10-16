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
        Schema::create('pitches', function (Blueprint $table) {
            $table->increments('pitch_id');
	    $table->string('pitch_name', 60);
	    $table->string('pitch_url', 400);
            $table->unsignedInteger('pitch_status');
            $table->timestamp('pitches_created_at');
	    $table->timestamp('pitches_updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pitches');
    }
};
