<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('class_codes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('class_id')->index();
            $table->string('code', 16)->unique();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();

            $table->foreign('class_id')
                ->references('id')
                ->on('classes')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('class_codes');
    }
};
