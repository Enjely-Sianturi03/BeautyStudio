<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    protected $fillable = ['nama','deskripsi','durasi_menit','harga'];

    public function jadwals() {
        return $this->hasMany(Jadwal::class);
    }

    public function items() {
        return $this->hasMany(TransaksiItem::class);
    }
}
