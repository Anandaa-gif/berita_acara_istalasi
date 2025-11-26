<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration untuk menambah kolom login_time.
     */
    public function up(): void
    {
        Schema::table('login_logs', function (Blueprint $table) {
            // Tambahkan kolom login_time setelah ip_address
            if (!Schema::hasColumn('login_logs', 'login_time')) {
                $table->timestamp('login_time')->nullable()->after('ip_address');
            }
        });
    }

    /**
     * Kembalikan perubahan (hapus kolom login_time jika di-rollback).
     */
    public function down(): void
    {
        Schema::table('login_logs', function (Blueprint $table) {
            if (Schema::hasColumn('login_logs', 'login_time')) {
                $table->dropColumn('login_time');
            }
        });
    }
};
