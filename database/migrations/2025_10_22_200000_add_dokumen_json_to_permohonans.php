<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('permohonans') && ! Schema::hasColumn('permohonans', 'dokumen_json')) {
            Schema::table('permohonans', function (Blueprint $table) {
                $table->json('dokumen_json')->nullable()->after('notes');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('permohonans') && Schema::hasColumn('permohonans', 'dokumen_json')) {
            Schema::table('permohonans', function (Blueprint $table) {
                $table->dropColumn('dokumen_json');
            });
        }
    }
};
