<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen User</title>
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
@section('title', 'Manajemen User')
@section('content')

<body>
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Manajemen User</h4>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahUserModal">
                    <i class="fas fa-plus-circle me-2"></i>Tambah User
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
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Form Pencarian dan Filter --}}
                <div class="mb-3">
                    <form action="{{ route('user.index') }}" method="GET">
                        <div class="row g-2">
                            <div class="col-md-8">
                                <div class="input-group">
                                    <input class="form-control" list="userOptions" name="search" placeholder="Cari nama lengkap..." value="{{ request('search') }}">
                                    <datalist id="userOptions">
                                        @foreach ($userList as $item)
                                            <option value="{{ $item->nama_lengkap }}">
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
                                <th>No</th>
                                <th>Nama Lengkap</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Nomor Telepon</th>
                                <th class="text-center">Is Active</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $item)
                            <tr>
                                <td class="text-center">{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</td>
                                <td>{{ $item->nama_lengkap }}</td>
                                <td>{{ $item->username }}</td>
                                <td><span class="badge bg-secondary">{{ $item->role_name }}</span></td>
                                <td>{{ $item->nomor_telepon ?? '-' }}</td>
                                <td class="text-center">
                                    {{-- Badge status yang bisa diklik --}}
                                    <a href="{{ route('user.toggleStatus', ['id' => $item->user_id]) }}" class="text-decoration-none">
                                        @if($item->is_active == 'yes')
                                            <span class="badge bg-success">Yes</span>
                                        @else
                                            <span class="badge bg-danger">No</span>
                                        @endif
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">Data user tidak ditemukan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="pagination-reversed mt-3">{!! $users->links('pagination::bootstrap-5') !!}</div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah User -->
    <div class="modal fade" id="tambahUserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('user.store') }}" method="POST">
                    @csrf
                    <div class="modal-header"><h5 class="modal-title">Form Tambah User</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                    <div class="modal-body">
                        <div class="mb-3"><label class="form-label">Nama Lengkap</label><input type="text" class="form-control" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required></div>
                        <div class="mb-3"><label class="form-label">Username</label><input type="text" class="form-control" name="username" value="{{ old('username') }}" required></div>
                        <div class="mb-3"><label class="form-label">Role</label><select class="form-select" name="role_name" required><option value="admin" {{ old('role_name') == 'admin' ? 'selected' : '' }}>Admin</option><option value="owner" {{ old('role_name') == 'owner' ? 'selected' : '' }}>Owner</option></select></div>
                        <div class="mb-3"><label class="form-label">Nomor Telepon</label><input type="text" class="form-control" name="nomor_telepon" value="{{ old('nomor_telepon') }}" required></div>
                        <div class="mb-3"><label class="form-label">Password</label><input type="password" class="form-control" name="password" required></div>
                        <div class="mb-3"><label class="form-label">Konfirmasi Password</label><input type="password" class="form-control" name="password_confirmation" required></div>
                        <div class="mb-3"><label class="form-label">Status</label><select class="form-select" name="is_active" required><option value="yes" selected>Yes (Aktif)</option><option value="no">No (Tidak Aktif)</option></select></div>
                    </div>
                    <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary">Simpan User</button></div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @if ($errors->any())
        <script>
            var myModal = new bootstrap.Modal(document.getElementById('tambahUserModal'), { keyboard: false });
            myModal.show();
        </script>
    @endif
</body>
@endsection
</html>

