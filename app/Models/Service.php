<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    /**
     * Nama tabel di database
     */
    protected $table = 'services'; // atau 'layanans' jika tabel admin pakai nama ini

    /**
     * The attributes that are mass assignable.
     * DISESUAIKAN dengan field admin: nama, durasi_menit, harga, deskripsi
     */
    protected $fillable = [
        'nama',           // dari admin
        'deskripsi',      // dari admin
        'harga',          // dari admin
        'durasi_menit',   // dari admin
        'category',
        'image',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'harga' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Get the appointments for the service.
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    /**
     * Scope a query to only include active services.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include services by category.
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    // ==========================================
    // ACCESSOR untuk KOMPATIBILITAS dengan home.blade.php
    // ==========================================
    
    /**
     * Accessor: $service->name (dari field 'nama')
     */
    public function getNameAttribute()
    {
        return $this->attributes['nama'] ?? '';
    }

    /**
     * Accessor: $service->description (dari field 'deskripsi')
     */
    public function getDescriptionAttribute()
    {
        return $this->attributes['deskripsi'] ?? '';
    }

    /**
     * Accessor: $service->price (dari field 'harga')
     */
    public function getPriceAttribute()
    {
        return $this->attributes['harga'] ?? 0;
    }

    /**
     * Accessor: $service->duration (dari field 'durasi_menit')
     */
    public function getDurationAttribute()
    {
        return $this->attributes['durasi_menit'] ?? 0;
    }

    /**
     * Get formatted price: $50.00
     */
    public function getFormattedPriceAttribute()
    {
        return '$' . number_format($this->harga, 0); // Tanpa desimal untuk Rupiah
    }

    /**
     * Get duration in hours and minutes: "1h 30m" atau "45m"
     */
    public function getFormattedDurationAttribute()
    {
        $hours = floor($this->durasi_menit / 60);
        $minutes = $this->durasi_menit % 60;
        
        if ($hours > 0 && $minutes > 0) {
            return "{$hours}h {$minutes}m";
        } elseif ($hours > 0) {
            return "{$hours}h";
        } else {
            return "{$minutes}m";
        }
    }
}