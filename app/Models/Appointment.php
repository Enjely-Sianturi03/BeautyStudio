<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'service_id',
        'stylist_id', 
        'appointment_date',
        'appointment_time',
        'end_time',
        'status',
        'notes',
        'admin_notes',
        'payment_method',
        'payment_proof',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        // keep appointment_time as time string (no need for datetime cast with format here),
        // if you prefer Carbon instance, you can cast to 'datetime'
        'appointment_time' => 'string',
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
     * Pastikan stylist_id menunjuk ke tabel users (pegawai).
     */
    public function stylist()
    {
        return $this->belongsTo(User::class, 'stylist_id');
    }

    // public function transaksi()
    // {
    //     return $this->hasOne(Transaksi::class, 'user_id', 'user_id')
    //                 ->whereColumn('date', 'appointment_date'); // pastikan kolom 'date' di transaksi cocok dengan 'appointment_date'
    // }

    // SCOPES
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
        return $query->where('jadwal', '>=', now())
                    ->whereIn('status', ['pending','confirmed']);
    }

    public function scopePast($query)
    {
        return $query->where('jadwal', '<', now())
                    ->whereIn('status', ['pending','confirmed']);
    }

    // ACCESSORS
    public function getFormattedDateAttribute()
    {
        return Carbon::parse($this->appointment_date)->format('d M Y');
    }

    public function getFormattedTimeAttribute()
    {
        return Carbon::parse($this->appointment_time)->format('H:i');
    }

    public function getFormattedDateTimeAttribute()
    {
        return Carbon::parse($this->appointment_date)->format('d M Y') .
               ' - ' .
               Carbon::parse($this->appointment_time)->format('H:i');
    }

    public function canBeCancelled(): bool
    {
        return in_array($this->status, ['pending', 'confirmed']) &&
               Carbon::parse($this->appointment_date)->isFuture();
    }

    public function getEndTimeAttribute($value)
    {
        if($value) return $value;

        if($this->service && $this->appointment_time) {
            return \Carbon\Carbon::parse($this->appointment_time)
                ->addMinutes($this->service->durasi_menit)
                ->format('H:i');
        }

        return null;
    }


}
