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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_variant_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->text('text'); // Асуултын агуулга
            $table->unsignedInteger('points')->default(1); // Нэг асуултын оноо
            $table->unsignedInteger('order')->default(0); // Дараалал

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
