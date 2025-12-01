<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('jadwals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelanggan_id')->constrained('pelanggans')->cascadeOnDelete();
            // $table->foreignId('layanan_id')->constrained('layanans')->cascadeOnDelete();
            $table->string('staf')->nullable();
            $table->dateTime('mulai_at');
            $table->enum('status', ['dijadwalkan','selesai','batal'])->default('dijadwalkan');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('jadwals');
    }
};
