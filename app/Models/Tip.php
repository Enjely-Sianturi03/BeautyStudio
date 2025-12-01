<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tip extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'thumbnail',
        'content',
        'video_url',
        'type',
        'category',
        'is_featured',
        'link',   // <-- TAMBAHKAN INI
    ];

    /**
     * Boot method untuk otomatis buat slug saat create/update
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($tip) {
            $tip->slug = Str::slug($tip->title);
        });

        static::updating(function ($tip) {
            $tip->slug = Str::slug($tip->title);
        });
    }

    /**
     * Accessor: Ambil URL thumbnail
     */
    public function getThumbnailUrlAttribute()
    {
        if ($this->thumbnail) {
            return asset('storage/' . $this->thumbnail);
        }
        return asset('images/default-tips.jpg');
    }

    /**
     * Accessor label tipe
     */
    public function getTypeLabelAttribute()
    {
        return $this->type === 'video' ? 'Video' : 'Artikel';
    }
}
