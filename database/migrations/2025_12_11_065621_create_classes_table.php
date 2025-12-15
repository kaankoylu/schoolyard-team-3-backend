<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('teacher_id');
            $table->string('name');
            $table->timestamps();

            $table->foreign('teacher_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->unique(['teacher_id', 'name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};
