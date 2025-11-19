<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Appointment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'service_id',
        'stylist_id',
        'appointment_date',
        'appointment_time',
        'status',
        'notes',
        'admin_notes',
        'payment_method',
        'payment_proof',
    ];


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'appointment_date' => 'date',
        'appointment_time' => 'datetime:H:i',
    ];

    /**
     * Get the user that owns the appointment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the service for the appointment.
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Get the stylist for the appointment.
     */
    public function stylist()
    {
        return $this->belongsTo(Stylist::class);
    }

    /**
     * Scope a query to only include pending appointments.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include confirmed appointments.
     */
    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    /**
     * Scope a query to only include upcoming appointments.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('appointment_date', '>=', now()->toDateString())
            ->whereIn('status', ['pending', 'confirmed']);
    }

    /**
     * Scope a query to only include past appointments.
     */
    public function scopePast($query)
    {
        return $query->where('appointment_date', '<', now()->toDateString())
            ->orWhere('status', 'completed');
    }

    /**
     * Get formatted date and time.
     */
    public function getFormattedDateTimeAttribute()
    {
        return $this->appointment_date->format('F d, Y') . ' at ' . Carbon::parse($this->appointment_time)->format('g:i A');
    }

    /**
     * Check if appointment can be cancelled.
     */
    public function canBeCancelled(): bool
    {
        return in_array($this->status, ['pending', 'confirmed']) 
            && $this->appointment_date->isFuture();
    }
}
