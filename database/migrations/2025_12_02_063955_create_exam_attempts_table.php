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
        Schema::create('exam_attempts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('exam_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('exam_variant_id')
                ->constrained('exam_variants')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete(); // default users table гэж үзэж байна

            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();

            $table->unsignedInteger('score')->default(0);
            $table->unsignedInteger('max_score')->default(0);

            $table->string('status')->default('in_progress');
            // in_progress / finished / cancelled гэх мэт

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_attempts');
    }
};
