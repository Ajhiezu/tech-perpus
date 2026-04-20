<!DOCTYPE html>
<html>
<head>
    <title>Laporan Perpustakaan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #4f46e5; padding-bottom: 10px; }
        .header h1 { margin: 0; color: #4f46e5; font-size: 24px; }
        .header p { margin: 5px 0 0; color: #666; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { padding: 10px; border: 1px solid #e2e8f0; text-align: left; }
        th { bg-color: #f8fafc; color: #475569; font-weight: bold; text-transform: uppercase; font-size: 10px; }
        .footer { text-align: right; margin-top: 50px; font-size: 10px; color: #94a3b8; }
        .status { padding: 4px 8px; border-radius: 4px; font-size: 9px; font-weight: bold; text-transform: uppercase; }
        .borrowed { background-color: #e0e7ff; color: #4338ca; }
        .returned { background-color: #d1fae5; color: #065f46; }
        .overdue { background-color: #fee2e2; color: #991b1b; }
    </style>
</head>
<body>
    <div class="header">
        <h1>TechPerpus</h1>
        <p>Laporan Rekapitulasi Transaksi Peminjaman</p>
        <p style="font-size: 10px;">Dicetak pada: {{ now()->format('d M Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Member</th>
                <th>Buku</th>
                <th>Tgl Pinjam</th>
                <th>Tgl Kembali</th>
                <th>Denda</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($loans as $loan)
            <tr>
                <td>#{{ $loan->id }}</td>
                <td>{{ $loan->user->name }}</td>
                <td>{{ $loan->loanDetails->map(fn($d) => $d->book->title)->implode(', ') }}</td>
                <td>{{ $loan->loan_date }}</td>
                <td>{{ $loan->return_date ?? $loan->due_date }}</td>
                <td>Rp {{ number_format($loan->fine_amount) }}</td>
                <td>
                    <span class="status {{ $loan->status }}">
                        {{ $loan->status }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>TechPerpus SaaS Solution - Professional Library Management</p>
    </div>
</body>
</html>
