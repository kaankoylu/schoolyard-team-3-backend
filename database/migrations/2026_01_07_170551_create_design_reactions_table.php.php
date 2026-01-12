<?php

// database/migrations/2026_01_07_XXXXXX_create_design_reactions_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('design_reactions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('design_id')->constrained('design')->cascadeOnDelete();

            $table->unsignedBigInteger('class_id')->nullable();
            $table->string('session_id', 64);
            $table->tinyInteger('reaction'); // 1 like, -1 dislike

            $table->timestamps();

            // one reaction per design per student
            $table->unique(['design_id', 'session_id']);
            $table->index(['design_id', 'reaction']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('design_reactions');
    }
};
