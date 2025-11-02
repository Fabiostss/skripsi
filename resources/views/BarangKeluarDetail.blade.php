<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barang Keluar</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome untuk Ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
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
    </style>
</head>

@extends('SideBar')
@section('title', 'Barang Keluar')
@section('content')
<body>
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header ">
            <h5 class="mb-0">Detail Barang Keluar</h5>
        </div>
        <div class="card-body">
            <h6 class="fw-bold mb-3">Informasi Transaksi</h6>
            <table class="table table-bordered">
                <tr>
                    <th width="25%">ID Transaksi</th>
                    <td>{{ $header->transaksi_keluar_id }}</td>
                </tr>
                <tr>
                    <th>Tanggal Keluar</th>
                    <td>{{ $header->tanggal_keluar }}</td>
                </tr>
               
                <tr>
                    <th>User</th>
                    <td>{{ $header->user_name }}</td>
                </tr>
                <tr>
                    <th>Keterangan</th>
                    <td>{{ $header->keterangan ?? '-' }}</td>
                </tr>
            </table>

            <h6 class="fw-bold mt-4 mb-3">Detail Produk</h6>
            <table class="table table-striped table-bordered">
                <thead class="table-secondary">
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($details as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->nama_produk }}</td>
                            <td>{{ $item->jumlah }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">Tidak ada data produk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <a href="{{ url('/barang-keluar') }}" class="btn btn-secondary mt-3">
                Kembali
            </a>
        </div>
    </div>
</div>
</body>
@endsection
</html>

