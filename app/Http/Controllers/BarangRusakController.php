<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangRusak;



class BarangRusakController extends Controller
{
    public function index()
    {
        $data = BarangRusak::with('detailBarang.produk')->latest()->get();

        return view('barang_rusak.index',compact('data'));
    }
}
