<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiItem extends Model
{
    protected $fillable = ['transaksi_id','layanan_id','qty','harga_satuan','subtotal'];

    public function transaksi() { return $this->belongsTo(Transaksi::class); }
    public function layanan() { return $this->belongsTo(Layanan::class); }
}
