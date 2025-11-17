<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan</title>

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Flatpickr --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
            padding: 20px;
        }

        .card {
            border-radius: 0.75rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            margin-bottom: 1.5rem;
        }

        table th, table td {
            text-align: center;
            vertical-align: middle;
        }

        .summary-table td {
            text-align: left;
            padding: 5px 10px;
        }

        @media print {
            body * {
                visibility: hidden;
            }
            #printableArea, #printableArea * {
                visibility: visible;
            }
            #printableArea {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
        }
    </style>
</head>

@extends('SideBar')
@section('title', 'Laporan')
@section('content')

<body>
<div class="container mt-4">

    {{-- Judul Halaman --}}
    <div class="card p-4">
        <h3 class="mb-3">Laporan Barang</h3>

        {{-- Form Filter --}}
        <form method="GET" action="{{ url()->current() }}">
            <div class="row g-3 align-items-end">
                <div class="col-md-2">
                    <label for="kelompok" class="form-label">Kelompok:</label>
                    <select class="form-select" name="kelompok" id="kelompok">
                        <option value="">-- Pilih --</option>
                        <option value="produk" {{ request('kelompok') == 'produk' ? 'selected' : '' }}>Produk</option>
                        <option value="kategori" {{ request('kelompok') == 'kategori' ? 'selected' : '' }}>Kategori</option>
                        <option value="tipe" {{ request('kelompok') == 'tipe' ? 'selected' : '' }}>Tipe</option>
                        <option value="bahan" {{ request('kelompok') == 'bahan' ? 'selected' : '' }}>Bahan</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="tanggal_awal" class="form-label">Tanggal Awal:</label>
                    <input type="text" id="tanggal_awal" class="form-control datepicker" name="tanggal_awal"
                           placeholder="dd-mm-yyyy" value="{{ request('tanggal_awal') }}">
                </div>

                <div class="col-md-3">
                    <label for="tanggal_akhir" class="form-label">Tanggal Akhir:</label>
                    <input type="text" id="tanggal_akhir" class="form-control datepicker" name="tanggal_akhir"
                           placeholder="dd-mm-yyyy" value="{{ request('tanggal_akhir') }}">
                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Cari</button>
                </div>
                <div class="col-md-2">
                    {{-- Tombol ini sekarang mengarah ke route export PDF --}}
                    <a href="#" id="btnExportPdf" class="btn btn-danger w-100">Export PDF</a>
                </div>
            </div>
        </form>
    </div>

    {{-- Area Hasil Laporan --}}
    @if(!request('kelompok') || !request('tanggal_awal') || !request('tanggal_akhir'))
        <div class="alert alert-warning">
            <i>Silakan isi semua parameter untuk melihat data.</i>
        </div>
    @else
        @if(!empty($data) && count($data) > 0)
            <div class="card p-4" id="printableArea">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0">Hasil Laporan</h4>
                </div>

                {{-- =============================================== --}}
                {{--         AWAL BAGIAN BARU: BLOK RINGKASAN         --}}
                {{-- =============================================== --}}
                <div class="summary-section border rounded p-3 mb-4 bg-light">
                    <h5 class="mb-3">Ringkasan Laporan</h5>
                    <table class="table table-sm table-borderless summary-table summary-table text-start">
                        <tbody>
                            <tr>
                                <td class="align-top"><strong>Keluar Terbanyak</strong></td>
                                <td class="align-top"><strong>:</strong></td>
                                <td>
                                    {{-- Gunakan isNotEmpty() dan @foreach --}}
                                    @if ($ringkasan['keluar_terbanyak']->isNotEmpty())
                                        <ol style="padding-left: 1.2rem; margin-bottom: 0;">
                                            @foreach ($ringkasan['keluar_terbanyak'] as $item)
                                                <li>{{ $item->nama }} ({{ number_format($item->total_keluar, 0, ',', '.') }})</li>
                                            @endforeach
                                        </ol>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="align-top"><strong>Masuk Terbanyak</strong></td>
                                <td class="align-top"><strong>:</strong></td>
                                <td>
                                    {{-- Gunakan isNotEmpty() dan @foreach --}}
                                    @if ($ringkasan['masuk_terbanyak']->isNotEmpty())
                                        <ol style="padding-left: 1.2rem; margin-bottom: 0;">
                                            @foreach ($ringkasan['masuk_terbanyak'] as $item)
                                                <li>{{ $item->nama }} ({{ number_format($item->total_masuk, 0, ',', '.') }})</li>
                                            @endforeach
                                        </ol>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="align-top"><strong>Keluar Paling Sedikit</strong></td>
                                <td class="align-top"><strong>:</strong></td>
                                <td>
                                    {{-- Gunakan isNotEmpty() dan @foreach --}}
                                    @if ($ringkasan['keluar_tersedikit']->isNotEmpty())
                                        <ol style="padding-left: 1.2rem; margin-bottom: 0;">
                                            @foreach ($ringkasan['keluar_tersedikit'] as $item)
                                                <li>{{ $item->nama }} ({{ number_format($item->total_keluar, 0, ',', '.') }})</li>
                                            @endforeach
                                        </ol>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="align-top"><strong>Masuk Paling Sedikit</strong></td>
                                <td class="align-top"><strong>:</strong></td>
                                <td>
                                    {{-- Gunakan isNotEmpty() dan @foreach --}}
                                    @if ($ringkasan['masuk_tersedikit']->isNotEmpty())
                                        <ol style="padding-left: 1.2rem; margin-bottom: 0;">
                                            @foreach ($ringkasan['masuk_tersedikit'] as $item)
                                                <li>{{ $item->nama }} ({{ number_format($item->total_masuk, 0, ',', '.') }})</li>
                                            @endforeach
                                        </ol>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                {{-- =============================================== --}}
                {{--          AKHIR BAGIAN BARU: BLOK RINGKASAN        --}}
                {{-- =============================================== --}}

                {{-- Tabel Detail Laporan --}}
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Stok saat taggal di cetak</th>
                                <th>Total Keluar</th>
                                <th>Total Masuk</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $row)
                                <tr>
                                    <td>{{ $row->id }}</td>
                                    <td>{{ $row->nama }}</td>
                                    <td>{{ $row->stok }}</td>
                                    <td>{{ $row->total_keluar }}</td>
                                    <td>{{ $row->total_masuk }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="alert alert-info">
                <i>Tidak ada data ditemukan.</i>
            </div>
        @endif
    @endif
</div>

<!-- MODAL UNTUK NOTIFIKASI  -->
<div class="modal fade" id="notifModal" tabindex="-1" aria-labelledby="notifModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="notifModalLabel">Peringatan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="notifModalBody">
        <!-- Pesan error akan diisi oleh JavaScript -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
<!-- MODAL UNTUK NOTIFIKASI  -->

{{-- Bootstrap JS & Flatpickr --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
// Variabel untuk menyimpan instance modal
    let notifModal;

    // Fungsi untuk menampilkan pesan modal
    function tampilkanPesan(pesan) {
        document.getElementById('notifModalBody').innerText = pesan;
        if (!notifModal) {
             notifModal = new bootstrap.Modal(document.getElementById('notifModal'));
        }
        notifModal.show();
    }
    // ---  VALIDASI TANGGAL ---

    const fpAkhir = flatpickr("#tanggal_akhir", {
        dateFormat: "d-m-Y",
        // minDate akan di-set oleh fpAwal
    });

    // Inisialisasi Flatpickr untuk Tanggal Awal
    const fpAwal = flatpickr("#tanggal_awal", {
        dateFormat: "d-m-Y",
        maxDate: "today", // <-- VALIDASI: Tanggal Awal tidak bisa melebihi hari ini
        onChange: function(selectedDates, dateStr, instance) {
            // Saat tanggal_awal diubah, set tanggal_akhir minimal
            fpAkhir.set('minDate', dateStr);
        }
    });
    // --- AKHIR PERUBAHAN VALIDASI TANGGAL ---

    document.getElementById('btnExportPdf').addEventListener('click', function(e) {
        e.preventDefault();

        const kelompok = document.getElementById('kelompok').value;
        const tanggalAwal = document.getElementById('tanggal_awal').value;
        const tanggalAkhir = document.getElementById('tanggal_akhir').value;

        if (!kelompok || !tanggalAwal || !tanggalAkhir) {
            alert('Silakan isi semua parameter sebelum mengekspor.');
            return;
        }
        
        // Pastikan URL ini sesuai dengan route Anda di web.php
       // --- KODE BARU (BENAR) ---
const url = `{{ url('/laporan/export') }}?kelompok=${kelompok}&tanggal_awal=${tanggalAwal}&tanggal_akhir=${tanggalAkhir}`;
        window.open(url, '_blank');
    });
</script>

</body>
@endsection
</html>