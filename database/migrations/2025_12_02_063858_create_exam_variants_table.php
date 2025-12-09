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
        Schema::create('exam_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('label'); // "A", "B", "C", "D"
            $table->string('description')->nullable();

            $table->timestamps();

            $table->unique(['exam_id', 'label']); // Нэг шалгалтад A B C D давхцахгүй
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_variants');
    }
};
