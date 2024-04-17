<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            padding: 20px;
        }
        .container {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }
        h1, h2 {
            color: #333;
            margin-bottom: 10px;
            text-align: center;
        }
        p {
            margin-bottom: 5px;
        }
        .book-details, .borrower-details, .category-details {
            margin-top: 20px;
            border-top: 1px solid #ccc;
            padding-top: 20px;
        }
        img {
            max-width: 100px;
            border-radius: 5px;
        }
        .invoice-title {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
            color: #ff6d00;
        }
        .invoice-info {
            text-align: center;
            margin-bottom: 30px;
        }
        .invoice-info p {
            margin: 5px 0;
        }
        .item {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 5px;
        }
        .item-details {
            display: flex;
            align-items: center;
        }
        .item-details img {
            margin-right: 10px;
        }
        .total {
            margin-top: 30px;
            text-align: right;
            font-size: 20px;
            color: #333;
        }
    </style>
</head>
<body onload="window.print()">
    <div class="container">
        <h1>Book Report</h1>
        <div class="invoice-title">REPORT</div>
        <div class="invoice-info">
            <p>Tanggal: {{ date('Y-m-d') }}</p>
            <p>Nomor: #{{ $peminjaman->PeminjamanID }}</p>
        </div>
        <div class="book-details item">
            <h2>Detail buku</h2>
            <div class="item-details">
                <img src="{{ asset('storage/images/' . $peminjaman->buku->image) }}" alt="Book Image">
                <div>
                    <p><strong>Judul:</strong> {{ $peminjaman->buku->Judul }}</p>
                    <p><strong>Penulis:</strong> {{ $peminjaman->buku->Penulis }}</p>
                    <p><strong>Penerbit:</strong> {{ $peminjaman->buku->Penerbit }}</p>
                    <p><strong>Tahun Publikasi:</strong> {{ $peminjaman->buku->TahunTerbit }}</p>
                </div>
            </div>
        </div>
        <div class="borrower-details item">
            <h2>Detail Peminjam</h2>
            <p><strong>User Name:</strong> {{ $peminjaman->user->nama }}</p>
            <p><strong>Email:</strong> {{ $peminjaman->user->email }}</p>
        </div>
        <div class="category-details item">
            <h2>Kategori</h2>
            <p><strong>Nama Kategori:</strong>
                @foreach( $peminjaman->buku->kategoris as $kategori)
                    <span class="table-data">{{ $kategori->NamaKategori }}</span>
                @endforeach
            </p>
        </div>
    </div>
</body>
</html>
