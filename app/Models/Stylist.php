<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stylist extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'bio',
        'photo',
        'specialties',
        'experience_years',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'specialties' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Get the appointments for the stylist.
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    /**
     * Get active appointments for the stylist.
     */
    public function activeAppointments()
    {
        return $this->hasMany(Appointment::class)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where('appointment_date', '>=', now()->toDateString());
    }

    /**
     * Scope a query to only include active stylists.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}