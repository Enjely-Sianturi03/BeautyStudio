<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = [
        'pelanggan_id',
        'jadwal_id',
        'total',
        'metode',
        'status',
        'dibayar_at'
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class);
    }

    public function items()
    {
        return $this->hasMany(TransaksiItem::class);
    }

    // hitung ulang total transaksi
    public function refreshTotal()
    {
        $total = $this->items()->sum('subtotal');
        $this->update(['total' => $total]);
    }
}
