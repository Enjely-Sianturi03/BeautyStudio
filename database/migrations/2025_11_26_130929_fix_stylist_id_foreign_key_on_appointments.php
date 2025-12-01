<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            
            // Jika stylist_id sudah ada, hapus foreign key lamanya dulu
            if (Schema::hasColumn('appointments', 'stylist_id')) {
                // Coba drop foreign key jika ada (nama FK default: appointments_stylist_id_foreign)
                try {
                    $table->dropForeign(['stylist_id']);
                } catch (\Exception $e) {
                    // Abaikan kalau FK tidak ada
                }

                // Drop dulu colom stylist_id supaya kita buat ulang
                try {
                    $table->dropColumn('stylist_id');
                } catch (\Exception $e) {
                    // Abaikan
                }
            }

            // Buat ulang stylist_id sebagai foreign key ke users
            $table->foreignId('stylist_id')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            try {
                $table->dropForeign(['stylist_id']);
            } catch (\Exception $e) {}

            try {
                $table->dropColumn('stylist_id');
            } catch (\Exception $e) {}
        });
    }
};
