<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangRusak extends Model
{
    protected $table = 'barang_rusak';

    protected $fillable = [
        'detail_barang_id',
        'keterangan',
        'tanggal_rusak'
    ];

    public function detailBarang()
    {
        return $this->belongsTo(DetailBarang::class);
    }
}