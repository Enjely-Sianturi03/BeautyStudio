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
       Schema::create('tips', function (Blueprint $table) {
    $table->id();

    // Judul tips / artikel
    $table->string('title');

    // URL slug (contoh: /tips/cara-merawat-kulit)
    $table->string('slug')->unique();

    // Thumbnail gambar
    $table->string('thumbnail')->nullable();

    // Konten artikel
    $table->longText('content')->nullable();

    // Video YouTube / TikTok / Instagram
    $table->string('video_url')->nullable();

    // Jenis konten: 'article' atau 'video'
    $table->string('type')->default('article');

    // Kategori (haircare, skincare, makeup, dll)
    $table->string('category')->default('general');

    // Tips unggulan
    $table->boolean('is_featured')->default(false);

    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tips');
    }
};
