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
        Schema::create('max_chats', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('chat_id')->nullable();
            $table->string('type')->nullable();
            $table->string('status')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->json('icon')->nullable();
            $table->integer('participants_count')->default(0);
            $table->boolean('is_public')->default(false);
            $table->bigInteger('owner_id')->nullable();
            $table->string('link')->nullable();
            $table->bigInteger('messages_count')->default(0);
            $table->timestamp('last_event_time')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('max_chat_users', function (Blueprint $table) {
            $table->bigInteger('chat_id');
            $table->bigInteger('user_id');
            $table->timestamps();
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
