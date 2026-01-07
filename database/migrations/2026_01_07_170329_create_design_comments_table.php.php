<?php

// database/migrations/2026_01_07_XXXXXX_create_design_comments_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('design_comments', function (Blueprint $table) {
            $table->id();

            // IMPORTANT: design table is singular
            $table->foreignId('design_id')->constrained('design')->cascadeOnDelete();

            $table->unsignedBigInteger('class_id')->nullable();
            $table->string('student_name', 255);
            $table->string('session_id', 64); // localStorage id

            $table->text('text');
            $table->timestamps();

            $table->index(['design_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('design_comments');
    }
};
