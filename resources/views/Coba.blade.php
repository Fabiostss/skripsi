<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Kategori</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome untuk Ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
@section('title', 'Manajemen Kategori')
@section('content')

<body>
    <div class="container mt-5">
        <div class="card shadow-sm">

            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Manajemen Kategori</h4>
                
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahKategoriModal">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Kategori
                </button>
            </div>
            <div class="card-body">
                <!-- Notifikasi -->
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
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                           
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                   <!-- selesai  -->
                <form action="{{ route('kategori.index') }}" method="GET">
                    <div class="row g-2 mb-3">
                        <div class="col-md-8">
                            <div class="input-group">
                                <input type="text" name="search" list="KategoriOptions" class="form-control" placeholder="Cari nama kategori..." value="{{ $search ?? '' }}">
                                <datalist id="KategoriOptions">
                                        
                                    </datalist>

                                <button class="btn btn-outline-secondary" type="submit"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <select name="is_active" class="form-select" onchange="this.form.submit()">
                                <option value="semua" {{ ($status ?? 'semua') == 'semua' ? 'selected' : '' }}>Semua Status</option>
                                <option value="yes" {{ ($status ?? '') == 'yes' ? 'selected' : '' }}>Aktif</option>
                                <option value="no" {{ ($status ?? '') == 'no' ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nama Kategori</th>
                                <th scope="col">Deskripsi</th>
                                <th scope="col" class="text-center">Is Active</th>
                                {{--  kolom Aksi  --}}
                                {{-- <th scope="col" class="text-center">Aksi</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Menggunakan variabel $kategori sesuai dengan controller  --}}
                         
                            <tr>
                                {{-- Penomoran yang benar untuk paginasi --}}
                           
                                  
                                {{-- tombol Edit dan Hapus  --}}
                                {{--
                                <td class="text-center">
                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editKategoriModal"
                                        data-id="{{ $item->kategori_id }}"
                                        data-nama="{{ $item->nama_kategori }}"
                                        data-deskripsi="{{ $item->deskripsi }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapusKategoriModal"
                                        data-id="{{ $item->kategori_id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                                --}}
                            </tr>
                        
                            <tr>
                                {{-- kolom Aksi aktif, jdi colspan menjadi "4" --}}
                                <td colspan="3" class="text-center">Belum ada data kategori.</td>
                            </tr>
                            
                        </tbody>
                    </table>
                </div>
                <div class="pagination-reversed mt-3">
                    {!! ('pagination::bootstrap-5') !!}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Kategori -->
    <div class="modal fade" id="tambahKategoriModal" tabindex="-1" aria-labelledby="tambahKategoriModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                {{-- route bernama 'kategori.store' di web.php --}}
                <form action="{{ route('coba.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahKategoriModalLabel">Form Tambah Kategori</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    
                    <div class="modal-body">
                        {{--  error validasi --}}

                        <div class="mb-3">
                            <label for="nama_kategori" class="form-label">Nama Kategori</label>
                            <input type="text" class="form-control @error('nama_kategori') is-invalid @enderror" id="nama_kategori" name="nama_kategori" value="{{ old('nama_kategori') }}" required>
                            @error('nama_kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="is_active" required>
                                <option value="yes" selected>Yes (Aktif)</option>
                                <option value="no">No (Tidak Aktif)</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Kategori</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    {{-- untuk mengaktifkan Modal Edit & Hapus --}}
    {{--
    <!-- Modal Edit Kategori -->
    <div class="modal fade" id="editKategoriModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editKategoriForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header"><h5 class="modal-title">Form Edit Kategori</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                    <div class="modal-body">
                        <div class="mb-3"><label for="edit_nama_kategori" class="form-label">Nama Kategori</label><input type="text" class="form-control" id="edit_nama_kategori" name="nama_kategori" required></div>
                        <div class="mb-3"><label for="edit_deskripsi" class="form-label">Deskripsi</label><textarea class="form-control" id="edit_deskripsi" name="deskripsi" rows="3"></textarea></div>
                    </div>
                    <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary">Simpan Perubahan</button></div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Hapus Kategori -->
    <div class="modal fade" id="hapusKategoriModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="hapusKategoriForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header"><h5 class="modal-title">Konfirmasi Hapus</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                    <div class="modal-body"><p>Apakah Anda yakin ingin menghapus kategori ini?</p></div>
                    <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-danger">Ya, Hapus</button></div>
                </form>
            </div>
        </div>
    </div>
    --}}

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Script untuk tetap membuka modal jika ada error validasi --}}
    @if ($errors->any())
        <script>
            var myModal = new bootstrap.Modal(document.getElementById('tambahKategoriModal'), {
                keyboard: false
            });
            myModal.show();
        </script>
    @endif

    {{-- untuk mengaktifkan JavaScript untuk Modal Edit & Hapus --}}
    {{--
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editModal = document.getElementById('editKategoriModal');
            if(editModal) {
                editModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    const id = button.getAttribute('data-id');
                    const nama = button.getAttribute('data-nama');
                    const deskripsi = button.getAttribute('data-deskripsi');
                    
                    const form = document.getElementById('editKategoriForm');
                    form.action = `/Kategori/${id}`;
                    form.querySelector('#edit_nama_kategori').value = nama;
                    form.querySelector('#edit_deskripsi').value = deskripsi;
                });
            }

            const hapusModal = document.getElementById('hapusKategoriModal');
            if(hapusModal) {
                hapusModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    const id = button.getAttribute('data-id');
                    const form = document.getElementById('hapusKategoriForm');
                    form.action = `/Kategori/${id}`;
                });
            }
        });
    </script>
    --}}
</body>
@endsection
</html>

