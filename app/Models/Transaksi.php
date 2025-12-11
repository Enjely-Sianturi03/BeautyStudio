<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';

    protected $fillable = [
        'appointment_id',
        'service_id',
        'user_id',
        'payment_method',
        'payment_proof',
        'status',
        'date',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    // Relasi ke User (pelanggan)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); 
    }

    // Relasi ke Jadwal
    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class);
    }

    // Relasi item transaksi
    public function items()
    {
        return $this->hasMany(TransaksiItem::class);
    }

    // Hitung total
    public function refreshTotal()
    {
        $total = $this->items()->sum('subtotal');
        $this->update(['total' => $total]);
    }
}
