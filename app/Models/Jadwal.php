<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $fillable = ['pelanggan_id','layanan_id','staf','mulai_at','status'];
    protected $casts = ['mulai_at' => 'datetime'];

    public function pelanggan() { return $this->belongsTo(Pelanggan::class); }
    public function layanan() { return $this->belongsTo(Layanan::class); }
    public function transaksi() { return $this->hasOne(Transaksi::class); }
}
