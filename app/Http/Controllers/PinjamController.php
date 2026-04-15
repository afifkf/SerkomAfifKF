<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pinjam;
use App\Models\Produk;
use App\Models\User;
use App\Models\DetailBarang;
use Illuminate\Http\Request;

class PinjamController extends Controller
{
    public function index()
    {
        Pinjam::where('status','dipinjam')
        ->whereNotNull('batas_kembali')
        ->where('batas_kembali','<', Carbon::now())
        ->update(['status' => 'terlambat']);

        $totalDipinjam = Pinjam::where('status','dipinjam')->sum('jumlah');
        $totalDikembalikan = Pinjam::where('status','dikembalikan')->sum('jumlah');
        $totalTerlambat = Pinjam::where('status','terlambat')->sum('jumlah');

        $pinjam = Pinjam::with('produk','user')->get();

        return view('pinjam.index', compact(
            'pinjam',
            'totalDipinjam',
            'totalDikembalikan',
            'totalTerlambat'
        ));
    }


    public function create()
    {
        $produk = Produk::all();
        $user = User::all();

        return view('pinjam.create', compact('produk','user'));
    }


    public function store(Request $request)
    {
        $produk = Produk::findOrFail($request->produk_id);

        if ($produk->stok < $request->jumlah) {
            return back()->with('error','Stok tidak cukup');
        }

        // Kurangi stok produk
        $produk->stok -= $request->jumlah;
        $produk->save();


        // Simpan peminjaman
        $pinjam = Pinjam::create([
            'produk_id' => $request->produk_id,
            'user_id' => auth()->id(),
            'nama_peminjam' => $request->nama_peminjam,
            'nim' => $request->nim,
            'no_whatsapp' => $request->no_whatsapp,
            'jumlah' => $request->jumlah,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'batas_kembali' => $request->batas_kembali,
            'status' => 'dipinjam'
        ]);


        // Update Detail Barang
        $detail = DetailBarang::where('produk_id', $request->produk_id)
        ->where('status','tersedia')
        ->limit($request->jumlah)
        ->get();

        foreach($detail as $d)
        {
            $d->update([
                'status' => 'dipinjam'
            ]);
        }


        return redirect()->route('pinjam.index')
        ->with('success','Barang berhasil dipinjam');
    }


    public function kembali($id)
    {
        $pinjam = Pinjam::findOrFail($id);

        $pinjam->tanggal_dikembalikan = now();
        $pinjam->status = 'dikembalikan';
        $pinjam->save();


        // Tambah stok sesuai jumlah
        $produk = Produk::find($pinjam->produk_id);
        $produk->stok += $pinjam->jumlah;
        $produk->save();


        // Update detail barang kembali
        $detail = DetailBarang::where('produk_id', $pinjam->produk_id)
        ->where('status','dipinjam')
        ->limit($pinjam->jumlah)
        ->get();

        foreach($detail as $d)
        {
            $d->update([
                'status' => 'tersedia'
            ]);
        }


        return redirect()->route('pinjam.index')
        ->with('success','Barang dikembalikan');
    }


    public function edit(Pinjam $pinjam)
    {
        $produk = Produk::all();
        $user = User::all();

        return view('pinjam.edit', compact('pinjam','produk','user'));
    }


    public function update(Request $request, Pinjam $pinjam)
    {
        if($request->status == 'dikembalikan' && $pinjam->status != 'dikembalikan')
        {
            $produk = Produk::find($pinjam->produk_id);
            $produk->stok += $pinjam->jumlah;
            $produk->save();


            // Update detail barang
            $detail = DetailBarang::where('produk_id', $pinjam->produk_id)
            ->where('status','dipinjam')
            ->limit($pinjam->jumlah)
            ->get();

            foreach($detail as $d)
            {
                $d->update([
                    'status' => 'tersedia'
                ]);
            }


            $pinjam->tanggal_dikembalikan = now();
        }

        $pinjam->update($request->all());

        return redirect()->route('pinjam.index');
    }


    public function destroy(Pinjam $pinjam)
    {
        $pinjam->delete();

        return redirect()->route('pinjam.index');
    }

}