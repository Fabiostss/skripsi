{{-- Menggunakan layout utama Anda, contoh: 'SideBar' --}}
@extends('SideBar')

{{-- Judul Halaman --}}
@section('title', 'Laporan Stok & ROP')

@section('content')
<div class="container-fluid p-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 fw-bold text-dark">Monitoring</h2>
        <div class="d-flex">
            <input type="text" id="searchInput" class="form-control me-3" placeholder="Cari nama produk..." style="width: 250px;">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="filterKritis">
                <label class="form-check-label" for="filterKritis">Hanya tampilkan stok kritis</label>
            </div>
        </div>
    </div>

    {{-- Tabel Laporan --}}
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive" style="max-height: 900px; overflow-y: auto;">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 5%;">ID</th>
                            <th>Nama Produk</th>
                            <th style="width: 10%;">Stok</th>
                            <th style="width: 10%;">ROP</th>
                        </tr>
                    </thead>
                    <tbody id="laporanTableBody">
                        @forelse ($data as $item)
                            <tr data-stok="{{ $item->stok }}" data-rop="{{ $item->rop ?? 0 }}">
                                <td>{{ $item->produk_id }}</td>
                                <td>{{ $item->nama_produk }}</td>
                                <td class="fw-bold fs-5">{{ $item->stok }}</td>
                                <td>{{ $item->rop ?? 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center p-5 text-muted">
                                    Belum ada data produk.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const filterKritis = document.getElementById('filterKritis');
    const tableBody = document.getElementById('laporanTableBody');
    const rows = Array.from(tableBody.querySelectorAll('tr'));

    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        const showKritisOnly = filterKritis.checked;

        rows.forEach(row => {
            const namaProduk = row.children[1].textContent.toLowerCase();
            const stok = parseInt(row.dataset.stok);
            const rop = parseInt(row.dataset.rop);

            const isMatchSearch = namaProduk.includes(searchTerm);
            const isKritis = stok <= rop;

            // Tentukan apakah baris harus ditampilkan atau disembunyikan
            let shouldShow = isMatchSearch;
            if (showKritisOnly) {
                shouldShow = isMatchSearch && isKritis;
            }

            row.style.display = shouldShow ? '' : 'none';

            // Tambahkan atau hapus class 'table danger' untuk pewarnaan
            if (isKritis) {
                row.classList.add('table-danger');
            } else {
                row.classList.remove('table-danger');
            }
        });
    }
    
    // Panggil filterTable saat pertama kali load untuk menerapkan warna awal
    filterTable();

    searchInput.addEventListener('input', filterTable);
    filterKritis.addEventListener('change', filterTable);
});
</script>
@endsection
