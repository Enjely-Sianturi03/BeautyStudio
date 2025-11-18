<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('transaksi_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaksi_id')->constrained('transaksis')->cascadeOnDelete();
            $table->foreignId('layanan_id')->constrained('layanans')->cascadeOnDelete();
            $table->unsignedInteger('qty')->default(1);
            $table->unsignedInteger('harga_satuan');
            $table->unsignedInteger('subtotal');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('transaksi_items');
    }
};
