<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barang Keluar</title>






    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome untuk Ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .card-header {
            background-color: #343a40;
            color: white;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .table thead {
            background-color: #e9ecef;
        }
    </style>
</head>

@extends('SideBar')
@section('title', 'Barang Keluar')
@section('content')

    <body>
        <div class="container">
            <h3 class="mb-4">Transaksi Produk Keluar</h3>

            {{-- Alert sukses / error --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif


            {{-- Form Transaksi --}}
            <!-- <div class="modal fade" id="tambahTransaksiMasukModal" tabindex="-1" aria-labelledby="tambahTransaksiMasukLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content"> -->
            <div class="card mb-2">
                <div class="card-body">
                    <form action="{{ route('barang-keluar.store') }}" method="POST">
                        @csrf
                        <div class="col-md-12">
                            <label for="tanggal_keluar" class="form-label">Tanggal Transaksi</label>
                            <input type="date" name="tanggal_keluar" id="tanggal_keluar" class="form-control" readonly
                                value="{{ date('Y-m-d') }}" required>
                        </div>

                        {{-- Produk Dinamis --}}
                        <div class="row mb-3 align-items-end">

                            <!-- <div class="col-md-8">
        <label class="form-label">Pilih Produk</label>
        <input list="produkList" id="produkSelect" class="form-control" placeholder="Ketik nama produk...">
        <datalist id="produkList">
            @foreach($products as $p)
                <option value="{{ $p->nama_produk }} (Stok: {{ $p->stock }})"></option>
            @endforeach
        </datalist>
    </div>  -->

                            <div class="col-md-8">
                                <label class="form-label">Pilih Produk</label>
                                <select id="produkSelect" class="form-select">
                                    <option value="">-- Pilih Produk --</option>
                                    @foreach($products as $p)
                                        <option value="{{ $p->produk_id }}">{{ $p->nama_produk }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <button type="button" id="addProdukBtn" class="btn btn-info w-100">Tambah</button>
                            </div>
                        </div>

                        <table class="table table-bordered" id="produkTable">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th width="120">Qty</th>
                                    <th width="80">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Baris produk akan ditambahkan via JS --}}
                            </tbody>
                        </table>

                        <div class="mb-3">
                            <label class="form-label">Keterangan</label>
                            <input type="text" name="keterangan" class="form-control" value="{{ old('keterangan') }}"
                                placeholder="cth: Penjualan outlet">
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
                    </form>
                </div>
            </div>
            <!-- </div>
                </div>
                </div> -->


            {{-- Riwayat Transaksi --}}
            <div class="card">
                <div class="card-header">Riwayat Transaksi Barang Keluar</div>
                <div class="card-body">

                    <form action="{{ route('barang-keluar.index') }}" method="GET" class="mb-4">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-4">
                                <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                                <input type="text" class="form-control datepicker" id="tanggal_mulai" name="tanggal_mulai"
                                    placeholder="dd-mm-yyyy" value="{{ $filters['tanggal_mulai'] ?? '' }}">
                            </div>
                            <div class="col-md-4">
                                <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                                <input type="text" class="form-control datepicker" id="tanggal_selesai"
                                    name="tanggal_selesai" placeholder="dd-mm-yyyy"
                                    value="{{ $filters['tanggal_selesai'] ?? '' }}">
                            </div>
                            <!-- nama produk bisa di ind buat detail -->
                            <!-- <div class="col-md-4">
                                    <label for="nama_produk" class="form-label">Nama Produk</label>
                                    <input type="text" class="form-control" id="nama_produk" name="nama_produk" placeholder="Ketik nama produk..." value="{{ $filters['nama_produk'] ?? '' }}" list="product-list" autocomplete="off">
                                    <datalist id="product-list">
                                        @if(isset($productsForFilter))
                                            @foreach($productsForFilter as $product)
                                                <option value="{{ $product->nama_produk }}">
                                            @endforeach
                                        @endif
                                    </datalist>
                                </div> -->
                        </div>

                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">Cari</button>
                            <a href="{{ route('barang-keluar.index') }}" class="btn btn-secondary">Reset</a>
                        </div>
                    </form>
                    <hr>

                    <div class="table-responsive" style="max-height: 450px; overflow-y: auto;"> <!--scroll -->
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>id Transaksi</th>
                                    <!-- <th>Produk</th>  kalo mau ubah -->
                                    <!-- <th>Jumlah</th> kalo mau ubah -->
                                    <th>User</th>
                                    <th>Keterangan</th>
                                    <th>Detail</th> <!--kalo mau ubah -->

                                </tr>
                            </thead>
                            <tbody>
                                @forelse($history as $h)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($h->tanggal_keluar)->format('d-m-Y') }}</td>
                                        <td>Transaksi-</transaksi->{{ $h->transaksi_keluar_id }}</td>

                                        <td>{{ $h->user_name }}</td>
                                        <td>{{ $h->keterangan ?? '-' }}</td>
                                        <td>
                                            <a href="{{ url('/barang-keluar/detail/' . $h->transaksi_keluar_id) }}"
                                                class="btn btn-sm btn-info text-white">
                                                <i class="bi bi-eye"></i> Detail
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Belum ada transaksi</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Flatpickr JS -->
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        {{-- Script Tambah Produk ke Tabel (Sama seperti Barang Masuk) --}}
        <!-- <script>
                document.addEventListener('DOMContentLoaded', function() {
                    let selectedProduk = [];

                    document.getElementById('addProdukBtn').addEventListener('click', function () {
                        let select = document.getElementById('produkSelect');
                        let tableBody = document.querySelector('#produkTable tbody');
                        let produkId = select.value;

                        if (produkId) {
                            if (selectedProduk.includes(produkId)) {
                                alert("Produk ini sudah ditambahkan!");
                                return;
                            }

                            selectedProduk.push(produkId);

                            let row = document.createElement('tr');
                            row.innerHTML = `
                            <td>
                                ${select.options[select.selectedIndex].text}
                                <input type="hidden" name="produk_id[]" value="${produkId}">
                            </td>
                            <td>
                                <input type="number" name="jumlah[]" value="1" min="1" class="form-control">
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm removeRow" data-id="${produkId}">Hapus</button>
                            </td>
                            `;
                            tableBody.appendChild(row);
                            select.value = '';
                        }
                    });

                    document.addEventListener('click', function (e) {
                        if (e.target.classList.contains('removeRow')) {
                            let produkId = e.target.getAttribute('data-id');
                            selectedProduk = selectedProduk.filter(id => id !== produkId);
                            e.target.closest('tr').remove();
                        }
                    });
                });
            </script> -->

        <!-- <script>
                document.addEventListener('DOMContentLoaded', function() {

                    // 1. Buat daftar cek
                  const productMap = {
                        @foreach($products as $p)
                            // cth: "Kopi (Stok: 10)": "3"
                            "{{ $p->nama_produk }} (Stok: {{ $p->stock }})": "{{ $p->produk_id }}",
                        @endforeach
                    }

                    let selectedProduk = []; //  untuk lacak ID produk yg ada tabel

                    // 2. Tombol "Tambah"
                    document.getElementById('addProdukBtn').addEventListener('click', function () {
                        let input = document.getElementById('produkSelect');
                        let tableBody = document.querySelector('#produkTable tbody');

                        let productFullName = input.value; // conoth "testess"

                        // Cari "testess" 
                        let produkId = productMap[productFullName]; 

                        // --- penjangaan ---
                        if (!produkId) { // Jika 'produkId' tidak ada (
                            alert("Produk tidak ada di master! Silakan pilih dari daftar.");
                            return; // <-- Script berhenti di sini
                        }
                        // --- akhir penjnagaan ---

                        // Cek duplikat berdasarkan ID 
                        if (selectedProduk.includes(produkId)) {
                            alert("Produk ini sudah ditambahkan!");
                            return;
                        }

                        selectedProduk.push(produkId);

                        // Buat baris tabel baru
                        let row = document.createElement('tr');
                        row.innerHTML = `
                            <td>
                                ${productFullName} 
                                <input type="hidden" name="produk_id[]" value="${produkId}">
                           </td>
                            <td>
                                <input type="number" name="jumlah[]" value="1" min="1" class="form-control">
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm removeRow" data-id="${produkId}">Hapus</button>
                            </td>
                            `;
                            tableBody.appendChild(row);
                            input.value = ''; 
                    });

                    // 3. Logika Tombol "Hapus"
                    document.addEventListener('click', function (e) {
                        if (e.target.classList.contains('removeRow')) {
                            let produkIdToHapus = e.target.getAttribute('data-id');

                            selectedProduk = selectedProduk.filter(id => id !== produkIdToHapus); 
                            e.target.closest('tr').remove();
                        }
                    });
                });
            </script> -->




        <script>
            document.addEventListener('DOMContentLoaded', function () {

                // --- 1. LOGIKA TOMBOL "TAMBAH" ---
                document.getElementById('addProdukBtn').addEventListener('click', function () {
                    let select = document.getElementById('produkSelect');
                    let tableBody = document.querySelector('#produkTable tbody');

                    let produkId = select.value; // Ambil ID produk, cth: "3"

                    // Cek saja apakah sudah pilih produk atau belum
                    if (!produkId) {
                        alert("Silakan pilih produk terlebih dahulu.");
                        return;
                    }

                    let produkText = select.options[select.selectedIndex].text; // Ambil teks, cth: "Kopi (Stok: 10)"

                    // Buat baris tabel baru
                    let row = document.createElement('tr');
                    row.innerHTML = `
                    <td>
                        ${produkText}
                        <input type="hidden" name="produk_id[]" value="${produkId}">
                    </td>
                    <td>
                        <input type="number" name="jumlah[]" value="1" min="1" class="form-control">
                    </td>
                    <td>
                        <button type"button" class="btn btn-danger btn-sm removeRow">Hapus</button>
                    </td>
                `;

                    tableBody.appendChild(row); // Masukkan baris ke tabel
                    select.value = ''; // Kosongkan dropdown
                });

                // --- 2. LOGIKA TOMBOL "HAPUS" ---
                document.addEventListener('click', function (e) {
                    // Cek apakah yang di-klik adalah tombol "Hapus"
                    if (e.target.classList.contains('removeRow')) {
                        // Hapus baris <tr> terdekat dari tombol yang di-klik
                        e.target.closest('tr').remove();
                    }
                });

            });
        </script>


        <!--  FLATPCIKR -->
        <script>
            $(document).ready(function () {
                flatpickr(".datepicker", {
                    dateFormat: "d-m-Y",
                    position: "below"
                });
            });
        </script>
    </body>
@endsection

</html>










<!-- batasan percobaan gunaan modal  -->
<!-- @if ($errors->any())
        <script>
            var myModal = new bootstrap.Modal(document.getElementById('tambahTransaksiMasukModal'), {
                keyboard: false
            });
            myModal.show();
        </script>
    @endif -->