<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $fillable = ['nama','telepon','email','alamat'];

    public function jadwals() {
        return $this->hasMany(Jadwal::class);
    }

    public function transaksis() {
        return $this->hasMany(Transaksi::class);
    }
}
