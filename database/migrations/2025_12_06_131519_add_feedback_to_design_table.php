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
    Schema::table('design', function (Blueprint $table) {
        $table->text('feedback')->nullable()->after('placed_assets');
    });
}

public function down(): void
{
    Schema::table('design', function (Blueprint $table) {
        $table->dropColumn('feedback');
    });
}

};
