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
        Schema::create('max_users', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('chat_id')->nullable();
            $table->bigInteger('user_id');
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('username')->nullable();
            $table->text('description')->nullable();
            $table->string('avatar_url')->nullable();
            $table->string('full_avatar_url')->nullable();
            $table->boolean('private')->default(false);
            $table->timestamp('last_active')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('max_users');
    }
};
