<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Satuan</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome untuk Ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .card-header { background-color: #343a40; color: white; }
        .btn-primary { background-color: #007bff; border-color: #007bff; }
        .table thead { background-color: #e9ecef; }
        .pagination-reversed nav > div:first-child { flex-direction: row-reverse; }
    </style>
</head>

@extends('SideBar')
@section('title', 'Manajemen Satuan')
@section('content')

<body>
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Manajemen Satuan</h4>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahSatuanModal">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Satuan
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
                    <form action="{{ route('satuan.index') }}" method="GET">
                        <div class="row g-2">
                            <div class="col-md-8">
                                <div class="input-group">
                                    <input class="form-control" list="satuanOptions" name="search" placeholder="Ketik atau pilih nama satuan..." value="{{ request('search') }}">
                                    <datalist id="satuanOptions">
                                        @foreach ($satuanList as $item)
                                            <option value="{{ $item->nama_satuan }}">
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
                                <th scope="col">Nama Satuan</th>
                                <th scope="col" class="text-center">Is Active</th>
                                {{-- Untuk menampilkan kolom Aksi --}}
                                {{-- <th scope="col" class="text-center">Aksi</th>  --}}
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($satuan as $item)
                            <tr>
                                <td>{{ ($satuan->currentPage() - 1) * $satuan->perPage() + $loop->iteration }}</td>
                                <td>{{ $item->nama_satuan }}</td>
                                <td class="text-center">
                                    <a href="{{ route('satuan.toggleStatus', ['id' => $item->satuan_id]) }}" class="text-decoration-none">
                                        @if($item->is_active == 'yes')
                                            <span class="badge bg-success">Yes</span>
                                        @else
                                            <span class="badge bg-danger">No</span>
                                        @endif
                                    </a>
                                </td>
                                {{-- Cuntuk menampilkan tombol Edit & Hapus --}}
                                {{-- 
                                <td class="text-center">
                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editSatuanModal"
                                        data-id="{{ $item->satuan_id }}"
                                        data-nama="{{ $item->nama_satuan }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapusSatuanModal"
                                        data-id="{{ $item->satuan_id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                               --}}
                            </tr>
                            @empty
                            <tr>
                                
                                <td colspan="3" class="text-center">Data satuan tidak ditemukan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="pagination-reversed mt-3">
                    {!! $satuan->links('pagination::bootstrap-5') !!}
                </div>

            </div>
        </div>
    </div>

    
    <!-- Modal Tambah Satuan -->
    <div class="modal fade" id="tambahSatuanModal" tabindex="-1" aria-labelledby="tambahSatuanModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('satuan.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahSatuanModalLabel">Form Tambah Satuan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_satuan" class="form-label">Nama Satuan</label>
                             <input type="text" class="form-control @error('nama_satuan') is-invalid @enderror" id="nama_satuan" name="nama_satuan" value="{{ old('nama_satuan') }}" required>
                            @error('nama_satuan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="is_active" class="form-label">Status</label>
                            <select class="form-select" id="is_active" name="is_active" required>
                                <option value="yes" selected>Yes (Aktif)</option>
                                <option value="no">No (Tidak Aktif)</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Satuan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ini untuk mengaktifkan Modal Edit & Hapus --}}
    {{--
    <!-- Modal Edit Satuan -->
    <div class="modal fade" id="editSatuanModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editSatuanForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Form Edit Satuan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_nama_satuan" class="form-label">Nama Satuan</label>
                            <input type="text" class="form-control" id="edit_nama_satuan" name="nama_satuan" required>
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

    <!-- Modal Hapus Satuan -->
    <div class="modal fade" id="hapusSatuanModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="hapusSatuanForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h5 class="modal-title">Konfirmasi Hapus</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menghapus satuan ini?</p>
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
            var myModal = new bootstrap.Modal(document.getElementById('tambahSatuanModal'), {
                keyboard: false
            });
            myModal.show();
        </script>
    @endif

    {{--  untuk mengaktifkan JavaScript untuk Modal Edit & Hapus --}}
    {{--
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editModal = document.getElementById('editSatuanModal');
            if(editModal) {
                editModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    const id = button.getAttribute('data-id');
                    const nama = button.getAttribute('data-nama');
                    
                    const form = document.getElementById('editSatuanForm');
                    form.action = `/Satuan/${id}`;
                    form.querySelector('#edit_nama_satuan').value = nama;
                });
            }

            const hapusModal = document.getElementById('hapusSatuanModal');
            if(hapusModal) {
                hapusModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    const id = button.getAttribute('data-id');
                    const form = document.getElementById('hapusSatuanForm');
                    form.action = `/Satuan/${id}`;
                });
            }
        });
    </script>
     --}}
</body>
@endsection
</html>

