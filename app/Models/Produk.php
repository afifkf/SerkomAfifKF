<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $fillable = [
        'nama', 'deskripsi', 'harga', 'stok'
    ];

    public function detailBarang()
    {
        return $this->hasMany(DetailBarang::class);
    }

    
}

