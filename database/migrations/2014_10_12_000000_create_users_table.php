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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
	    $table->string('password');
	    $table->string('nickname', 60)->nullable();
            $table->integer('sex');
            $table->date('birth');
            $table->unsignedInteger('club_id');
            $table->integer('category');
            $table->integer('entrance_year');
            $table->integer('number')->nullable();
            $table->integer('position');
            $table->string('remarks', 255)->nullable();
            $table->integer('user_auth');
            $table->integer('user_status');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamp('users_created_at')->useCurrent();
	    $table->timestamp('users_updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
