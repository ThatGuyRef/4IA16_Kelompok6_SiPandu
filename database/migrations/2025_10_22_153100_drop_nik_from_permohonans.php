<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('permohonans') && Schema::hasColumn('permohonans', 'nik')) {
            Schema::table('permohonans', function (Blueprint $table) {
                // drop legacy nik column which is now redundant because we store user_id
                $table->dropColumn('nik');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('permohonans') && ! Schema::hasColumn('permohonans', 'nik')) {
            Schema::table('permohonans', function (Blueprint $table) {
                $table->string('nik', 16)->after('id');
            });
        }
    }
};
