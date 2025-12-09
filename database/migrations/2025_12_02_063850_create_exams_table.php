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
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subject_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('title');          // "Дундын шалгалт" гэх мэт
            $table->string('code')->nullable(); // "MIDTERM_2025_1" гэх мэт
            $table->unsignedInteger('duration_minutes')->nullable(); // 60 мин, 90 мин
            $table->unsignedInteger('total_points')->default(0); // кэшийг хадгалах бол
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
