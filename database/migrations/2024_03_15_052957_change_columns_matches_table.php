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
            $table->integer('period_setting')->nullable();
            $table->integer('extra_time')->nullable();
            $table->integer('home_easyinput')->nullable();
            $table->integer('away_easyinput')->nullable();
            $table->integer('member_max')->nullable();
            $table->unsignedinteger('pk_home1_id')->nullable();
            $table->integer('pk_home1')->nullable();
            $table->unsignedinteger('pk_home2_id')->nullable();
            $table->integer('pk_home2')->nullable();
            $table->unsignedinteger('pk_home3_id')->nullable();
            $table->integer('pk_home3')->nullable();
            $table->unsignedinteger('pk_home4_id')->nullable();
            $table->integer('pk_home4')->nullable();
            $table->unsignedinteger('pk_home5_id')->nullable();
            $table->integer('pk_home5')->nullable();
            $table->unsignedinteger('pk_home6_id')->nullable();
            $table->integer('pk_home6')->nullable();
            $table->unsignedinteger('pk_home7_id')->nullable();
            $table->integer('pk_home7')->nullable();
            $table->unsignedinteger('pk_home8_id')->nullable();
            $table->integer('pk_home8')->nullable();
            $table->unsignedinteger('pk_away1_id')->nullable();
            $table->integer('pk_away1')->nullable();
            $table->unsignedinteger('pk_away2_id')->nullable();
            $table->integer('pk_away2')->nullable();
            $table->unsignedinteger('pk_away3_id')->nullable();
            $table->integer('pk_away3')->nullable();
            $table->unsignedinteger('pk_away4_id')->nullable();
            $table->integer('pk_away4')->nullable();
            $table->unsignedinteger('pk_away5_id')->nullable();
            $table->integer('pk_away5')->nullable();
            $table->unsignedinteger('pk_away6_id')->nullable();
            $table->integer('pk_away6')->nullable();
            $table->unsignedinteger('pk_away7_id')->nullable();
            $table->integer('pk_away7')->nullable();
            $table->unsignedinteger('pk_away8_id')->nullable();
            $table->integer('pk_away8')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('matches', function (Blueprint $table) {
            //
            $table->dropColumn('period_setting');
            $table->dropColumn('extra_time');
            $table->dropColumn('home_easyinput');
            $table->dropColumn('away_easyinput');
            $table->dropColumn('member_max');
            $table->dropColumn('pk_home1_id');
            $table->dropColumn('pk_home1');
            $table->dropColumn('pk_home2_id');
            $table->dropColumn('pk_home2');
            $table->dropColumn('pk_home3_id');
            $table->dropColumn('pk_home3');
            $table->dropColumn('pk_home4_id');
            $table->dropColumn('pk_home4');
            $table->dropColumn('pk_home5_id');
            $table->dropColumn('pk_home5');
            $table->dropColumn('pk_home6_id');
            $table->dropColumn('pk_home6');
            $table->dropColumn('pk_home7_id');
            $table->dropColumn('pk_home7');
            $table->dropColumn('pk_home8_id');
            $table->dropColumn('pk_home8');
            $table->dropColumn('pk_away1_id');
            $table->dropColumn('pk_away1');
            $table->dropColumn('pk_away2_id');
            $table->dropColumn('pk_away2');
            $table->dropColumn('pk_away3_id');
            $table->dropColumn('pk_away3');
            $table->dropColumn('pk_away4_id');
            $table->dropColumn('pk_away4');
            $table->dropColumn('pk_away5_id');
            $table->dropColumn('pk_away5');
            $table->dropColumn('pk_away6_id');
            $table->dropColumn('pk_away6');
            $table->dropColumn('pk_away7_id');
            $table->dropColumn('pk_away7');
            $table->dropColumn('pk_away8_id');
            $table->dropColumn('pk_away8');
        });
    }
};
