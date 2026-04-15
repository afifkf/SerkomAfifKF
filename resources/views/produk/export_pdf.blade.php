<!DOCTYPE html>
<html>
<head>
    <title>Daftar Produk</title>
    <style>
        table {
            width: 100%; border-collapse: collapse;
        }
        th, td {
            border: 1px solid black; padding: 5px; text-align: left;
        }
    </style>
</head>
<body>
    <h3>Daftar Produk</h3>
    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Deskripsi</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Dibuat</th>
                <th>Diperbarui</th>
            </tr>
        </thead>
        <tbody>
            @foreach($produks as $produk)
            <tr>
                <td>{{ $produk->nama }}</td>
                <td>{{ $produk->deskripsi }}</td>
                <td>{{ number_format($produk->harga, 0, ',', '.') }}</td>
                <td>{{ $produk->stok }}</td>
                <td>{{ $produk->created_at->format('d-m-Y') }}</td>
                <td>{{ $produk->updated_at->format('d-m-Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
