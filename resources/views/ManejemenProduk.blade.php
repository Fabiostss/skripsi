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
        
        .table img {
            max-width: 50px;
            max-height: 50px;
            object-fit: cover;
            border-radius: 4px;
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

                {{-- PENCARIAN DAN FILTER --}}
                <form action="{{ route('produk.index') }}" method="GET" class="mb-4 p-3 border rounded bg-light">
                    <div class="row g-2">
                        <div class="col-md-12">
                            <label for="search" class="form-label small">Nama Produk</label>
                            <input type="text" class="form-control form-control-sm" id="search" name="search" placeholder="Cari atau pilih Nama Produk..." value="{{ request('search') }}" list="productListOptions">
                            <datalist id="productListOptions">
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
                                <th class="text-center">No</th>
                                <th>Nama Produk</th>
                                <th>Kategori</th>
                                <th>Tipe</th>
                                <th>Bahan</th>
                                <th>Satuan</th>
                                <th style="width: 100px;">Deskripsi</th> 
                                <th class="text-center">Gambar</th> 
                                <th class="text-center">Stok</th>
                                <th class="text-center">Is Active</th>
                                {{-- <th class="text-center">Aksi</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                            <tr>
                                <td class="text-center">{{ ($products->currentPage() - 1) * $products->perPage() + $loop->iteration }}</td>
                                <td>{{ $product->nama_produk }}</td>
                                <td>{{ $product->nama_kategori }}</td>
                                <td>{{ $product->nama_tipe }}</td>
                                <td>{{ $product->nama_bahan }}</td>
                                <td>{{ $product->nama_satuan }}</td>
                                <td>{{ $product->deskripsi }}</td> 
                                
                                <td class="text-center">
                                    @if ($product->gambar)
                                        <a href="{{ asset('/' . $product->gambar) }}" target="_blank">
                                            {{-- asset() akan mengarah ke public/GambarDiunggah/nama_file.jpg --}}
                                            <img src="{{ asset('GambarDiunggah/' . $product->gambar) }}" alt="Img Produk">
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
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
                               
                            </tr>
                            @empty
                            <tr>
                                
                                <td colspan="10" class="text-center">Data produk tidak ditemukan.</td> 
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="pagination-reversed mt-3">
                    {!! $products->links('pagination::bootstrap-5') !!}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="tambahProdukModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
            
            <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data"> 
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Produk Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="nama_produk" class="form-label">Nama Produk</label>
                            <input type="text" class="form-control" id="nama_produk" name="nama_produk" required value="{{ old('nama_produk') }}">
                            @error('nama_produk')<div class="text-danger small">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="kategori_id" class="form-label">Kategori</label>
                            <select class="form-select" id="kategori_id" name="kategori_id" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($kategoriList as $k)
                                    <option value="{{ $k->kategori_id }}" {{ old('kategori_id') == $k->kategori_id ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                                @endforeach
                            </select>
                            @error('kategori_id')<div class="text-danger small">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tipe_id" class="form-label">Tipe</label>
                            <select class="form-select" id="tipe_id" name="tipe_id" required>
                                <option value="">-- Pilih Tipe --</option>
                                @foreach($tipeList as $t)
                                    <option value="{{ $t->tipe_id }}" {{ old('tipe_id') == $t->tipe_id ? 'selected' : '' }}>{{ $t->nama_tipe }}</option>
                                @endforeach
                            </select>
                            @error('tipe_id')<div class="text-danger small">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="bahan_id" class="form-label">Bahan</label>
                            <select class="form-select" id="bahan_id" name="bahan_id" required>
                                <option value="">-- Pilih Bahan --</option>
                                @foreach($bahanList as $b)
                                    <option value="{{ $b->bahan_id }}" {{ old('bahan_id') == $b->bahan_id ? 'selected' : '' }}>{{ $b->nama_bahan }}</option>
                                @endforeach
                            </select>
                            @error('bahan_id')<div class="text-danger small">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="satuan_id" class="form-label">Satuan</label>
                            <select class="form-select" id="satuan_id" name="satuan_id" required>
                                <option value="">-- Pilih Satuan --</option>
                                @foreach($satuanList as $s)
                                    <option value="{{ $s->satuan_id }}" {{ old('satuan_id') == $s->satuan_id ? 'selected' : '' }}>{{ $s->nama_satuan }}</option>
                                @endforeach
                            </select>
                            @error('satuan_id')<div class="text-danger small">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    {{--  DESKRIPSI --}}
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="deskripsi" class="form-label">Deskripsi (Maks. 100 Karakter)</label>
                            <input type="text" class="form-control" id="deskripsi" name="deskripsi" value="{{ old('deskripsi') }}">
                            @error('deskripsi')<div class="text-danger small">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    {{-- GAMBAR --}}
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="gambar" class="form-label">Gambar Produk (Max 2MB, JPG/PNG)</label>
                            
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                            @error('image')<div class="text-danger small">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="stock" class="form-label">Stok</label>
                            <input type="number" class="form-control" id="stock" name="stock" min="0" required value="{{ old('stock') }}">
                            @error('stock')<div class="text-danger small">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="is_active" class="form-label">Status</label>
                            <select class="form-select" id="is_active" name="is_active" required>
                                <option value="yes" {{ old('is_active') == 'yes' ? 'selected' : '' }}>Aktif</option>
                                <option value="no" {{ old('is_active') == 'no' ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                            @error('is_active')<div class="text-danger small">{{ $message }}</div>@enderror
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
    
   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
   
    @if ($errors->any())
        <script>
          
            var tambahProdukModalElement = document.getElementById('tambahProdukModal');
            if (tambahProdukModalElement) {
                var myModal = new bootstrap.Modal(tambahProdukModalElement, {
                    keyboard: false
                });
                myModal.show();
            }
        </script>
    @endif
</body>
@endsection
</html>