<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Tipe</title>
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
@section('title', 'Manajemen Tipe')
@section('content')

<body>
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Manajemen Tipe</h4>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahTipeModal">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Tipe
                </button>
            </div>
            <div class="card-body">
                @if(session('success'))
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


                 <div class="mb-3">
                    <form action="{{ route('tipe.index') }}" method="GET">
                        <div class="row g-2">
                            <div class="col-md-8">
                                <div class="input-group">
                                    <input class="form-control" list="tipeOptions" name="search" placeholder="Cari nama tipe..." value="{{ request('search') }}">
                                    <datalist id="tipeOptions">
                                        @foreach ($tipeList as $item)
                                            <option value="{{ $item->nama_tipe }}">
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
                                <th scope="col">Nama Tipe</th>
                                <th scope="col">Deskripsi</th>
                                <th scope="col" class="text-center">Is Active</th>
                              
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tipe as $item)
                            <tr>
                                {{-- pagination --}}
                                <td>{{ ($tipe->currentPage() - 1) * $tipe->perPage() + $loop->iteration }}</td>
                                <td>{{ $item->nama_tipe }}</td>
                                <td>{{ $item->deskripsi ?? '-' }}</td>
                                 <td class="text-center">
                                    <a href="{{ route('tipe.toggleStatus', ['id' => $item->tipe_id]) }}" class="text-decoration-none">
                                        @if($item->is_active == 'yes')
                                            <span class="badge bg-success">Yes</span>
                                        @else
                                            <span class="badge bg-danger">No</span>
                                        @endif
                                    </a>
                                </td>
                                {{-- notes: untuk menampilkan tombol Edit & Hapus --}}
                                {{--
                                <td class="text-center">
                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editTipeModal"
                                        data-id="{{ $item->tipe_id }}"
                                        data-nama="{{ $item->nama_tipe }}"
                                        data-deskripsi="{{ $item->deskripsi }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapusTipeModal"
                                        data-id="{{ $item->tipe_id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                                --}}
                            </tr>
                            @empty
                            <tr>
                                
                                <td colspan="4" class="text-center">Belum ada data tipe.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- pagination  --}}
                <div class="pagination-reversed mt-3">
                    {!! $tipe->links('pagination::bootstrap-5') !!}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Tipe -->
    <div class="modal fade" id="tambahTipeModal" tabindex="-1" aria-labelledby="tambahTipeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('tipe.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahTipeModalLabel">Form Tambah Tipe</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_tipe" class="form-label">Nama Tipe</label>
                            <input type="text" class="form-control @error('nama_tipe') is-invalid @enderror" id="nama_tipe" name="nama_tipe" value="{{ old('nama_tipe') }}" required>
                            @error('nama_tipe')
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
                        <button type="submit" class="btn btn-primary">Simpan Tipe</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- notes:untuk mengaktifkan Modal Edit & Hapus --}}
    {{--
    <!-- Modal Edit Tipe -->
    <div class="modal fade" id="editTipeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editTipeForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header"><h5 class="modal-title">Form Edit Tipe</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                    <div class="modal-body">
                        <div class="mb-3"><label for="edit_nama_tipe" class="form-label">Nama Tipe</label><input type="text" class="form-control" id="edit_nama_tipe" name="nama_tipe" required></div>
                        <div class="mb-3"><label for="edit_deskripsi" class="form-label">Deskripsi</label><textarea class="form-control" id="edit_deskripsi" name="deskripsi" rows="3"></textarea></div>
                    </div>
                    <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary">Simpan Perubahan</button></div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Hapus Tipe -->
    <div class="modal fade" id="hapusTipeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="hapusTipeForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header"><h5 class="modal-title">Konfirmasi Hapus</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                    <div class="modal-body"><p>Apakah Anda yakin ingin menghapus tipe ini?</p></div>
                    <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-danger">Ya, Hapus</button></div>
                </form>
            </div>
        </div>
    </div>
    --}}

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @if ($errors->any())
        <script>
            var myModal = new bootstrap.Modal(document.getElementById('tambahTipeModal'), {
                keyboard: false
            });
            myModal.show();
        </script>
    @endif
    
    {{-- notes: untuk mengaktifkan JavaScript untuk Modal Edit & Hapus --}}
    {{--
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editModal = document.getElementById('editTipeModal');
            if(editModal) {
                editModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    const id = button.getAttribute('data-id');
                    const nama = button.getAttribute('data-nama');
                    const deskripsi = button.getAttribute('data-deskripsi');
                    
                    const form = document.getElementById('editTipeForm');
                    form.action = `/Tipe/${id}`;
                    form.querySelector('#edit_nama_tipe').value = nama;
                    form.querySelector('#edit_deskripsi').value = deskripsi;
                });
            }

            const hapusModal = document.getElementById('hapusTipeModal');
            if(hapusModal) {
                hapusModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    const id = button.getAttribute('data-id');
                    const form = document.getElementById('hapusTipeForm');
                    form.action = `/Tipe/${id}`;
                });
            }
        });
    </script>
    --}}
</body>
@endsection
</html>

