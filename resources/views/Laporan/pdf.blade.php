<!DOCTYPE html>
<html lang="id">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan {{ $kelompok }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; }
        h2 { text-align: center; margin-bottom: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: center; }
        th { background-color: #f2f2f2; }
        .info { margin-bottom: 15px; text-align: center; font-size: 11px; }

        /* Style baru untuk ringkasan */
        .summary-container {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 20px;
            background-color: #fafafa;
        }
        .summary-title {
            margin: 0 0 10px 0;
            font-size: 14px;
            text-align: left;
        }
        .summary-table {
            width: 100%;
            border: none;
            margin-top: 0;
        }
        .summary-table td {
            border: none;
            text-align: left;
            padding: 3px 5px;
            font-size: 11px;
        }
    </style>
</head>
<body>
    <h2>Laporan Stok {{ $kelompok }}</h2>
    <p class="info">Periode: {{ $tanggalAwal }} s/d {{ $tanggalAkhir }}</p>

    {{-- =============================================== --}}
    {{--         AWAL BAGIAN BARU: BLOK RINGKASAN        --}}
    {{-- =============================================== --}}
    @if (!empty($ringkasan))
    <div class="summary-container">
        <h4 class="summary-title">Ringkasan Laporan</h4>
        <table class="summary-table">
            <tr>
                <td><strong>Keluar Terbanyak:</strong></td>
                <td>
                    @if (isset($ringkasan['keluar_terbanyak']))
                        {{ $ringkasan['keluar_terbanyak']->nama }} ({{ number_format($ringkasan['keluar_terbanyak']->total_keluar, 0, ',', '.') }})
                    @else
                        -
                    @endif
                </td>
                <td><strong>Masuk Terbanyak:</strong></td>
                <td>
                    @if (isset($ringkasan['masuk_terbanyak']))
                        {{ $ringkasan['masuk_terbanyak']->nama }} ({{ number_format($ringkasan['masuk_terbanyak']->total_masuk, 0, ',', '.') }})
                    @else
                        -
                    @endif
                </td>
            </tr>
            <tr>
                <td><strong>Keluar Paling Sedikit:</strong></td>
                <td>
                    @if (isset($ringkasan['keluar_tersedikit']))
                        {{ $ringkasan['keluar_tersedikit']->nama }} ({{ number_format($ringkasan['keluar_tersedikit']->total_keluar, 0, ',', '.') }})
                    @else
                        -
                    @endif
                </td>
                <td><strong>Masuk Paling Sedikit:</strong></td>
                <td>
                    @if (isset($ringkasan['masuk_tersedikit']))
                        {{ $ringkasan['masuk_tersedikit']->nama }} ({{ number_format($ringkasan['masuk_tersedikit']->total_masuk, 0, ',', '.') }})
                    @else
                        -
                    @endif
                </td>
            </tr>
        </table>
    </div>
    @endif


    {{-- Tabel Data Detail --}}
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Stok Akhir</th>
                <th>Total Keluar</th>
                <th>Total Masuk</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->stok }}</td>
                    <td>{{ $item->total_keluar }}</td>
                    <td>{{ $item->total_masuk }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>