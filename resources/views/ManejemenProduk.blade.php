<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
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
         .pagination-reversed nav > div:first-child {
            flex-direction: row-reverse;
        }
    </style>
</head>

@extends('SideBar')
@section('title', 'Manajemen Produk')
@section('content')
    
<body>

    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Manajemen Produk</h4>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahProdukModal">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Produk
                </button>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- PERUBAHAN 1: Menambahkan FORMULIR PENCARIAN DAN FILTER yang lengkap --}}
                <form action="{{ route('produk.index') }}" method="GET" class="mb-4 p-3 border rounded bg-light">
                    <div class="row g-2">
                        <div class="col-md-12">
                            <label for="search" class="form-label small">Nama Produk</label>
                            <input type="text" class="form-control form-control-sm" id="search" name="search" placeholder="Cari atau pilih Nama Produk..." value="{{ request('search') }}" list="productListOptions">
                            <datalist id="productListOptions">
                                {{-- Pastikan controller mengirimkan variabel $productList --}}
                                @foreach($productList as $product)
                                    <option value="{{ $product->nama_produk }}">
                                @endforeach
                            </datalist>
                        </div>
                        <div class="col-md-3">
                            <label for="kategori_id_filter" class="form-label small">Kategori</label>
                            <select id="kategori_id_filter" name="kategori_id" class="form-select form-select-sm">
                                <option value="">Semua Kategori</option>
                                @foreach($kategoriList as $k)
                                    <option value="{{ $k->kategori_id }}" {{ request('kategori_id') == $k->kategori_id ? 'selected' : '' }}>{{$k->nama_kategori}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="tipe_id_filter" class="form-label small">Tipe</label>
                            <select id="tipe_id_filter" name="tipe_id" class="form-select form-select-sm">
                                <option value="">Semua Tipe</option>
                                @foreach($tipeList as $t)
                                    <option value="{{ $t->tipe_id }}" {{ request('tipe_id') == $t->tipe_id ? 'selected' : '' }}>{{$t->nama_tipe}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="bahan_id_filter" class="form-label small">Bahan</label>
                            <select id="bahan_id_filter" name="bahan_id" class="form-select form-select-sm">
                                <option value="">Semua Bahan</option>
                                @foreach($bahanList as $b)
                                    <option value="{{ $b->bahan_id }}" {{ request('bahan_id') == $b->bahan_id ? 'selected' : '' }}>{{$b->nama_bahan}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="satuan_id_filter" class="form-label small">Satuan</label>
                            <select id="satuan_id_filter" name="satuan_id" class="form-select form-select-sm">
                                <option value="">Semua Satuan</option>
                                @foreach($satuanList as $s)
                                    <option value="{{ $s->satuan_id }}" {{ request('satuan_id') == $s->satuan_id ? 'selected' : '' }}>{{$s->nama_satuan}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="is_active_filter" class="form-label small">Status</label>
                            <select id="is_active_filter" name="is_active" class="form-select form-select-sm">
                                <option value="">Semua Status</option>
                                <option value="yes" {{ request('is_active') == 'yes' ? 'selected' : '' }}>Aktif</option>
                                <option value="no" {{ request('is_active') == 'no' ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-2">
                        <button type="submit" class="btn btn-secondary btn-sm">Filter</button>
                        <a href="{{ route('produk.index') }}" class="btn btn-outline-secondary btn-sm">Reset</a>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Produk</th>
                                <th>Kategori</th>
                                <th>Tipe</th>
                                <th>Bahan</th>
                                <th>Satuan</th>
                                <!-- <th>Deskripsi</th> -->
                                <th>Stok</th>
                                <th class="text-center">Is Active</th>
                                {{-- untuk menampilkan kolom Aksi --}}
                                {{-- <th class="text-center">Aksi</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                            <tr>
                                {{-- PERUBAHAN 3: Mengganti penomoran agar sesuai dengan paginasi --}}
                                <td class="text-center">{{ ($products->currentPage() - 1) * $products->perPage() + $loop->iteration }}</td>
                                <td>{{ $product->nama_produk }}</td>
                                <td>{{ $product->nama_kategori }}</td>
                                <td>{{ $product->nama_tipe }}</td>
                                <td>{{ $product->nama_bahan }}</td>
                                <td>{{ $product->nama_satuan }}</td>
                            
                                <td class="text-center">{{ $product->stock }}</td>
                                <td class="text-center">
                                    <a href="{{ route('produk.toggleStatus', ['id' => $product->produk_id]) }}" class="text-decoration-none">
                                        @if($product->is_active == 'yes')
                                            <span class="badge bg-success">Yes</span>
                                        @else
                                            <span class="badge bg-danger">No</span>
                                        @endif
                                    </a>
                                </td>
                                {{--  ini untuk menampilkan tombol Edit & Hapus --}}
                                {{--
                                <td class="text-center">
                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editProdukModal"
                                        data-id="{{ $product->produk_id }}"
                                        data-nama="{{ $product->nama_produk }}"
                                        data-kategori="{{ $product->kategori_id }}"
                                        data-tipe="{{ $product->tipe_id }}"
                                        data-bahan="{{ $product->bahan_id }}"
                                        data-satuan="{{ $product->satuan_id }}"
                                        data-stok="{{ $product->stock }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapusProdukModal"
                                        data-id="{{ $product->produk_id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                                --}}
                            </tr>
                            @empty
                            <tr>
                                {{-- kolom Aksi aktif, ubah colspan menjadi "9" --}}
                                <td colspan="8" class="text-center">Data produk tidak ditemukan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{-- P Menambahkan blok untuk menampilkan tombol paginasi --}}
                <div class="pagination-reversed mt-3">
                    {!! $products->links('pagination::bootstrap-5') !!}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Produk -->
    <div class="modal fade" id="tambahProdukModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('produk.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Produk Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="nama_produk" class="form-label">Nama Produk</label>
                            <input type="text" class="form-control" id="nama_produk" name="nama_produk" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="kategori_id" class="form-label">Kategori</label>
                            <select class="form-select" id="kategori_id" name="kategori_id" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($kategoriList as $k)
                                    <option value="{{ $k->kategori_id }}">{{ $k->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tipe_id" class="form-label">Tipe</label>
                            <select class="form-select" id="tipe_id" name="tipe_id" required>
                                <option value="">-- Pilih Tipe --</option>
                                @foreach($tipeList as $t)
                                    <option value="{{ $t->tipe_id }}">{{ $t->nama_tipe }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="bahan_id" class="form-label">Bahan</label>
                            <select class="form-select" id="bahan_id" name="bahan_id" required>
                                <option value="">-- Pilih Bahan --</option>
                                @foreach($bahanList as $b)
                                    <option value="{{ $b->bahan_id }}">{{ $b->nama_bahan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="satuan_id" class="form-label">Satuan</label>
                            <select class="form-select" id="satuan_id" name="satuan_id" required>
                                <option value="">-- Pilih Satuan --</option>
                                @foreach($satuanList as $s)
                                    <option value="{{ $s->satuan_id }}">{{ $s->nama_satuan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="deskripsi" class="form-label">deskripsi</label>
                            <input type="text" class="form-control" id="deskripsi" name="deskripsi">
                        </div>
                    </div> -->

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="stock" class="form-label">Stok</label>
                            <input type="number" class="form-control" id="stock" name="stock" min="0" required>
                        </div>
                        <div class="col-md-6">
                            <label for="is_active" class="form-label">Status</label>
                            <select class="form-select" id="is_active" name="is_active" required>
                                <option value="yes">Aktif</option>
                                <option value="no">Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    </div>
    
    {{-- untuk mengaktifkan Modal Edit & Hapus --}}
    {{--
    <!-- Modal Edit Produk -->
    <div class="modal fade" id="editProdukModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="editProdukForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header"><h5 class="modal-title">Edit Produk</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                    <div class="modal-body">
                        <div class="row"><div class="col-md-12 mb-3"><label class="form-label">Nama Produk</label><input type="text" class="form-control" id="edit_nama_produk" name="nama_produk" required></div></div>
                        <div class="row">
                             <div class="col-md-6 mb-3"><label class="form-label">Kategori</label><select class="form-select" id="edit_kategori_id" name="kategori_id" required>@foreach($kategoriList as $k)<option value="{{ $k->kategori_id }}">{{ $k->nama_kategori }}</option>@endforeach</select></div>
                             <div class="col-md-6 mb-3"><label class="form-label">Tipe</label><select class="form-select" id="edit_tipe_id" name="tipe_id" required>@foreach($tipeList as $t)<option value="{{ $t->tipe_id }}">{{ $t->nama_tipe }}</option>@endforeach</select></div>
                        </div>
                        <div class="row">
                             <div class="col-md-6 mb-3"><label class="form-label">Bahan</label><select class="form-select" id="edit_bahan_id" name="bahan_id" required>@foreach($bahanList as $b)<option value="{{ $b->bahan_id }}">{{ $b->nama_bahan }}</option>@endforeach</select></div>
                             <div class="col-md-6 mb-3"><label class="form-label">Satuan</label><select class="form-select" id="edit_satuan_id" name="satuan_id" required>@foreach($satuanList as $s)<option value="{{ $s->satuan_id }}">{{ $s->nama_satuan }}</option>@endforeach</select></div>
                        </div>
                        <div class="mb-3"><label class="form-label">Stok</label><input type="number" class="form-control" id="edit_stock" name="stock" required min="0"></div>
                    </div>
                    <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary">Simpan Perubahan</button></div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Hapus Produk -->
    <div class="modal fade" id="hapusProdukModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="hapusProdukForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header"><h5 class="modal-title">Konfirmasi Hapus</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                    <div class="modal-body"><p>Apakah Anda yakin ingin menghapus produk ini?</p></div>
                    <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-danger">Ya, Hapus</button></div>
                </form>
            </div>
        </div>
    </div>
    --}}

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @if ($errors->any())<script>var myModal = new bootstrap.Modal(document.getElementById('tambahProdukModal'), { keyboard: false });myModal.show();</script>@endif

    {{-- untuk mengaktifkan JavaScript untuk Modal Edit & Hapus --}}
    {{--
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editModal = document.getElementById('editProdukModal');
            if(editModal) {
                editModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    // Mengambil semua data dari atribut data-* di tombol
                    const id = button.getAttribute('data-id');
                    const nama = button.getAttribute('data-nama');
                    const kategori = button.getAttribute('data-kategori');
                    const tipe = button.getAttribute('data-tipe');
                    const bahan = button.getAttribute('data-bahan');
                    const satuan = button.getAttribute('data-satuan');
                    const stok = button.getAttribute('data-stok');

                    const form = document.getElementById('editProdukForm');
                    form.action = `/produk/${id}`; // Mengatur action form

                    // Mengisi semua field di dalam form
                    form.querySelector('#edit_nama_produk').value = nama;
                    form.querySelector('#edit_kategori_id').value = kategori;
                    form.querySelector('#edit_tipe_id').value = tipe;
                    form.querySelector('#edit_bahan_id').value = bahan;
                    form.querySelector('#edit_satuan_id').value = satuan;
                    form.querySelector('#edit_stock').value = stok;
                });
            }
            
            const hapusModal = document.getElementById('hapusProdukModal');
            if(hapusModal) {
                hapusModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    const id = button.getAttribute('data-id');
                    const form = document.getElementById('hapusProdukForm');
                    form.action = `/produk/${id}`;
                });
            }
        });
    </script>
    --}}
</body>
@endsection
</html>

