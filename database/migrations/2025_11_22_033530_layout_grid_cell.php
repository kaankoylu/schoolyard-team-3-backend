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
        Schema::create('layout_grid_cell', function (Blueprint $table) {
            $table->id();
            $table->integer('x');
            $table->integer('y');
            $table->boolean('enum_status');
            $table->unsignedBigInteger('layout_id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('layout_grid_cell');
    }
};
