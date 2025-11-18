<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'service_id',
        'appointment_id',
        'name',
        'rating',
        'message',
    ];

    /**
     * Relasi ke user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke service (layanan)
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Relasi ke appointment (booking)
     */
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}
