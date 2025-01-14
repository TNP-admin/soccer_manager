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
        Schema::table('fouls', function (Blueprint $table) {
            //
            $table->unsignedInteger('foul_period');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fouls', function (Blueprint $table) {
            //
            $table->dropColumn('foul_period');
        });
    }
};
