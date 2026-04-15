<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pinjam;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Pinjam::with('produk');

        // Filter tanggal
        if($request->dari && $request->sampai){
            $query->whereBetween('tanggal_pinjam', 
            [$request->dari, $request->sampai]);
        }

        $data = $query->latest()->get();

        return view('laporan.index', compact('data'));
    }


    public function pdf(Request $request)
    {
        $query = Pinjam::with('produk');

        if($request->dari && $request->sampai){
            $query->whereBetween('tanggal_pinjam', 
            [$request->dari, $request->sampai]);
        }

        $data = $query->latest()->get();

        $pdf = Pdf::loadView('laporan.export_pdf', compact('data'));

        return $pdf->download('laporan-peminjaman.pdf');
    }
}