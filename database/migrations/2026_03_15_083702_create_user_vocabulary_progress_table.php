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
        Schema::create('user_vocabulary_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('vocabulary_id')->constrained()->cascadeOnDelete();

            $table->enum('status', ['new', 'learning', 'reviewing', 'mastered'])->default('new');

            $table->unsignedInteger('translation_correct_streak')->default(0);
            $table->unsignedInteger('meaning_correct_streak')->default(0);

            $table->unsignedInteger('times_seen')->default(0);
            $table->unsignedInteger('times_correct')->default(0);
            $table->unsignedInteger('times_wrong')->default(0);

            $table->timestamp('last_quizzed_at')->nullable();
            $table->timestamp('mastered_at')->nullable();

            $table->timestamps();

            $table->unique(['user_id', 'vocabulary_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_vocabulary_progress');
    }
};
