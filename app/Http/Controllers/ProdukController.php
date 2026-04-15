<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Produk;
use App\Models\Pinjam;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index(Request $request)
{
$keyword = $request->input('search');

$query = Produk::withCount([
'detailBarang as stok_tersedia' => function($q){
$q->where('status','tersedia');
},

'detailBarang as stok_dipinjam' => function($q){
$q->where('status','dipinjam');
},

'detailBarang as stok_rusak' => function($q){
$q->where('status','rusak');
}

]);

if ($keyword) {
$query->where('nama', 'like', "%{$keyword}%")
->orWhere('deskripsi', 'like', "%{$keyword}%");
}

$produks = $query->orderBy('created_at', 'desc')->paginate(10);

$produks->appends(['search' => $keyword]);

return view('produk.index', compact('produks', 'keyword'));
}


public function exportPdf()
{
    $produks = Produk::all();
    $pdf = PDF::loadView('produk.export_pdf', compact('produks'))->setPaper('a4', 'landscape');
    return $pdf->download('produk.pdf');
}




    public function create()
    {
        return view('produk.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:1', // stok harus integer dan minimal 1
        ]);

        Produk::create($request->all());

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan');
    }

    public function edit(Produk $produk)
    {
        return view('produk.edit', compact('produk'));
    }

    public function update(Request $request, Produk $produk)
    {
        $request->validate([
            'nama' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
        ]);

        $produk->update($request->all());

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui');
    }

    public function destroy(Produk $produk)
    {
        $produk->delete();
        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus');
    }

    public function pinjam()
{
    return $this->hasMany(Pinjam::class);
}
}
