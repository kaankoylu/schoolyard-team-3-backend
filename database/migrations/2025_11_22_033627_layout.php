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
        Schema::create('layout', function (Blueprint $table) {
            $table->id();
            $table->integer('height');
            $table->integer('width');
            $table->boolean('enum_status');

            $table->unsignedBigInteger('creator_id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('layout');
    }
};
