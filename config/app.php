<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Nama Aplikasi
    |--------------------------------------------------------------------------
    |
    | Nilai ini adalah nama aplikasi kamu. Akan digunakan di notifikasi atau
    | elemen UI lain yang menampilkan nama aplikasi.
    |
    */

    'name' => env('APP_NAME', 'Laravel'),

    /*
    |--------------------------------------------------------------------------
    | Lingkungan Aplikasi
    |--------------------------------------------------------------------------
    |
    | Menentukan environment aplikasi saat ini, seperti "production" atau "local".
    | Diatur melalui file .env
    |
    */

    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Mode Debug
    |--------------------------------------------------------------------------
    |
    | Jika mode debug aktif, detail error akan ditampilkan. Jika tidak,
    | hanya pesan error umum yang muncul.
    |
    */

    'debug' => (bool) env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | URL Aplikasi
    |--------------------------------------------------------------------------
    |
    | URL utama aplikasi. Digunakan oleh Artisan CLI dan konfigurasi URL lain.
    |
    */

    'url' => env('APP_URL', 'http://localhost'),

    /*
    |--------------------------------------------------------------------------
    | Zona Waktu Aplikasi
    |--------------------------------------------------------------------------
    |
    | Zona waktu default untuk aplikasi. Diubah ke waktu Indonesia (WIB).
    |
    */

    'timezone' => 'Asia/Jakarta',

    /*
    |--------------------------------------------------------------------------
    | Pengaturan Bahasa Aplikasi
    |--------------------------------------------------------------------------
    |
    | Bahasa default untuk aplikasi. Diset ke Bahasa Indonesia.
    |
    */

    'locale' => env('APP_LOCALE', 'id'),

    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'id'),

    'faker_locale' => env('APP_FAKER_LOCALE', 'id_ID'),

    /*
    |--------------------------------------------------------------------------
    | Kunci Enkripsi
    |--------------------------------------------------------------------------
    |
    | Digunakan oleh sistem enkripsi Laravel.
    |
    */

    'cipher' => 'AES-256-CBC',

    'key' => env('APP_KEY'),

    'previous_keys' => [
        ...array_filter(
            explode(',', (string) env('APP_PREVIOUS_KEYS', ''))
        ),
    ],

    /*
    |--------------------------------------------------------------------------
    | Driver Mode Pemeliharaan
    |--------------------------------------------------------------------------
    |
    | Menentukan cara aplikasi menangani mode maintenance.
    |
    | Opsi: "file", "cache"
    |
    */

    'maintenance' => [
        'driver' => env('APP_MAINTENANCE_DRIVER', 'file'),
        'store' => env('APP_MAINTENANCE_STORE', 'database'),
    ],

];
