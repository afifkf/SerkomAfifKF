@extends('layouts.app')

@section('content')

<div class="bg-white shadow rounded-2xl p-6 w-full">

<div class="flex justify-between items-center mb-4">
    <h2 class="text-2xl font-bold">Edit Barang</h2>
</div>

<form action="{{ route('produk.update', $produk->id) }}" method="POST">
@csrf
@method('PUT')

<div class="mb-4">
    <label class="block mb-1 font-medium">Nama</label>
    <input 
    type="text" 
    name="nama" 
    value="{{ $produk->nama }}"
    class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" 
    required>
</div>

<div class="mb-4">
    <label class="block mb-1 font-medium">Deskripsi</label>
    <textarea 
    name="deskripsi"
    rows="3"
    class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ $produk->deskripsi }}</textarea>
</div>

<div class="mb-4">
    <label class="block mb-1 font-medium">Harga</label>
    <input 
    type="number" 
    name="harga" 
    value="{{ $produk->harga }}"
    class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" 
    required>
</div>

<div class="mb-4">
    <label class="block mb-1 font-medium">Stok</label>
    <input 
    type="number" 
    name="stok" 
    value="{{ $produk->stok }}"
    min="1"
    class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" 
    required>
</div>

<div class="flex gap-2 mt-4">

<button 
type="submit" 
class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
Update
</button>

<a 
href="{{ route('produk.index') }}" 
class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
Kembali
</a>

</div>

</form>

</div>

@endsection