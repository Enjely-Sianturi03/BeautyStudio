<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelanggan_id')->constrained('pelanggans')->cascadeOnDelete();
            $table->foreignId('jadwal_id')->nullable()->constrained('jadwals')->nullOnDelete();
            $table->unsignedInteger('total');
            $table->dateTime('dibayar_at')->nullable();
            $table->enum('metode', ['cash','qris','transfer'])->default('cash');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('transaksis');
    }
};
