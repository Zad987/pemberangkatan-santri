<!DOCTYPE html>
<html>
<head>
    <title>Laporan Admin PPMHA</title>
    <style>
        * {
            margin: 0;
            padding: 0;
        }
        
        body { 
            font-family: 'Calibri', Arial, sans-serif; 
            color: #1a1a1a;
            background: white;
            padding: 0;
            line-height: 1.5;
        }

        .page {
            max-width: 8.5in;
            margin: 0 auto 2px;
            padding: 30px 30px;
            background: white;
            position: relative;
        }

        /* Document Header */
        .doc-header {
            text-align: center;
            margin-bottom: 2px;
            padding-bottom: 2px;
        }

        .doc-classification {
            font-size: 9px;
            color: #666;
            text-transform: uppercase;
            font-weight: bold;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }

        .org-header {
            margin-bottom: 6px;
        }

        .org-name {
            font-size: 12px;
            color: #059669;
            font-weight: bold;
            letter-spacing: 0.5px;
        }

        .org-desc {
            font-size: 10px;
            color: #666;
            margin-top: 2px;
        }

        .doc-title {
            font-size: 13px;
            font-weight: bold;
            color: #000;
            text-transform: uppercase;
            margin: 3px 0;
            letter-spacing: 0.3px;
        }

        .doc-separator {
            height: 1.5px;
            background: #000;
            margin: 2px auto;
            width: 80%;
        }

        .doc-meta {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 6px;
            font-size: 10px;
            margin: 2px 0;
            background: #f5f5f5;
            padding: 5px 8px;
            border-left: 3px solid #059669;
        }

        .meta-row {
            display: flex;
            justify-content: space-between;
            padding: 1px 0;
        }

        .meta-label {
            font-weight: bold;
            color: #059669;
            width: 40%;
        }

        .meta-value {
            color: #333;
            text-align: right;
        }

        /* Content Section */
        .content-section {
            margin: 2px 0;
        }

        .section-header {
            font-size: 11px;
            font-weight: bold;
            color: white;
            background: #059669;
            padding: 4px 6px;
            margin-bottom: 3px;
            display: flex;
            align-items: center;
            gap: 4px;
            letter-spacing: 0.3px;
        }

        .section-number {
            display: inline-block;
            background: rgba(255,255,255,0.3);
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 11px;
        }

        /* Compact Stats */
        .stats-table {
            width: 100%;
            margin-bottom: 5px;
            border-collapse: collapse;
            font-size: 9px;
        }

        .stats-table td {
            padding: 4px 6px;
            border: 1px solid #ddd;
        }

        .stats-label {
            font-weight: bold;
            background: #f5f5f5;
            width: 40%;
            color: #059669;
        }

        .stats-value {
            text-align: right;
            font-weight: bold;
            color: #333;
        }

        /* Data Table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
            font-size: 9px;
        }

        thead {
            background: #059669;
            color: white;
        }

        th {
            padding: 6px 4px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #059669;
            font-size: 9px;
        }

        td {
            padding: 5px 4px;
            border: 1px solid #ddd;
            color: #333;
        }

        tbody tr:nth-child(odd) {
            background: #f9f9f9;
        }

        .badge {
            display: inline-block;
            padding: 2px 5px;
            border-radius: 2px;
            font-weight: bold;
            font-size: 8px;
        }

        .badge-lunas {
            background: #c6f6d5;
            color: #22543d;
            border: 1px solid #9ae6b4;
        }

        .badge-belum {
            background: #fed7d7;
            color: #742a2a;
            border: 1px solid #fc8181;
        }

        /* Footer Section */
        .footer-section {
            margin-top: 8px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            font-size: 10px;
        }

        .signature-block {
            text-align: center;
        }

        .sig-label {
            font-size: 9px;
            color: #666;
            margin-bottom: 6px;
        }

        .sig-line {
            height: 30px;
            border-top: 1px solid #333;
            margin-bottom: 2px;
        }

        .sig-name {
            font-weight: bold;
            font-size: 10px;
        }

        .sig-title {
            font-size: 9px;
            color: #666;
            margin-top: 2px;
        }

        /* Page Footer */
        .page-footer {
            display: none;
        }

        /* Notes */
        .doc-note {
            background: #fffacd;
            border: 1px solid #e6d700;
            border-left: 3px solid #e6d700;
            padding: 4px 6px;
            margin: 3px 0;
            font-size: 9px;
            color: #666;
        }

        .doc-note strong {
            color: #333;
        }

        @media print {
            .page {
                page-break-after: always;
                page-break-inside: avoid;
                box-shadow: none;
            }
        }
    </style>
</head>
<body>

    <!-- Page 1: Cover -->
    <div class="page">
        <div class="doc-header">
            <div class="doc-classification">Laporan Resmi - Dokumen Internal</div>
            <div class="org-header">
                <div class="org-name">PANITIA ROMBONGAN</div>
            </div>
            <div class="doc-separator"></div>
            <div class="doc-title">Laporan Administrasi Data Peserta</div>
            <div class="doc-separator"></div>
        </div>

        <div class="doc-meta">
            <div>
                <div class="meta-row">
                    <span class="meta-label">Total Peserta</span>
                    <span class="meta-value">{{ $totalParticipants }} Orang</span>
                </div>
                <div class="meta-row">
                    <span class="meta-label">Peserta Lunas</span>
                    <span class="meta-value">{{ $paidParticipants }} Orang ({{ $paidPercentage }}%)</span>
                </div>
            </div>
            <div>
                <div class="meta-row">
                    <span class="meta-label">Peserta Belum Lunas</span>
                    <span class="meta-value">{{ $unpaidParticipants }} Orang ({{ $unpaidPercentage }}%)</span>
                </div>
                <div class="meta-row">
                    <span class="meta-label">Format Laporan</span>
                    <span class="meta-value">{{ $sortBy === 'region' ? 'Per Daerah' : 'Per Kategori' }}</span>
                </div>
            </div>
        </div>

        <div class="doc-note">
            <strong>Catatan Penting:</strong> Laporan ini merupakan dokumen resmi yang mencatat status administrasi peserta pada tanggal {{ date('d F Y') }}.
        </div>

    </div>

    <!-- Page 1: Data Detail -->
    <div class="page">
        <div class="content-section">
            <div class="section-header">
                <span class="section-number">1</span>
                DAFTAR DETAIL PESERTA
            </div>
            
            <table>
                <thead>
                    <tr>
                        <th style="width: 4%;">No</th>
                        <th style="width: 16%;">Nama Peserta</th>
                        <th style="width: 11%;">Daerah</th>
                        <th style="width: 11%;">Kategori</th>
                        <th style="width: 11%;">Sudah Bayar</th>
                        <th style="width: 11%;">Kurangnya</th>
                        <th style="width: 12%;">Status</th>
                        <th style="width: 12%;">Tgl. Daftar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($participants as $index => $participant)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><strong>{{ $participant->name }}</strong></td>
                        <td>{{ $participant->region->name ?? '-' }}</td>
                        <td>{{ $participant->category->name ?? '-' }}</td>
                        <td style="text-align: right;">
                            @if($participant->latestPayment && $participant->latestPayment->status === \App\Enums\PaymentStatus::LUNAS)
                                Rp {{ number_format($participant->category->price ?? 0, 0, ',', '.') }}
                            @else
                                Rp {{ number_format($participant->latestPayment->amount ?? 0, 0, ',', '.') }}
                            @endif
                        </td>
                        <td style="text-align: right;">
                            @php
                                $categoryPrice = $participant->category->price ?? 0;
                                $paidAmount = 0;
                                if($participant->latestPayment && $participant->latestPayment->status === \App\Enums\PaymentStatus::LUNAS) {
                                    $remaining = 0;
                                } else {
                                    $paidAmount = $participant->latestPayment->amount ?? 0;
                                    $remaining = max(0, $categoryPrice - $paidAmount);
                                }
                            @endphp
                            Rp {{ number_format($remaining, 0, ',', '.') }}
                        </td>
                        <td>
                            @if($participant->latestPayment && $participant->latestPayment->status === \App\Enums\PaymentStatus::LUNAS)
                                <span class="badge badge-lunas">LUNAS</span>
                            @else
                                <span class="badge badge-belum">BELUM</span>
                            @endif
                        </td>
                        <td>{{ $participant->created_at->format('d-m-Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" style="text-align: center; color: #999;">Tidak ada data peserta</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

    <!-- Page 2: Statistik Daerah -->
    <div class="page">
        <div class="content-section">
            <div class="section-header">
                <span class="section-number">2</span>
                STATISTIK PESERTA PER DAERAH
            </div>
            
            <table>
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th style="width: 28%;">Daerah</th>
                        <th style="width: 14%;">Total</th>
                        <th style="width: 14%;">Lunas</th>
                        <th style="width: 14%;">Belum</th>
                        <th style="width: 18%;">Persen</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($participantsByRegion as $index => $region)
                    @php
                    $regionTotal = $region->participants->count();
                    $regionPaid = 0;
                    foreach($region->participants as $participant) {
                        if($participant->latestPayment && $participant->latestPayment->status === \App\Enums\PaymentStatus::LUNAS) {
                            $regionPaid++;
                        }
                    }
                    $regionUnpaid = $regionTotal - $regionPaid;
                    $regionPercentage = $regionTotal > 0 ? round(($regionPaid / $regionTotal) * 100, 2) : 0;
                    @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><strong>{{ $region->name }}</strong></td>
                        <td style="text-align: center;">{{ $regionTotal }}</td>
                        <td><span class="badge badge-lunas">{{ $regionPaid }}</span></td>
                        <td><span class="badge badge-belum">{{ $regionUnpaid }}</span></td>
                        <td style="text-align: right;"><strong>{{ $regionPercentage }}%</strong></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center; color: #999;">Tidak ada data daerah</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Page 3: Statistik Kategori & Signature -->
    <div class="page">
        <div class="content-section">
            <div class="section-header">
                <span class="section-number">3</span>
                STATISTIK PESERTA PER KATEGORI
            </div>
            
            <table>
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th style="width: 28%;">Kategori</th>
                        <th style="width: 14%;">Total</th>
                        <th style="width: 14%;">Lunas</th>
                        <th style="width: 14%;">Belum</th>
                        <th style="width: 18%;">Persen</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($participantsByCategory as $index => $category)
                    @php
                    $categoryTotal = $category->participants->count();
                    $categoryPaid = 0;
                    foreach($category->participants as $participant) {
                        if($participant->latestPayment && $participant->latestPayment->status === \App\Enums\PaymentStatus::LUNAS) {
                            $categoryPaid++;
                        }
                    }
                    $categoryUnpaid = $categoryTotal - $categoryPaid;
                    $categoryPercentage = $categoryTotal > 0 ? round(($categoryPaid / $categoryTotal) * 100, 2) : 0;
                    @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><strong>{{ $category->name }}</strong></td>
                        <td style="text-align: center;">{{ $categoryTotal }}</td>
                        <td><span class="badge badge-lunas">{{ $categoryPaid }}</span></td>
                        <td><span class="badge badge-belum">{{ $categoryUnpaid }}</span></td>
                        <td style="text-align: right;"><strong>{{ $categoryPercentage }}%</strong></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center; color: #999;">Tidak ada data kategori</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="footer-section">
            <div class="signature-block">
                <div class="sig-label">Mengetahui,</div>
            </div>
            <div class="signature-block">
                <div class="sig-label">Admin Sistem,</div>
                <div class="sig-line"></div>
                <div class="sig-name">{{ auth()->user()->name ?? 'Administrator' }}</div>
                <div class="sig-title">{{ date('d F Y') }}</div>
            </div>
        </div>
    </div>

</body>
</html>
