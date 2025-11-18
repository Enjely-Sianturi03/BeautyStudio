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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();

            // User yang memberi review
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');

            // Layanan yang di-review
            $table->foreignId('service_id')
                ->nullable()
                ->constrained('services')
                ->onDelete('set null');

            // Appointment yang terkait
            $table->foreignId('appointment_id')
                ->nullable()
                ->constrained('appointments')
                ->onDelete('set null');

            // Nama reviewer (opsional karena sudah ada user)
            $table->string('name')->nullable();

            // Rating 1–5
            $table->unsignedTinyInteger('rating');

            // Pesan review
            $table->text('message');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
