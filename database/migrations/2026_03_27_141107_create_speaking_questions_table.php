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
        Schema::create('speaking_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('speaking_topic_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('part_number'); // 1, 2, 3
            $table->text('question_text');
            $table->json('cue_card_data')->nullable(); // mainly for Part 2
            $table->string('difficulty')->nullable(); // easy, medium, hard
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('speaking_questions');
    }
};
