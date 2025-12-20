<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device--width, initial-scale=1.0">
    <title>ROP</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome untuk Ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .table-danger {
        background-color: #f5c6cb !important;
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




{{-- Menggunakan layout utama --}}
@extends('SideBar')

{{-- Mendefinisikan judul halaman --}}
@section('title', 'Manajemen Reorder Point')

@section('content')

    <body>
        <div class="container-fluid p-4">
            {{-- Header Halaman --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h4 fw-bold text-dark">Manajemen Reorder Point</h2>
            </div>

            {{-- Menampilkan notifikasi sukses jika ada --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Card untuk Form Manajemen ROP --}}
            <div class="card shadow-sm">
                <div class="card-body p-4">

                    <!-- $isKritis  -->

                    <!-- {{-- Form untuk mengirim data ke controller --}}
                    <form action="{{ route('rop.storeOrUpdate') }}" method="POST" id="form-manajemen-rop">
                        @csrf {{-- Token CSRF untuk keamanan --}}

                        <div class="mb-3">
                            <label for="rop-product-selector" class="form-label">Pilih Produk</label>
                            <select id="rop-product-selector" name="produk_id" class="form-select" required>
                                <option value="">-- Pilih Produk --</option>
                                {{-- Loop data produk dari controller untuk mengisi dropdown --}}
                                @foreach ($products as $item)
                                    <option value="{{ $item->produk_id }}">
                                        {{ $item->nama_produk }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Container ini akan muncul setelah produk dipilih --}}
                        <div id="rop-details-container" class="d-none border-top pt-3 mt-3">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="safety_stock_input" class="form-label">Safety Stock</label>
                                    <input type="number" id="safety_stock_input" name="safety_stock" class="form-control"
                                        min="0" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="lead_time_input" class="form-label">Lead Time (hari)</label>
                                    <input type="number" id="lead_time_input" name="lead_time" class="form-control" min="1"
                                        required>
                                </div>
                            </div>
                            <div class="text-end mt-4">
                                <button type="submit" class="btn btn-primary">Simpan Pengaturan ROP</button>
                            </div>
                        </div>
                    </form> -->

                    {{-- Daftar ROP Semua Produk --}}
                    <div class="mt-5 pt-4 border-top">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3 class="h5 fw-bold mb-3">Daftar ROP Semua Produk</h3>

                            <div style="width:300px;">
                                <form action="{{ route('rop.index') }}" method="GET">
                                    
                                   <div class="input-group">
                                       <input type="text" class="form-control form-control-sm" list="ProdukOptions" placeholder="Cari nama produk..." name="search" value="{{ $search ?? '' }}">
                                       <datalist id="ProdukOptions">
                                          @foreach ($products as $item)
                                            <option value="{{ $item->nama_produk }}">
                                        {{ $item->nama_produk }}
                                    </option>
                                @endforeach
                                    </datalist>
                                       <button class="btn btn-sm btn-outline-secondary" type="submit"><i class="fa fa-search"></i></button>
                                   </div>
                                  <!--   <!buat tampilin stok kirtis -->
                                   <!-- <div class="form-check form-switch ms-3">
                                        <input class="form-check-input" type="checkbox" name="kritis" id="kritisSwitch"
                                            onchange="this.form.submit()" {{ request('kritis') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="kritisSwitch">Hanya tampilkan stok kritis</label>
                                    </div> -->

                               </form>
                           </div>

                        </div>
                        <!-- <h3 class="h5 fw-bold mb-3">Daftar ROP Semua Produk</h3> -->
                        <div class="table-responsive" style="max-height: 450px; overflow-y: auto;">
                            <table class="table table-striped table-hover table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nama Produk</th>
                                        <th>Stok</th>
                                        <th>Safety Stock (cadangan)</th>
                                        <th>Lead Time (waktu tunggu)</th>
                                        <th>Permintaan (rata-rata)</th>
                                        <th>Nilai ROP</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($data as $item)
                                     @php
                                        $isKritis = isset($item->rop) && isset($item->stock) && $item->stock < $item->rop;
                                    @endphp
                                        <tr   class="{{ $isKritis ? 'table-danger' : '' }}">
                                            
                                            <td>{{ $item->nama_produk }}</td>
                                            <td>{{ $item->stock }}</td>
                                            <td>{{ $item->safety_stock }}</td>
                                            <td>{{ $item->lead_time }} hari</td>
                                            <td>{{ $item->tingkat_permintaan }}</td>
                                            <td class="fw-bold text-dark">{{ $item->rop ?? 'N/A' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center p-5 text-muted">Belum ada data ROP yang
                                                tersimpan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            

                     
</div>




                    </div>
                </div>
            </div>
        </div>
  

{{--  untuk script JavaScript --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const productSelector = document.getElementById('rop-product-selector');
        const detailsContainer = document.getElementById('rop-details-container');
        const leadTimeInput = document.getElementById('lead_time_input');
        const safetyStockInput = document.getElementById('safety_stock_input');

        if (productSelector) {
            productSelector.addEventListener('change', function () {
                const selectedOption = this.options[this.selectedIndex];

                if (this.value) {
              
                    const safetyStock = 0;
                    const leadTime = 0;
                
                    safetyStockInput.value = safetyStock;
                    leadTimeInput.value = leadTime;

                    detailsContainer.classList.remove('d-none');
                } else {
                    
                    detailsContainer.classList.add('d-none');
                }
            });
        }
    });

    function loadHistory(produkId) {
    fetch(`/rop/history/${produkId}`)
        .then(res => res.json())
        .then(data => {
            let tbody = document.querySelector("#historyTable tbody");
            tbody.innerHTML = ""; 

            if (data.length === 0) {
                tbody.innerHTML = `<tr><td colspan="6" class="text-center text-muted">Tidak ada history untuk produk ini.</td></tr>`;
            } else {
                data.forEach(row => {
                    tbody.innerHTML += `
                        <tr>
                            <td>${row.tanggal}</td>
                            <td>${row.nama_produk}</td>
                            <td>${row.lead_time}</td>
                            <td>${row.safety_stock}</td>
                            <td>${row.tingkat_permintaan}</td>
                            <td>${row.rop}</td>
                        </tr>
                    `;
                });
            }
        })
        .catch(err => console.error(err));
}
</script>

</html>