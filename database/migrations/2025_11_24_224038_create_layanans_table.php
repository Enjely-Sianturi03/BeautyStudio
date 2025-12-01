<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('layanans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->integer('durasi_menit')->default(60);
            $table->unsignedInteger('harga'); // simpan dalam rupiah
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('layanans');
    }
};