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
        'staff_id',
        'appointment_date',
        'appointment_time',
        'status',
        'notes',
        'admin_notes',
        'payment_method',
        'payment_proof',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'appointment_time' => 'datetime:H:i',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    // FIX — relasi staf
    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    // === SCOPES ===

    public function scopePending($q)
    {
        return $q->where('status', 'pending');
    }

    public function scopeConfirmed($q)
    {
        return $q->where('status', 'confirmed');
    }

    public function scopeUpcoming($q)
    {
        return $q->where('appointment_date', '>=', now()->toDateString())
                 ->whereIn('status', ['pending', 'confirmed']);
    }

    public function scopePast($q)
    {
        return $q->where(function ($q) {
            $q->where('appointment_date', '<', now()->toDateString())
              ->orWhere('status', 'completed');
        });
    }

    // === ACCESSORS ===

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
               $this->appointment_date->isFuture();
    }

    public function stylist()
    {
        return $this->belongsTo(Stylist::class, 'stylist_id');
    }

    public function transaksi()
    {
        return $this->hasOne(Transaksi::class);
    }


}
