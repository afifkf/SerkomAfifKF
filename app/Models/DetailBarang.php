<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailBarang extends Model
{
    protected $fillable = [
        'produk_id',
        'kode_barang',
        'status'
    ];

    protected $attributes = [
        'status' => 'tersedia'
    ];

    // Relasi ke Produk
    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    // Relasi ke Pinjam
    public function pinjam()
    {
        return $this->hasOne(Pinjam::class);
    }

    public function rusak()
    {
        return $this->hasOne(BarangRusak::class);
    }
}