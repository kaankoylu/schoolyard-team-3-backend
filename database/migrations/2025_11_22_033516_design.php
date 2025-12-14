<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('design', function (Blueprint $table) {
            $table->id();

            // core design data
            $table->integer('rows');
            $table->integer('cols');
            $table->string('background_image')->nullable();
            $table->json('placed_assets');

            // optional relations
            $table->unsignedBigInteger('layout_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('design');
    }
};
