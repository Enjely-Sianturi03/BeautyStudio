<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = ['pelanggan_id','jadwal_id','total','dibayar_at','metode'];
    protected $casts = ['dibayar_at' => 'datetime'];

    public function pelanggan() { return $this->belongsTo(Pelanggan::class); }
    public function jadwal() { return $this->belongsTo(Jadwal::class); }
    public function items() { return $this->hasMany(TransaksiItem::class); }

    // Recalculate total from items
    public function refreshTotal(): void {
        $this->total = $this->items()->sum('subtotal');
        $this->save();
    }
}
