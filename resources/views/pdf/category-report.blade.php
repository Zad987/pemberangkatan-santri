<!DOCTYPE html>
<html>
<head>
    <title>Laporan Kategori - {{ $category->name }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .header { text-align: center; margin-bottom: 20px; }
        .info { margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Kategori - {{ $category->name }}</h1>
        <p>Harga: Rp {{ number_format($category->price, 2) }}</p>
        <p>Dicetak pada: {{ date('d-m-Y H:i:s') }}</p>
    </div>

    <div class="info">
        <p><strong>Total Peserta dalam Kategori:</strong> {{ $participants->count() }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Peserta</th>
                <th>Daerah</th>
                <th>Status Pembayaran</th>
            </tr>
        </thead>
        <tbody>
            @forelse($participants as $index => $participant)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $participant->name }}</td>
                <td>{{ $participant->region->name ?? 'N/A' }}</td>
                <td>{{ $participant->latestPayment ? $participant->latestPayment->status : 'Belum' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4">Tidak ada peserta dalam kategori ini</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
