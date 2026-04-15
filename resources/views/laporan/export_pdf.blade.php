<!DOCTYPE html>
<html>
<head>
    <title>Laporan Peminjaman</title>
    <style>
        body {
            font-family: sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 8px;
            font-size: 12px;
            text-align: left;
        }

        th {
            background: #f2f2f2;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

    </style>
</head>
<body>

<h2>Laporan Peminjaman Barang</h2>

<table>
<thead>
<tr>
    <th>No</th>
    <th>Tanggal Pinjam</th>
    <th>Batas Kembali</th>
    <th>Produk</th>
    <th>Peminjam</th>
    <th>No WhatsApp</th>
    <th>Status</th>
</tr>
</thead>

<tbody>

@foreach($data as $key => $item)
<tr>
    <td>{{ $key + 1 }}</td>
    <td>{{ $item->tanggal_pinjam }}</td>
    <td>{{ $item->batas_kembali }}</td>
    <td>{{ $item->produk->nama ?? '-' }}</td>
    <td>{{ $item->nama_peminjam }}</td>
    <td>{{ $item->no_whatsapp }}</td>
    <td>{{ $item->status }}</td>
</tr>
@endforeach

</tbody>

</table>

</body>
</html>