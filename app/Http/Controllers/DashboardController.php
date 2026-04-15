<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Pinjam;
use App\Models\User;
use App\Models\DetailBarang;

class DashboardController extends Controller
{
public function index()
{   
$totalProduk = Produk::count();

$barangTersedia = DetailBarang::where('status','tersedia')->count();

$barangDipinjam = DetailBarang::where('status','dipinjam')->count();

$barangRusak = DetailBarang::where('status','rusak')->count();

$totalUser = User::count();

$pinjam = Pinjam::latest()->take(4)->get();

$produk = Produk::latest()->take(6)->get();

return view('dashboard', compact(
'totalProduk',
'barangTersedia',
'barangDipinjam',
'barangRusak',
'totalUser',
'pinjam',
'produk'
));
}
}