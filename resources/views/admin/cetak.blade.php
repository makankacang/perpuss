<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peminjaman Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        table th {
            background-color: #f2f2f2;
        }
        @media print {
            body {
                margin: 0;
                padding: 0;
            }
            h1 {
                margin: 0;
                padding: 20px 0;
            }
            table {
                width: 100%;
                border-collapse: collapse;
            }
            table th, table td {
                border: 1px solid #000;
                padding: 8px;
                text-align: left;
            }
            table th {
                background-color: #f2f2f2;
            }
        }
    </style>
</head>
<body>
    <h1>Peminjaman Report</h1>
    
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Tanggal Peminjaman</th>
                <th>Tanggal Pengembalian</th>
                <th>Status Peminjaman</th>
            </tr>
        </thead>
        <tbody>
            @foreach($peminjamans as $peminjaman)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $peminjaman->user->name }}</td>
                <td>{{ $peminjaman->TanggalPeminjaman }}</td>
                <td>{{ $peminjaman->TanggalPengembalian }}</td>
                <td>{{ $peminjaman->StatusPeminjaman }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        // Function to print the page
        function printPage() {
            window.print();
        }

        // Function to redirect after 5 seconds
        function redirectToPeminjaman() {
            setTimeout(function() {
                window.location.href = "/peminjaman";
            }, 5000); // 5000 milliseconds = 5 seconds
        }

        // Print the page and then redirect after 5 seconds
        printPage();
        redirectToPeminjaman();
    </script>
</body>
</html>
