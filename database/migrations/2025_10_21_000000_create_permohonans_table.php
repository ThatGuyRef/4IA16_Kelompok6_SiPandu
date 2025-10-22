<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('permohonans')) {
            Schema::create('permohonans', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->string('type');
                $table->text('notes')->nullable();
                $table->string('status')->default('pending'); // pending, processing, approved, rejected
                $table->timestamps();
            });
            return;
        }

        // Table exists; ensure required columns exist (idempotent)
        Schema::table('permohonans', function (Blueprint $table) {
            if (!Schema::hasColumn('permohonans', 'user_id')) {
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
            }
            if (!Schema::hasColumn('permohonans', 'type')) {
                $table->string('type');
            }
            if (!Schema::hasColumn('permohonans', 'notes')) {
                $table->text('notes')->nullable();
            }
            if (!Schema::hasColumn('permohonans', 'status')) {
                $table->string('status')->default('pending');
            }
            if (!Schema::hasColumn('permohonans', 'created_at') || !Schema::hasColumn('permohonans', 'updated_at')) {
                $table->timestamps();
            }
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permohonans');
    }
};
