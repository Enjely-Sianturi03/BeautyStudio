<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute; // 💡 Diperlukan untuk Accessor/Mutator
use Carbon\Carbon;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'service_id',
        'stylist_id', 
        
        // 🚨 PERBAIKAN: Mengganti 'appointment_date' dengan 'jadwal'
        'jadwal',
        // 🚨 PERBAIKAN: Mengganti 'appointment_time' dengan 'jam_mulai'
        'jam_mulai',
        
        'jam_selesai', // 🚨 PERBAIKAN: Mengganti 'end_time' dengan 'jam_selesai' (berdasarkan skema SQL)
        'status',
        'notes',
        'admin_notes',
        'payment_method',
        'payment_proof',
    ];

    protected $casts = [
        'jadwal' => 'date',
        // 'jam_mulai' => 'datetime', 
        // 'jam_selesai' => 'datetime', 
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // RELATIONS
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Stylist / staff yang menangani appointment.
     */
    public function stylist()
    {
        return $this->belongsTo(User::class, 'stylist_id');
    }

    public function scopePending($q)
    {
        return $q->where('status', 'pending');
    }

    public function scopeConfirmed($q)
    {
        return $q->where('status', 'confirmed');
    }

    public function scopeUpcoming($query)
    {
        // 💡 Scope menggunakan nama kolom DB yang benar: 'jadwal'
        return $query->where('jadwal', '>=', now())
                     ->whereIn('status', ['pending','confirmed']);
    }

    public function scopePast($query)
    {
        // 💡 Scope menggunakan nama kolom DB yang benar: 'jadwal'
        return $query->where('jadwal', '<', now())
                     ->whereIn('status', ['pending','confirmed']);
    }

    protected function appointmentDate(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => $this->jadwal,
        );
    }

    protected function appointmentTime(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => $this->jam_mulai,
        );
    }

    public function getFormattedDateAttribute()
    {

        if ($this->appointment_date) {
            return $this->appointment_date->format('d M Y');
        }
        return null;
    }

    public function getFormattedTimeAttribute()
    {
        if ($this->appointment_time) {
            return $this->appointment_time->format('H:i');
        }
        return null;
    }

    public function getFormattedDateTimeAttribute()
    {
        $date = $this->formatted_date;
        $time = $this->formatted_time;
        
        if ($date && $time) {
            return "{$date} - {$time}";
        }
        return $date ?: $time;
    }

    public function canBeCancelled(): bool
    {
        return in_array($this->status, ['pending', 'confirmed']) &&
                $this->jadwal?->isFuture() ?? false; 
    }

    public function getJamSelesaiAttribute($value) 
    {
        if($value) return $value;

        if($this->service && $this->jam_mulai) {
            return $this->jam_mulai
                ->addMinutes($this->service->durasi_menit)
                ->format('H:i');
        }

        return null;
    }
}