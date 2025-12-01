<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            
            // Perbaikan 1: Mengubah 'phone' menjadi 'telepon' agar konsisten dengan form/controller Indonesia
            // Jika Anda ingin menggunakan 'phone', pastikan Model User dan Controller juga menggunakan 'phone'.
            $table->string('telepon', 15)->nullable(); 
            
            // Perbaikan 2: Mengubah 'address' menjadi 'alamat' untuk konsistensi
            // Gunakan string jika alamat pendek, atau text jika sangat panjang.
            $table->string('alamat')->nullable();
            
            // Perbaikan 3: Menambahkan 'profile_picture' (Sesuai Model User Anda)
            $table->string('profile_picture')->nullable();
            
            $table->enum('role', ['admin', 'owner', 'pegawai', 'customer']);
            
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
        
        // Note: 'password_resets' diganti 'password_reset_tokens' di Laravel 10/11

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};