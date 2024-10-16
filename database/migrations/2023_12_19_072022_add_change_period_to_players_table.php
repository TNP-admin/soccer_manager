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
        Schema::table('players', function (Blueprint $table) {
            //
            $table->unsignedInteger('on_period')->nullable();
            $table->unsignedInteger('off_period')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('players', function (Blueprint $table) {
            //
            $table->dropColumn('on_period');
            $table->dropColumn('off_period');
        });
    }
};
