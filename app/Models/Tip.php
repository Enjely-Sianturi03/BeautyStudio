<?php
// app/Models/Tip.php

namespace App\Models; // Pastikan namespace sudah benar

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; // PENTING: import kelas Str

class Tip extends Model
{
    protected $fillable = [
        'title',
        // 'slug' Dihapus dari fillable karena dibuat otomatis di boot()
        'category',
        'type',      // article / video
        'content',
        'thumbnail', // untuk artikel
        'video_url', // untuk video
    ];

    /**
     * Metode boot() untuk membuat slug otomatis saat data dibuat (creating).
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($tip) {
            // Membuat slug dari title sebelum data disimpan
            $tip->slug = Str::slug($tip->title); 
        });
    }
    
    // =========================================================
    // ACCESSORS (DARI KODE SEBELUMNYA)
    // =========================================================

    /**
     * Accessor: Ambil URL thumbnail, jika kosong pakai placeholder.
     */
    public function getThumbnailUrlAttribute()
    {
        if ($this->thumbnail) {
            // Memastikan penggunaan asset() yang benar
            return asset('storage/' . $this->thumbnail);
        }

        // Default image jika thumbnail kosong
        return asset('images/default-tips.jpg');
    }

    /**
     * Accessor: Tampilkan tipe konten dalam format label.
     */
    public function getTypeLabelAttribute()
    {
        return $this->type === 'video' ? 'Video' : 'Artikel';
    }
}