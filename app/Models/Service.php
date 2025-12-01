<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $table = 'services';

    protected $fillable = [
        'nama',
        'deskripsi',
        'harga',
        'durasi_menit',
        'category',
        'image',
        'is_active',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function scopeActive($q)
    {
        return $q->where('is_active', true);
    }

    public function scopeByCategory($q, $category)
    {
        return $q->where('category', $category);
    }

    // Accessor kompatibilitas frontend
    public function getNameAttribute()      { return $this->nama; }
    public function getDescriptionAttribute() { return $this->deskripsi; }
    public function getPriceAttribute()     { return $this->harga; }
    public function getDurationAttribute()  { return $this->durasi_menit; }

    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }

    public function getFormattedDurationAttribute()
    {
        $hours = floor($this->durasi_menit / 60);
        $minutes = $this->durasi_menit % 60;

        if ($hours > 0 && $minutes > 0) return "{$hours}h {$minutes}m";
        if ($hours > 0) return "{$hours}h";
        return "{$minutes}m";
    }
}
