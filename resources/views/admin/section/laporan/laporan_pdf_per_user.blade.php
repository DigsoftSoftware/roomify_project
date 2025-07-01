@php
    $logoRelativePath = '/admin/images/logos/icon_full.png';
    $logoAbsolutePath = public_path($logoRelativePath);
    $logoBase64 = '';
    if (file_exists($logoAbsolutePath)) {
        $logoBase64 = 'data:image/' . pathinfo($logoAbsolutePath, PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents($logoAbsolutePath));
    }
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Booking - {{ $user->name }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 10px;
            color: #333;
            line-height: 1.6;
        }
        .header-table {
            width: 100%;
            border-bottom: 2px solid #f2f2f2;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header-table .logo-img {
            height: 60px; 
            width: auto;
        }
        .header-table .report-title {
            text-align: right;
        }
        .header-table h1 {
            margin: 0;
            font-size: 20px;
            color: #333;
        }
        .header-table p {
            margin: 0;
            font-size: 11px;
            color: #777;
        }

        .info-table {
            width: 100%;
            margin-bottom: 30px;
        }
        .info-table h4 {
            margin-top: 0;
            margin-bottom: 5px;
            color: #555;
            font-size: 12px;
        }

        .main-table {
            width: 100%;
            border-collapse: collapse;
        }
        .main-table thead th {
            background-color: #f8f9fa;
            color: #333;
            text-align: left;
            padding: 12px 10px;
            border-bottom: 2px solid #dee2e6;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .main-table tbody td {
            padding: 12px 10px;
            border-bottom: 1px solid #f2f2f2;
        }
        .main-table tbody tr:last-child td {
            border-bottom: none;
        }
        
        .text-center { text-align: center; }
        .text-right { text-align: right; }

        .status {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 9px;
            font-weight: bold;
            color: #fff;
            text-transform: uppercase;
        }
        .status-confirmed { background-color: #198754; }
        .status-cancelled { background-color: #dc3545; }
        .status-pending { background-color: #ffc107; color: #333 }

        .summary-section {
            width: 100%;
            margin-top: 20px;
        }
        .summary-table {
            width: 40%;
            margin-left: 60%;
            border-collapse: collapse;
        }
        .summary-table td {
            padding: 8px 10px;
        }
        .summary-table .label {
            font-weight: bold;
            color: #555;
        }
        .summary-table .total {
            font-weight: bold;
            font-size: 14px;
            color: #0d6efd;
            border-top: 2px solid #f2f2f2;
        }
        .footer {
            position: fixed;
            bottom: -20px; 
            left: 0;
            right: 0;
            text-align: center;
            font-size: 9px;
            color: #888;
        }
        .footer .page-number:before {
            content: "Halaman " counter(page);
        }
    </style>
</head>
<body>

    <header>
        <table class="header-table">
            <tr>
                <td>
                    @if($logoBase64)
                        <img src="{{ $logoBase64 }}" alt="Logo Perusahaan" class="logo-img">
                    @else
                        <div style="font-size: 24px; font-weight: bold; color: #0d6efd;">Roomify</div>
                    @endif
                </td>
                <td class="report-title">
                    <h1>Laporan Booking</h1>
                    <p>Tanggal Cetak: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                </td>
            </tr>
        </table>
    </header>

    <main>
        <table class="info-table">
            <tr>
                <td width="50%">
                    <h4>UNTUK PENGGUNA:</h4>
                    <strong>{{ $user->name }}</strong><br>
                    {{ $user->email }}
                </td>
                <td width="50%" style="text-align: right;">
                    <h4>DETAIL LAPORAN:</h4>
                    <strong>Jumlah Transaksi:</strong> {{ $bookings->count() }}
                </td>
            </tr>
        </table>

        <table class="main-table">
            <thead>
                <tr>
                    <th class="text-center">No.</th>
                    <th>Kode Booking</th>
                    <th>Hotel</th>
                    <th>Tipe Kamar</th>
                    <th>Check-in</th>
                    <th>Check-out</th>
                    <th class="text-right">Total Harga</th>
                    <th class="text-center">Status</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $grandTotal = 0;
                @endphp
                @forelse($bookings as $index => $booking)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $booking->kode_bookings }}</td>
                    <td>{{ $booking->room->hotel->name ?? 'N/A' }}</td>
                    <td>{{ $booking->room->type ?? 'N/A' }}</td>
                    <td>{{ \Carbon\Carbon::parse($booking->check_in)->format('d M Y, H:i') }}</td>
                    <td>{{ \Carbon\Carbon::parse($booking->check_out)->format('d M Y, H:i') }}</td>
                    <td class="text-right">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                    <td class="text-center">
                         @if($booking->status == 'confirmed')
                            <span class="status status-confirmed">Diterima</span>
                        @elseif($booking->status == 'cancelled')
                            <span class="status status-cancelled">Dibatalkan</span>
                        @else
                            <span class="status status-pending">Diproses</span>
                        @endif
                    </td>
                </tr>
                @php
                    if ($booking->status == 'confirmed') {
                        $grandTotal += $booking->total_price;
                    }
                @endphp
                @empty
                <tr>
                    <td colspan="8" class="text-center">User ini tidak memiliki riwayat booking.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="summary-section">
            <table class="summary-table">
                <tr>
                    <td class="label">Total Transaksi (Confirmed)</td>
                    <td class="text-right">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>
    </main>

    <footer class="footer">
        Dicetak otomatis melalui sistem booking Roomify. <br>
        Booking System. Created by. Kelompok 8, MI 4C.
    </footer>
</body>
</html>