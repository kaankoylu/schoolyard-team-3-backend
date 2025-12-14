<?php

// database/migrations/2025_12_14_000003_add_student_and_class_to_design_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('design', function (Blueprint $table) {
            $table->string('student_name')->nullable()->after('id');
            $table->unsignedBigInteger('class_id')->nullable()->after('student_name')->index();

            $table->foreign('class_id')
                ->references('id')
                ->on('classes')
                ->onDelete('set null');

            $table->index(['class_id', 'student_name']);
        });
    }

    public function down(): void
    {
        Schema::table('design', function (Blueprint $table) {
            $table->dropForeign(['class_id']);
            $table->dropIndex(['class_id']); // index created by ->index()
            $table->dropIndex(['class_id', 'student_name']);
            $table->dropColumn(['student_name', 'class_id']);
        });
    }
};
