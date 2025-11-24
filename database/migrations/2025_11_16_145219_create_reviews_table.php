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

            // User yang memberi review (boleh null)
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Layanan yang di-review (boleh null)
            $table->foreignId('service_id')
                ->nullable()
                ->constrained('services')
                ->nullOnDelete();

            // Appointment yang terkait (boleh null)
            $table->foreignId('appointment_id')
                ->nullable()
                ->constrained('appointments')
                ->nullOnDelete();

            // Nama reviewer
            $table->string('name')->nullable();

            // Rating 1–5
            $table->unsignedTinyInteger('rating');

            // Pesan review
            $table->text('message');

            // Status disetujui admin
            $table->boolean('is_approved')->default(false);

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
