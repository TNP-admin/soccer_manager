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
        Schema::create('clubs', function (Blueprint $table) {
            $table->increments('club_id');
	    $table->string('club_name', 60);
            $table->unsignedBigInteger('club_representative')->nullable();
	    $table->string('club_url', 400)->nullable();
            $table->unsignedInteger('city_association');
            $table->unsignedInteger('prefecture_federation');
            $table->unsignedInteger('club_status');
            $table->timestamp('clubs_created_at');
	    $table->timestamp('clubs_updated_at')->nullable();

	    $table->foreign('club_representative')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clubs');
    }
};
