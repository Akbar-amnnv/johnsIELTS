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
        Schema::create('speaking_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('speaking_session_id')->constrained()->cascadeOnDelete();
            $table->foreignId('speaking_question_id')->constrained()->cascadeOnDelete();
            $table->longText('answer_text')->nullable();
            $table->longText('transcript')->nullable();
            $table->string('audio_path')->nullable();
            $table->integer('duration_seconds')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('speaking_answers');
    }
};
