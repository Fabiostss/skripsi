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
    <p class="info">Periode: {{ $tanggalAwal }} s/d {{ $tanggalAkhir }} <br>
            Tanggal cetak: {{ now()->format('d-m-Y') }}
    </p>

    {{-- =============================================== --}}
    {{--         AWAL BAGIAN BARU: BLOK RINGKASAN        --}}
    {{-- =============================================== --}}
  @if (!empty($ringkasan))
    <div class="summary-container">
        <h4 class="summary-title">Ringkasan Laporan</h4>
        
        <table class="summary-table">
            <tr>
                <td style="width: 50%; padding-left: 30px;"> 
                    <strong>Keluar Terbanyak:</strong>
                    @if ($ringkasan['keluar_terbanyak']->isNotEmpty())
                        <ol>
                            @foreach ($ringkasan['keluar_terbanyak'] as $item)
                                <li>{{ $item->nama }} ({{ number_format($item->total_keluar, 0, ',', '.') }})</li>
                            @endforeach
                        </ol>
                    @else
                        -
                    @endif

                    {{-- Ini adalah Jarak --}}
                    <div class="summary-spacer"></div>

                    <strong>Keluar Paling Sedikit:</strong>
                    @if ($ringkasan['keluar_tersedikit']->isNotEmpty())
                        <ol>
                            @foreach ($ringkasan['keluar_tersedikit'] as $item)
                                <li>{{ $item->nama }} ({{ number_format($item->total_keluar, 0, ',', '.') }})</li>
                            @endforeach
                        </ol>
                    @else
                        -
                    @endif
                </td>
                
                <td style="width: 50%; padding-left: 30px;">
                    <strong>Masuk Terbanyak:</strong>
                    @if ($ringkasan['masuk_terbanyak']->isNotEmpty())
                        <ol>
                            @foreach ($ringkasan['masuk_terbanyak'] as $item)
                                <li>{{ $item->nama }} ({{ number_format($item->total_masuk, 0, ',', '.') }})</li>
                            @endforeach
                        </ol>
                    @else
                        -
                    @endif
                    
                    {{-- Ini adalah Jarak --}}
                    <div class="summary-spacer"></div>

                    <strong>Masuk Paling Sedikit:</strong>
                    @if ($ringkasan['masuk_tersedikit']->isNotEmpty())
                        <ol>
                            @foreach ($ringkasan['masuk_tersedikit'] as $item)
                                <li>{{ $item->nama }} ({{ number_format($item->total_masuk, 0, ',', '.') }})</li>
                            @endforeach
                        </ol>
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
                <th>Stok saat tanggal di cetak</th>
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