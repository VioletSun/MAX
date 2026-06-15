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
        Schema::create('max_updates', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable();
            $table->bigInteger('chat_id')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->json('data');
            $table->smallInteger('processing')->default(-1);
            $table->timestamps();

            $table->index('processing');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('max_updates');
    }
};
