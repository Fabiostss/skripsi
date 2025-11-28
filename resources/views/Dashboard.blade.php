
@extends('SideBar')

@section('title', 'Dashboard')

@section('content')
<style>
   
    .kpi-card {
        border-radius: 0.75rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        border: none;
        transition: all 0.3s ease;
    }
    .kpi-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.08);
    }
    .kpi-icon {
        font-size: 3rem; 
        opacity: 0.7;
    }
    .list-group-item-top {
        font-weight: bold;
        background-color: #f8f9fa;
    }
</style>

<div class="container-fluid mt-4">
    <h3 class="mb-4">Dashboard</h3>

    {{-- Baris untuk  Cards Utama --}}
    <div class="row">
        {{-- Card Total Produk --}}
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card kpi-card h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-subtitle mb-2 text-muted">Total Produk</h6>
                        <h4 class="card-title mb-0">{{ number_format($totalProduk ?? 0, 0, ',', '.') }}</h4>
                    </div>
                    <i class="bi bi-box-seam kpi-icon text-primary"></i>
                </div>
            </div>
        </div>

        {{-- Card Produk Kritis --}}
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card kpi-card h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-subtitle mb-2 text-muted">Produk Kritis (Stok <= ROP)</h6>
                        <h4 class="card-title mb-0 text-danger">{{ number_format($produkKritis ?? 0, 0, ',', '.') }}</h4>
                    </div>
                    <i class="bi bi-exclamation-triangle kpi-icon text-danger"></i>
                </div>
            </div>
        </div>

        {{-- Card Total Supplier (Layout diubah ke col-xl-4) --}}
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card kpi-card h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-subtitle mb-2 text-muted">Total Supplier</h6>
                        <h4 class="card-title mb-0">{{ number_format($totalSupplier ?? 0, 0, ',', '.') }}</h4>
                    </div>
                    <i class="bi bi-truck kpi-icon text-info"></i>
                </div>
            </div>
        </div>

        
    </div>

    {{-- Baris untuk Transaksi Hari Ini dan Top 5 --}}
    <div class="row">
        
        {{-- Kolom Kiri: Transaksi & Top 5 Keluar --}}
        <div class="col-lg-6">
            
            {{-- Card Transaksi Keluar Hari Ini --}}
            <div class="card kpi-card mb-4">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-subtitle mb-2 text-muted">Barang Keluar (Hari Ini)</h6>
                        <h4 class="card-title mb-0">{{ number_format($transaksiKeluarHariIni ?? 0, 0, ',', '.') }} Transaksi</h4>
                    </div>
                    <i class="bi bi-arrow-up-right-circle kpi-icon text-warning"></i>
                </div>
            </div>

            {{-- Card Top 5 Keluar --}}
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0">Top 5 Produk Keluar (Bulan Ini)</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Produk</th>
                                <th class="text-end">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topProdukKeluar as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->nama_produk }}</td>
                                <td class="text-end">{{ number_format($item->total_keluar, 0, ',', '.') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted"><i>Tidak ada data.</i></td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Transaksi & Top 5 Masuk --}}
        <div class="col-lg-6">

            {{-- Card Transaksi Masuk Hari Ini --}}
            <div class="card kpi-card mb-4">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-subtitle mb-2 text-muted">Barang Masuk (Hari Ini)</h6>
                        <h4 class="card-title mb-0">{{ number_format($transaksiMasukHariIni ?? 0, 0, ',', '.') }} Transaksi</h4>
                    </div>
                    <i class="bi bi-arrow-down-left-circle kpi-icon text-success"></i>
                </div>
            </div>

            {{-- Card Top 5 Masuk --}}
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0">Top 5 Produk Masuk (Bulan Ini)</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Produk</th>
                                <th class="text-end">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topProdukMasuk as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->nama_produk }}</td>
                                <td class="text-end">{{ number_format($item->total_masuk, 0, ',', '.') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted"><i>Tidak ada data.</i></td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

