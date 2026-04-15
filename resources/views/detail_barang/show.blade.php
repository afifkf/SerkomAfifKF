@extends('layouts.app')

@section('content')

<div class="bg-white p-6 rounded shadow">

<h2 class="text-xl font-bold mb-4">
Detail Barang : {{ $produk->nama }}
</h2>

<div class="flex gap-2 mb-3">

<a href="{{ route('detail-barang.create') }}"
class="bg-blue-500 text-white px-4 py-2 rounded">
Tambah Detail
</a>

<a href="{{ route('produk.index') }}"
class="bg-gray-500 text-white px-4 py-2 rounded">
Kembali
</a>

</div>

@if(session('success'))
<div class="bg-green-100 text-green-700 p-3 mb-3 rounded">
{{ session('success') }}
</div>
@endif

<table class="w-full border">

<thead class="bg-gray-100">

<tr>
<th class="border p-2">No</th>
<th class="border p-2">Kode Barang</th>
<th class="border p-2">Status</th>
<th class="border p-2">Aksi</th>
</tr>

</thead>

<tbody>

@foreach($data as $d)

<tr>

<td class="border p-2 text-center">
{{ $loop->iteration }}
</td>

<td class="border p-2 text-center">
{{ $d->kode_barang }}
</td>

<td class="border p-2 text-center">

@if($d->status == 'tersedia')

<span class="bg-green-200 text-green-700 px-2 py-1 rounded">
Tersedia
</span>

@elseif($d->status == 'dipinjam')

<span class="bg-yellow-200 text-yellow-700 px-2 py-1 rounded">
Dipinjam
</span>

@elseif($d->status == 'rusak')

<span class="bg-red-200 text-red-700 px-2 py-1 rounded">
Rusak
</span>

@endif

</td>

<td class="border p-2 flex gap-2 justify-center">

<a href="{{ route('detail-barang.edit',$d->id) }}"
class="bg-yellow-500 text-white px-3 py-1 rounded">
Edit
</a>

<form action="{{ route('detail-barang.destroy',$d->id) }}"
method="POST">

@csrf
@method('DELETE')

<button 
onclick="return confirm('Yakin hapus data?')"
class="bg-red-500 text-white px-3 py-1 rounded">
Hapus
</button>

</form>

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

@endsection