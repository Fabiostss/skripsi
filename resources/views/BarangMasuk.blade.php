<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barang Masuk</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome untuk Ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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

        input[readonly] {
    /* Menghilangkan garis kursor (caret) yang berkedip */
    caret-color: transparent !important; 
    
    /* Mencegah teks di dalamnya bisa diblok/diseleksi */
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    
    /* Mengubah ikon mouse menjadi tanda panah standar */
    cursor: default !important; 
}
    </style>
</head>

@extends('SideBar')
@section('title', 'Barang Masuk')
@section('content')

    <body>
        <div class="container">
            <h3 class="mb-4">Transaksi Produk Masuk</h3>

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
            <div class="card mb-4">
                <div class="card-body">
                    <form action="{{ route('barang-masuk.store') }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-9">
                                <label for="supplier_id" class="form-label">Supplier</label>
                                        <select name="supplier_id" id="supplier_id" class="form-select" required>
                                            <option value="">-- Pilih Supplier --</option>
                                            @foreach($suppliers as $s)
                                                <option value="{{ $s->supplier_id }}">{{ $s->nama_supplier }}</option>
                                            @endforeach
                                        </select>
                                <!-- <label for="supplier_input" class="form-label">Supplier</label>
                                {{-- Input Combobox Supplier --}}
                                <input list="supplierList" id="supplier_input" name="supplier_nama" class="form-control"
                                    placeholder="Ketik nama supplier..." required>
                                <datalist id="supplierList">
                                    @foreach($suppliers as $s)
                                        <option data-id="{{ $s->supplier_id }}" value="{{ $s->nama_supplier }}"></option>
                                    @endforeach
                                </datalist> -->

                                <!-- hidden field untuk dikirim ke server -->
                                <!-- <input type="hidden" name="supplier_id" id="supplier_id"> -->

                            </div>

                            <div class="col-md-3">
                                <label for="tanggal_masuk" class="form-label">Tanggal Transaksi</label>
                                <!-- <input type="date" name="tanggal_masuk" id="tanggal_masuk" class="form-control" readonly
                                            value="{{ date('d-m-Y') }}" required> -->
                                <input type="text" name="tanggal_masuk" id="tanggal_masuk" class="form-control" readonly
                                    value="{{ date('d-m-Y') }}" required>
                            </div>
                        </div>

                        {{-- Produk Dinamis --}}
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <label class="form-label">Pilih Produk</label>
                                        <select id="produkSelect" class="form-select">
                                            <option value="">-- Pilih Produk --</option>
                                            @foreach($products as $p)
                                                <option value="{{ $p->produk_id }}">{{ $p->nama_produk }}</option>
                                            @endforeach
                                        </select>

                                <!-- <label class="form-label">Pilih Produk</label>
                                {{-- Input Combobox Produk --}}
                                <input list="produkList" id="produkInput" class="form-control"
                                    placeholder="Ketik nama produk...">
                                <datalist id="produkList">
                                    @foreach($products as $p)
                                        <option data-id="{{ $p->produk_id }}" value="{{ $p->nama_produk }}"></option>
                                    @endforeach
                                </datalist> -->
                            </div>
                            
                            <!-- hiden fi bka kalo misalnya mau buat combo box -->
                            <!-- <input type="hidden" id="produk_id"> -->
                            <div class="col-md-1 d-flex align-items-end">
                                <button type="button" id="addProdukBtn" class="btn btn-info">Tambah</button>
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
                            <input type="text" name="keterangan" class="form-control" placeholder="cth: Pembelian bulanan">
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
                    </form>
                </div>
            </div>

            {{-- Riwayat Transaksi --}}
            <div class="card">
                <div class="card-header">Riwayat Transaksi Barang Masuk</div>
                <div class="card-body">

                    <form action="{{ route('barang-masuk.index') }}" method="GET" class="mb-4">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-3">
                                <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                                <input type="text" class="form-control datepicker" id="tanggal_mulai" name="tanggal_mulai"
                                    placeholder="dd-mm-yyyy" value="{{ $filters['tanggal_mulai'] ?? '' }}">
                            </div>
                            <div class="col-md-3">
                                <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                                <input type="text" class="form-control datepicker" id="tanggal_selesai"
                                    name="tanggal_selesai" placeholder="dd-mm-yyyy"
                                    value="{{ $filters['tanggal_selesai'] ?? '' }}">
                            </div>
                            <!-- cari nama supplier dan produk dari list nya -->
                            <div class="col-md-3">
                                <label for="nama_supplier" class="form-label">Nama Supplier</label>
                                <input type="text" class="form-control" id="nama_supplier" name="nama_supplier"
                                    placeholder="Ketik nama supplier..." value="{{ $filters['nama_supplier'] ?? '' }}"
                                    list="supplier-list" autocomplete="off">
                                <datalist id="supplier-list">
                                    @if(isset($suppliersForFilter))
                                        @foreach($suppliersForFilter as $supplier)
                                            <option value="{{ $supplier->nama_supplier }}">
                                        @endforeach
                                    @endif
                                </datalist>
                            </div>
                            <!-- bisa di hind buat detail -->
                            <!-- <div class="col-md-3">
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


                            <!-- cari nama supplier dan produk dari list nya -->
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">Cari</button>
                            <a href="{{ route('barang-masuk.index') }}" class="btn btn-secondary">Reset</a>
                        </div>
                    </form>
                    <hr>
                    <div class="table-responsive" style="max-height: 450px; overflow-y: auto;">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>ID Transaksi</th>
                                    <th>Supplier</th>
                                    <!-- <th>Produk</th> uabh -->
                                    <!-- <th>Jumlah</th> uabh -->
                                    <th>User</th>
                                    <th>Keterangan</th>
                                    <th>Detail</th> <!--uabh -->

                                </tr>

                            </thead>
                            <tbody>
                                @forelse($history as $h)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($h->tanggal_masuk)->format('d-m-Y') }}</td>
                                        <td>Transaksi-{{ $h->transaksi_masuk_id }}</td>
                                        <td>{{ $h->nama_supplier }}</td>

                                        <td>{{ $h->user_name }}</td>
                                        <td>{{ $h->keterangan ?? '-' }}</td>
                                        <!-- ini harinya nyala buat detail  -->
                                        <td>
                                            <a href="{{ url('/barang-masuk/detail/' . $h->transaksi_masuk_id) }}"
                                                class="btn btn-sm btn-info text-white">
                                                <i class="bi bi-eye"></i> Detail
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Data tidak ditemukan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <!-- Flatpickr JS -->
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

        {{-- Script Tambah Produk ke Tabel --}}
        <script>


            // let selectedProduk = [];
            // document.getElementById('addProdukBtn').addEventListener('click', function () {
            //     let select = document.getElementById('produkSelect');
            //     let tableBody = document.querySelector('#produkTable tbody');
            //     let produkId = select.value;

            //     if (produkId) {
            //         if (selectedProduk.includes(produkId)) {
            //             alert("Produk ini sudah ditambahkan!");
            //             return;
            //         }
            //         selectedProduk.push(produkId);

            //         let row = document.createElement('tr');
            //         row.innerHTML = `
            //             <td>
            //                 ${select.options[select.selectedIndex].text}
            //                 <input type="hidden" name="produk_id[]" value="${produkId}">
            //             </td>
            //             <td>
            //                 <input type="number" name="jumlah[]" value="1" min="1" class="form-control">
            //             </td>
            //             <td>
            //                 <button type="button" class="btn btn-danger btn-sm removeRow" data-id="${produkId}">Hapus</button>
            //             </td>
            //         `;
            //         tableBody.appendChild(row);
            //         select.value = '';
            //     }
            // });


            //             let selectedProduk = [];
            // document.getElementById('addProdukBtn').addEventListener('click', function () {
            //     let input = document.getElementById('produkInput');
            //     let tableBody = document.querySelector('#produkTable tbody');
            //     let namaProduk = input.value.trim();

            //     if (namaProduk === '') {
            //         alert("Silakan pilih produk terlebih dahulu!");
            //         return;
            //     }
            //      //  Cek apakah nama produk ada di datalist
            //     let datalist = document.getElementById('produkList');
            //     let valid = false;
            //     for (let option of datalist.options) {
            //         if (option.value.toLowerCase() === namaProduk.toLowerCase()) {
            //             valid = true;
            //             break;
            //         }
            //     }

            //     if (!valid) {
            //         alert("Produk tidak ada di master! Silakan pilih dari daftar.");
            //         input.value = '';
            //         return;
            //     }

            //     if (selectedProduk.includes(namaProduk)) {
            //         alert("Produk ini sudah ditambahkan!");
            //         return;
            //     }

            //     selectedProduk.push(namaProduk);

            //     let row = document.createElement('tr');
            //     row.innerHTML = `
            //         <td>
            //             ${namaProduk}
            //             <input type="hidden" name="nama_produk[]" value="${namaProduk}">
            //         </td>
            //         <td>
            //             <input type="number" name="jumlah[]" value="1" min="1" class="form-control">
            //         </td>
            //         <td>
            //             <button type="button" class="btn btn-danger btn-sm removeRow" data-nama="${namaProduk}">Hapus</button>
            //         </td>
            //     `;
            //     tableBody.appendChild(row);

            //     input.value = ''; // reset input setelah ditambahkan
            // });
            //             document.addEventListener('click', function (e) {
            //                 if (e.target.classList.contains('removeRow')) {
            //                     let produkId = e.target.getAttribute('data-id');
            //                     selectedProduk = selectedProduk.filter(id => id !== produkId);
            //                     e.target.closest('tr').remove();
            //                 }
            //             });

            //             //  Validasi supplier saat submit
            // document.querySelector('form').addEventListener('submit', function (e) {
            //     let supplierInput = document.getElementById('supplier_input');
            //     let supplierList = document.getElementById('supplierList');
            //     let supplierName = supplierInput.value.trim();

            //     //  1. Supplier wajib diisi
            //     if (supplierName === '') {
            //         e.preventDefault();
            //         alert("Silakan pilih supplier terlebih dahulu!");
            //         return;
            //     }

            //     //  2. Supplier harus cocok dengan master supplier
            //     let supplierValid = false;
            //     for (let option of supplierList.options) {
            //         if (option.value.toLowerCase() === supplierName.toLowerCase()) {
            //             supplierValid = true;
            //             break;
            //         }
            //     }

            //     if (!supplierValid) {
            //         e.preventDefault();
            //         alert("Supplier tidak ditemukan di master supplier!");
            //         supplierInput.value = '';
            //         supplierInput.focus();
            //         return;
            //     }

            //     //  3. Harus ada minimal 1 produk
            //     if (selectedProduk.length === 0) {
            //         e.preventDefault();
            //         alert("Tambahkan minimal satu produk sebelum menyimpan transaksi!");
            //         return;
            //     }
            // });



            
    
    document.addEventListener('DOMContentLoaded', function() {
        
        // ---  UNTUK DROPDOWN PRODUK ---
        
        // Array untuk mencatat ID produk yang sudah di tabel (mencegah duplikat)
        let selectedProduk = []; 

        //  Tombol "Tambah"
        document.getElementById('addProdukBtn').addEventListener('click', function () {
            // Ambil elemen select produk
            // DIUBAH: ID disesuaikan menjadi 'produkSelect' (tanpa underscore)
            let select = document.getElementById('produkSelect'); 
            let tableBody = document.querySelector('#produkTable tbody');
            
            // Ambil ID dan Teks dari yang dipilih
            let produkId = select.value; 
            let produkText = select.options[select.selectedIndex].text;

            // Validasi 1: Sudah pilih produk?
            if (!produkId) {
                alert("Silakan pilih produk terlebih dahulu.");
                return; 
            }

            // Validasi 2: Cek duplikat
            if (selectedProduk.includes(produkId)) {
                alert("Produk ini sudah ditambahkan!");
                return;
            }
            
            // Lolos validasi: catat ID-nya
            selectedProduk.push(produkId);

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
                    <button type="button" class="btn btn-danger btn-sm removeRow" data-id="${produkId}">Hapus</button>
                </td>
            `;
            
            tableBody.appendChild(row); // Masukkan baris ke tabel
            select.value = ''; // Kosongkan dropdown
        });

        // 2. Logika Tombol "Hapus"
        document.addEventListener('click', function (e) {
            // Cek jika yang diklik adalah tombol .removeRow
            if (e.target.classList.contains('removeRow')) {
                let produkIdToRemove = e.target.getAttribute('data-id');
                
                // Hapus ID dari array pencatat
                selectedProduk = selectedProduk.filter(id => id !== produkIdToRemove); 
                
                // Hapus baris <tr>
                e.target.closest('tr').remove();
            }
        });

        // ---  VALIDASI SUBMIT ---
        
        // Pasang pendengar di form saat di-submit (tombol Simpan Transaksi)
        document.querySelector('form').addEventListener('submit', function (e) {
            
            // Ambil elemen select supplier
            // DIUBAH: ID disesuaikan menjadi 'supplier_id'
            let supplierSelect = document.getElementById('supplier_id');

            // Validasi 1: Supplier harus dipilih
            if (!supplierSelect.value) {
                e.preventDefault(); // Hentikan submit form
                alert("Silakan pilih supplier terlebih dahulu!");
                supplierSelect.focus();
                return;
            }

            // Validasi 2: Minimal 1 produk di tabel
            if (selectedProduk.length === 0) {
                e.preventDefault(); // Hentikan submit form
                alert("Tambahkan minimal satu produk sebelum menyimpan transaksi!");
                return;
            }
        });

    });

   </script>





















<script>
    $(document).ready(function () {
    
        // === I PENGUNCIAN UNTUK TANGGAL TRANSAKSI UTAMA  ===
        flatpickr("#tanggal_masuk", {
            dateFormat: "d-m-Y",
            maxDate: "today", 
            disableMobile: true, 
            clickOpens: false, 
        });
    });
</script>












        <!-- SCRIPT UNTUK FLATPCIKR -->
        <script>

            $(document).ready(function () {
                
                const today = new Date();

                // (tanggal_mulai)
                const fpAwal = flatpickr("#tanggal_mulai", {
                    dateFormat: "d-m-Y",
                    maxDate: "today",        //ga lebih dari hari ini
                    defaultDate: "{{ $filters['tanggal_mulai'] ?? '' }}" || today,
                    onChange: function (selectedDates, dateStr, instance) {
                       
                        if (dateStr) {
                            fpAkhir.set('minDate', dateStr);
                        } else {
                            fpAkhir.set('minDate', null);
                        }
                    }
                });

                // (tanggal_selesai)
                const fpAkhir = flatpickr("#tanggal_selesai", {
                    dateFormat: "d-m-Y",
                    maxDate: "today",
                    defaultDate: "{{ $filters['tanggal_selesai'] ?? '' }}",
                    // 
                    onReady: function (selectedDates, dateStr, instance) {
                        const awal = document.getElementById('tanggal_mulai').value;
                        if (awal) {
                            instance.set('minDate', awal);
                        }
                    }
                });
            });


        </script>
    </body>
@endsection

</html>