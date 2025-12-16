<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('design', function (Blueprint $table) {
            $table->unsignedTinyInteger('grade')
                  ->nullable()
                  ->after('placed_assets');
        });
    }

    public function down(): void
    {
        Schema::table('design', function (Blueprint $table) {
            $table->dropColumn('grade');
        });
    }
};
