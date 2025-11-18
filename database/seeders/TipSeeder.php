<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tip;

class TipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Pastikan tabel dikosongkan terlebih dahulu jika Anda menjalankan seeder berulang kali
        // Tip::truncate();

        // 1. Haircare (Artikel)
        Tip::create([
            'title' => 'Rutinitas Merawat Rambut Sehat dan Berkilau',
            'content' => 'Panduan lengkap cara menjaga rambut tetap sehat, bebas ketombe, dan berkilau dengan produk yang tepat. Tips mencuci dan mengeringkan rambut yang benar.',
            'thumbnail' => 'tips_hair_1.jpg',
            'type' => 'article',
            'category' => 'haircare',
            'video_url' => null,
        ]);

        // 2. Makeup (Video)
        Tip::create([
            'title' => 'Tutorial Makeup Natural untuk Pemula 5 Menit',
            'content' => 'Video tutorial makeup natural yang cepat dan mudah diikuti, cocok untuk tampilan sehari-hari atau ke kampus.',
            'thumbnail' => 'tips_makeup_1.jpg',
            'type' => 'video',
            'category' => 'makeup',
            'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ', // Ganti dengan URL video asli
        ]);

        // 3. Skincare (Artikel)
        Tip::create([
            'title' => 'Panduan Lengkap Skincare Pagi dan Malam',
            'content' => 'Urutan pemakaian produk skincare pagi dan malam yang paling efektif untuk mendapatkan kulit glowing. Jangan lewatkan double cleansing!',
            'thumbnail' => 'tips_skincare_1.jpg',
            'type' => 'article',
            'category' => 'skincare',
            'video_url' => null,
        ]);

        // 4. Body Treatment (Artikel)
        Tip::create([
            'title' => 'Resep Body Scrub Alami untuk Mengatasi Kulit Kusam',
            'content' => 'Cara membuat body scrub sendiri di rumah menggunakan bahan-bahan alami seperti kopi, gula, dan minyak kelapa.',
            'thumbnail' => 'tips_body_1.jpg',
            'type' => 'article',
            'category' => 'treatment',
            'video_url' => null,
        ]);

        // 5. Video Tutorial (Fokus pada teknik)
        Tip::create([
            'title' => 'Teknik Contour Wajah Sesuai Bentuk Wajah',
            'content' => 'Tutorial mendalam tentang cara melakukan contouring dan highlighting untuk menonjolkan fitur terbaik wajah Anda.',
            'thumbnail' => 'tips_video_1.jpg',
            'type' => 'video',
            'category' => 'video',
            'video_url' => 'https://www.youtube.com/embed/BvH_n2xO1S4', // Ganti dengan URL video asli
        ]);

        // 6. Skincare (Artikel - Tambahan)
        Tip::create([
            'title' => 'Mengenal Retinol dan Cara Aman Menggunakannya',
            'content' => 'Penjelasan manfaat retinol, dosis yang aman untuk pemula, dan cara menghindari iritasi saat pertama kali menggunakan produk ini.',
            'thumbnail' => 'tips_skincare_2.jpg',
            'type' => 'article',
            'category' => 'skincare',
            'video_url' => null,
        ]);

        // 7. Makeup (Artikel - Tambahan)
        Tip::create([
            'title' => '7 Kuas Makeup Wajib Punya untuk Tampilan Profesional',
            'content' => 'Daftar kuas dasar yang harus dimiliki setiap penggemar makeup, beserta fungsinya masing-masing.',
            'thumbnail' => 'tips_makeup_2.jpg',
            'type' => 'article',
            'category' => 'makeup',
            'video_url' => null,
        ]);

        // 8. Haircare (Video - Tambahan)
        Tip::create([
            'title' => 'Cara Mengatasi Rambut Kering dengan Hair Mask Buatan Sendiri',
            'content' => 'Video panduan membuat hair mask dari alpukat dan madu yang efektif melembapkan rambut kering dan rusak.',
            'thumbnail' => 'tips_hair_2.jpg',
            'type' => 'video',
            'category' => 'haircare',
            'video_url' => 'https://www.youtube.com/embed/C0DP-v5b5yE',
        ]);

        // 9. Body Treatment (Video - Tambahan)
        Tip::create([
            'title' => 'Spa di Rumah: Perawatan Kaki dan Tangan Maksimal',
            'content' => 'Video tutorial untuk rutinitas spa mini di rumah, termasuk manicure dan pedicure sederhana.',
            'thumbnail' => 'tips_body_2.jpg',
            'type' => 'video',
            'category' => 'treatment',
            'video_url' => 'https://www.youtube.com/embed/Q0O0w7b44Y0',
        ]);
        
        // 10. Video (Berita/Tren)
        Tip::create([
            'title' => 'Tren Warna Rambut 2024: Review dan Cara Pewarnaan',
            'content' => 'Lihat tren warna rambut yang sedang viral di tahun ini dan tips untuk mendapatkan warna yang tahan lama.',
            'thumbnail' => 'tips_video_2.jpg',
            'type' => 'video',
            'category' => 'video',
            'video_url' => 'https://www.youtube.com/embed/GZ9NqB2P1rU',
        ]);
    }
}