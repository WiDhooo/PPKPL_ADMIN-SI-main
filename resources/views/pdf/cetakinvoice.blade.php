<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $pendaftaran->order_id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .invoice-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .invoice-details {
            margin: 20px;
        }
        .invoice-details table {
            width: 100%;
            border-collapse: collapse;
        }
        .invoice-details table, th, td {
            border: 1px solid #ddd;
        }
        .invoice-details th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="invoice-header">
        <h1>Invoice #{{ $pendaftaran->order_id }}</h1>
        <p>Tanggal Pembayaran: {{ $paymentDate }}</p>
    </div>
    <div class="invoice-details">
        <h2>Detail Pembayaran</h2>
        <table>
            <tr>
                <th>Nama Pembeli</th>
                <td>{{ $pendaftaran->nama_santri }}</td>
            </tr>
            <tr>
                <th>Total Pembayaran</th>
                <td>{{ number_format($pendaftaran->total_bayar, 2) }}</td>
            </tr>
            <tr>
                <th>Status Pembayaran</th>
                <td>{{ ucfirst($pendaftaran->status_pembayaran) }}</td>
            </tr>
            <tr>
                <th>Metode Pembayaran</th>
                <td>{{ $pendaftaran->metode_pembayaran }}</td>
            </tr>
            <tr>
                <th>Order ID</th>
                <td>{{ $pendaftaran->order_id }}</td>
            </tr>
        </table>
    </div>
</body>
</html>
