<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Supplier</title>
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
    @section('title', 'Manajemen Supplier')
    @section('content')
<body>
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Manajemen Supplier</h4>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#tambahSupplierModal">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Supplier
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
                    <div class="alert alert-danger alert-dismissible fade show">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="mb-3">
                    <form action="{{ route('supplier.index') }}" method="GET">
                        <div class="row g-2">
                            <div class="col-md-8">
                                <div class="input-group">
                                    <input class="form-control" list="supplierOptions" name="search" placeholder="Ketik atau pilih nama supplier..." value="{{ request('search') }}">
                                    <datalist id="supplierOptions">
                                        @foreach ($supplierList as $item)
                                            <option value="{{ $item->nama_supplier }}">
                                        @endforeach
                                    </datalist>
                                    <button class="btn btn-outline-secondary" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
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
                                <th scope="col">Nama Supplier</th>
                                <th scope="col">Nomor Telepon</th>
                                <th scope="col">Alamat</th>
                                <th scope="col" class="text-center">Is Active</th>
                                {{--  untuk menampilkan kolom Aksi --}}
                                {{--<th scope="col" class="text-center">Aksi</th>    --}}
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($supplier as $item)
                            <tr>
                                <td class="text-center">
                                    {{ ($supplier->currentPage() - 1) * $supplier->perPage() + $loop->iteration }}
                                </td>
                                <td>{{ $item->nama_supplier }}</td>
                                <td>{{ $item->nomor_telepon }}</td>
                                <td>{{ $item->alamat }}</td>
                                <td class="text-center">
                                    <a href="{{ route('supplier.toggleStatus', ['id' => $item->supplier_id]) }}" class="text-decoration-none">
                                        @if($item->is_active == 'yes')
                                            <span class="badge bg-success">Yes</span>
                                        @else
                                            <span class="badge bg-danger">No</span>
                                        @endif
                                    </a>
                                </td>
                                {{-- CATATAN UNTUK UJIAN: Buka komentar di bawah ini untuk menampilkan tombol Edit & Hapus --}}
                                {{--
                                <td class="text-center">
                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editSupplierModal"
                                        data-id="{{ $item->supplier_id }}"
                                        data-nama="{{ $item->nama_supplier }}"
                                        data-telepon="{{ $item->nomor_telepon }}"
                                        data-alamat="{{ $item->alamat }}"
                                        data-status="{{ $item->is_active }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapusSupplierModal"
                                        data-id="{{ $item->supplier_id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                                --}}
                            </tr>
                            @empty
                            <tr>
                                {{-- Jika kolom Aksi diaktifkan, ganti colspan menjadi "6" --}}
                                <td colspan="5" class="text-center">Data supplier tidak ditemukan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="pagination-reversed mt-3">
                    {!! $supplier->links('pagination::bootstrap-5') !!}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Supplier -->
    <div class="modal fade" id="tambahSupplierModal" tabindex="-1" aria-labelledby="tambahSupplierModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('supplier.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahSupplierModalLabel">Form Tambah Supplier Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_supplier" class="form-label">Nama Supplier</label>
                        <input type="text" class="form-control @error('nama_supplier') is-invalid @enderror" id="nama_supplier" name="nama_supplier" value="{{ old('nama_supplier') }}" required>
                        @error('nama_supplier')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="nomor_telepon" class="form-label">Nomor Telepon</label>
                        <input type="text" class="form-control @error('nomor_telepon') is-invalid @enderror" id="nomor_telepon" name="nomor_telepon" value="{{ old('nomor_telepon') }}" required>
                         @error('nomor_telepon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3" required>{{ old('alamat') }}</textarea>
                         @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="is_active" class="form-label">Status</label>
                        <select class="form-select @error('is_active') is-invalid @enderror" id="is_active" name="is_active" required>
                            <option value="yes" {{ old('is_active') == 'yes' ? 'selected' : '' }}>Aktif (Yes)</option>
                            <option value="no" {{ old('is_active') == 'no' ? 'selected' : '' }}>Tidak Aktif (No)</option>
                        </select>
                         @error('is_active')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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
        
  


    {{--  di bawah ini untuk mengaktifkan Modal Edit & Hapus --}}
    
    <!-- Modal Edit Supplier -->
     {{--
    <div class="modal fade" id="editSupplierModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editSupplierForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Form Edit Supplier</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_nama_supplier" class="form-label">Nama Supplier</label>
                            <input type="text" class="form-control" id="edit_nama_supplier" name="nama_supplier" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_nomor_telepon" class="form-label">Nomor Telepon</label>
                            <input type="text" class="form-control" id="edit_nomor_telepon" name="nomor_telepon" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_alamat" class="form-label">Alamat</label>
                            <textarea class="form-control" id="edit_alamat" name="alamat" rows="3" required></textarea>
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

    <!-- Modal Hapus Supplier -->
    <div class="modal fade" id="hapusSupplierModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="hapusSupplierForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h5 class="modal-title">Konfirmasi Hapus</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menghapus supplier ini?</p>
                        <strong>Peringatan:</strong> Tindakan ini tidak dapat dibatalkan.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
     {{-- --}}

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @if ($errors->any())
        <script>
            var myModal = new bootstrap.Modal(document.getElementById('tambahSupplierModal'), { keyboard: false });
            myModal.show();
        </script>
    @endif

    {{-- bawah ini untuk mengaktifkan JavaScript untuk Modal Edit & Hapus --}}
    {{--
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Logika untuk Modal Edit
            const editModal = document.getElementById('editSupplierModal');
            if(editModal) {
                editModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    const id = button.getAttribute('data-id');
                    const nama = button.getAttribute('data-nama');
                    const telepon = button.getAttribute('data-telepon');
                    const alamat = button.getAttribute('data-alamat');
                    const status = button.getAttribute('data-status');
                    
                    const form = document.getElementById('editSupplierForm');
                    form.action = `/Supplier/${id}`; // Mengatur action form

                    form.querySelector('#edit_nama_supplier').value = nama;
                    form.querySelector('#edit_nomor_telepon').value = telepon;
                    form.querySelector('#edit_alamat').value = alamat;
                    form.querySelector('#edit_is_active').value = status; 
                });
            }

            // Logika untuk Modal Hapus
            const hapusModal = document.getElementById('hapusSupplierModal');
            if(hapusModal) {
                hapusModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    const id = button.getAttribute('data-id');

                    const form = document.getElementById('hapusSupplierForm');
                    form.action = `/Supplier/${id}`; // Mengatur action form
                });
            }
        });
    </script>
       --}}
</body>
@endsection
</html>

