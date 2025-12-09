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
        Schema::create('answers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('exam_attempt_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('question_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('choice_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->boolean('is_correct')->default(false);
            $table->unsignedInteger('points_awarded')->default(0);

            $table->timestamps();

            // Нэг оролдлогын үед нэг асуултад ганц л хариу байна
            $table->unique(['exam_attempt_id', 'question_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answers');
    }
};
