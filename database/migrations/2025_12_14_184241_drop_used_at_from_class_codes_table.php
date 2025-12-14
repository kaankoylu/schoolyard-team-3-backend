<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('class_codes', function (Blueprint $table) {
            if (Schema::hasColumn('class_codes', 'used_at')) {
                $table->dropColumn('used_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('class_codes', function (Blueprint $table) {
            $table->timestamp('used_at')->nullable()->after('expires_at');
        });
    }
};
