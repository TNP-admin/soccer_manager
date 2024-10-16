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
        Schema::table('matches', function (Blueprint $table) {
            //
            $table->timestamp('period_start')->nullable();
            $table->unsignedInteger('extra_time');
            $table->unsignedInteger('pk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('matches', function (Blueprint $table) {
            //
            $table->dropColumn('period_start');
            $table->dropColumn('extra_time');
            $table->dropColumn('pk');
        });
    }
};
