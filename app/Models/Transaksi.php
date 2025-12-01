<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';

    protected $fillable = [
        'user_id',      // ← ganti dari pelanggan_id menjadi user_id
        'jadwal_id',
        'total',
        'metode',
        'status',
        'dibayar_at'
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
