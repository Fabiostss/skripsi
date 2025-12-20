
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Bahan</title>
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
@section('title', 'Manajemen Bahan')
@section('content')


<body>
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Manajemen Bahan</h4>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahBahanModal">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Bahan
                </button>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
               

                {{-- Notifikasi error validasi --}}
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

                <div class="mb-3">
                    <form action="{{ route('bahan.index') }}" method="GET">
                        <div class="row g-2">
                            <div class="col-md-8">
                                <div class="input-group">
                                    <input class="form-control" list="bahanOptions" name="search" placeholder="Cari nama bahan..." value="{{ request('search') }}">
                                    <datalist id="bahanOptions">
                                        @foreach ($bahanList as $item)
                                            <option value="{{ $item->nama_bahan }}">
                                        @endforeach
                                    </datalist>
                                    <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <select name="is_active" class="form-select" onchange="this.form.submit()">
                                    <option value="">Semua Status</option>
                                    <option value="yes" {{ request('is_active') == 'yes' ? 'selected' : '' }}>Aktif (Yes)</option>
                                    <option value="no" {{ request('is_active') == 'no' ? 'selected' : '' }}>Tidak Aktif (No)</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nama Bahan</th>
                                <th scope="col">Deskripsi</th>
                                <th scope="col" class="text-center">Is Active</th>
                               
                                {{-- <th scope="col" class="text-center">Aksi</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($bahan as $item)
                            <tr>
                                <td>{{ ($bahan->currentPage() - 1) * $bahan->perPage() + $loop->iteration }}</td>
                                <td>{{ $item->nama_bahan }}</td>
                                <td>{{ $item->deskripsi ?? '-' }}</td>
                                <td class="text-center">
                                    <a href="{{ route('bahan.toggleStatus', ['id' => $item->bahan_id]) }}" class="text-decoration-none">
                                        @if($item->is_active == 'yes')
                                            <span class="badge bg-success">Yes</span>
                                        @else
                                            <span class="badge bg-danger">No</span>
                                        @endif
                                    </a>
                                </td>
                                {{--  untuk  tombol Edit & Hapus --}}
                                {{--
                                <td class="text-center">
                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editBahanModal"
                                        data-id="{{ $item->bahan_id }}"
                                        data-nama="{{ $item->nama_bahan }}"
                                        data-deskripsi="{{ $item->deskripsi }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapusBahanModal"
                                        data-id="{{ $item->bahan_id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                                --}}
                            </tr>
                            @empty
                            <tr>
                                
                                <td colspan="4" class="text-center">Belum ada data bahan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="pagination-reversed mt-3">
                    {!! $bahan->links('pagination::bootstrap-5') !!}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Bahan -->
    <div class="modal fade" id="tambahBahanModal" tabindex="-1" aria-labelledby="tambahBahanModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('bahan.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahBahanModalLabel">Form Tambah Bahan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_bahan" class="form-label">Nama Bahan</label>
                            <input type="text" class="form-control @error('nama_bahan') is-invalid @enderror" id="nama_bahan" name="nama_bahan" value="{{ old('nama_bahan') }}" required>
                            @error('nama_bahan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
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
                        <button type="submit" class="btn btn-primary">Simpan Bahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{--  ini untuk mengaktifkan Modal Edit & Hapus --}}
    {{--
    <!-- Modal Edit Bahan -->
    <div class="modal fade" id="editBahanModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editBahanForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Form Edit Bahan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_nama_bahan" class="form-label">Nama Bahan</label>
                            <input type="text" class="form-control" id="edit_nama_bahan" name="nama_bahan" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="edit_deskripsi" name="deskripsi" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Hapus Bahan -->
    <div class="modal fade" id="hapusBahanModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="hapusBahanForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h5 class="modal-title">Konfirmasi Hapus</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menghapus bahan ini?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    --}}

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @if ($errors->any())
        <script>
            var myModal = new bootstrap.Modal(document.getElementById('tambahBahanModal'), {
                keyboard: false
            });
            myModal.show();
        </script>
    @endif

    {{-- ini untuk mengaktifkan JavaScript untuk Modal Edit & Hapus --}}
    {{--
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editModal = document.getElementById('editBahanModal');
            if(editModal) {
                editModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    const id = button.getAttribute('data-id');
                    const nama = button.getAttribute('data-nama');
                    const deskripsi = button.getAttribute('data-deskripsi');
                    
                    const form = document.getElementById('editBahanForm');
                    form.action = `/Bahan/${id}`;
                    form.querySelector('#edit_nama_bahan').value = nama;
                    form.querySelector('#edit_deskripsi').value = deskripsi;
                });
            }

            const hapusModal = document.getElementById('hapusBahanModal');
            if(hapusModal) {
                hapusModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    const id = button.getAttribute('data-id');
                    const form = document.getElementById('hapusBahanForm');
                    form.action = `/Bahan/${id}`;
                });
            }
        });
    </script>
    --}}
</body>
@endsection
</html>

