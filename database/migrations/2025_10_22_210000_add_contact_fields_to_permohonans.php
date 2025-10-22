<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('permohonans')) {
            Schema::table('permohonans', function (Blueprint $table) {
                if (! Schema::hasColumn('permohonans', 'nik')) {
                    $table->string('nik', 16)->nullable()->after('user_id');
                }
                if (! Schema::hasColumn('permohonans', 'nama')) {
                    $table->string('nama')->nullable()->after('nik');
                }
                if (! Schema::hasColumn('permohonans', 'alamat')) {
                    $table->text('alamat')->nullable()->after('nama');
                }
                if (! Schema::hasColumn('permohonans', 'phone')) {
                    $table->string('phone')->nullable()->after('alamat');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('permohonans')) {
            Schema::table('permohonans', function (Blueprint $table) {
                if (Schema::hasColumn('permohonans', 'phone')) {
                    $table->dropColumn('phone');
                }
                if (Schema::hasColumn('permohonans', 'alamat')) {
                    $table->dropColumn('alamat');
                }
                if (Schema::hasColumn('permohonans', 'nama')) {
                    $table->dropColumn('nama');
                }
                if (Schema::hasColumn('permohonans', 'nik')) {
                    $table->dropColumn('nik');
                }
            });
        }
    }
};
