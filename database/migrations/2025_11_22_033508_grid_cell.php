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

        Schema::create('grid_cell', function (Blueprint $table) {
            $table->id();
            $table->integer('x');
            $table->integer('y');
            /**
             * 2 columns below are foreign keys therefore do not change the type which is unsignedBigInteher
             */
            $table->unsignedBigInteger('asset_id');
            $table->unsignedBigInteger('design_id');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grid_cell');
    }
};
