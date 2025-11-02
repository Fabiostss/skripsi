<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Inventori')</title>
    
    {{-- Bootstrap CSS (jika Anda menggunakannya di halaman konten) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* CSS Reset dan Pengaturan Dasar */
        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            display: flex;
            background-color: #f8f9fa;
        }

        /* --- CSS UTAMA UNTUK SIDEBAR SCROLLABLE --- */

        /* 1. Wrapper utama sidebar */
        .sidebar {
            width: 280px;
            height: 100vh; /* Tinggi penuh layar */
            background-color: #212529;
            color: #adb5bd;
            position: fixed; /* Tetap di tempat saat di-scroll */
            top: 0;
            left: 0;
            display: flex; /* Mengaktifkan Flexbox */ /* <-- KUNCI PERUBAHAN */
            flex-direction: column; /* Mengatur item secara vertikal */ /* <-- KUNCI PERUBAHAN */
            padding: 1.5rem;
            box-sizing: border-box;
        }

        /* 2. Header Sidebar (tidak ikut scroll) */
        .sidebar-header {
            font-size: 1.5rem;
            font-weight: bold;
            color: #fff;
            padding-bottom: 1rem;
            border-bottom: 1px solid #495057;
            flex-shrink: 0; /* Mencegah header mengecil saat konten penuh */ /* <-- KUNCI PERUBAHAN */
        }

        /* 3. Container untuk menu (INI YANG AKAN SCROLL) */
        .sidebar-menu-container {
            flex-grow: 1; /* Mengambil semua sisa ruang vertikal */ /* <-- KUNCI PERUBAHAN */
            overflow-y: auto; /* Menampilkan scrollbar jika perlu */ /* <-- KUNCI PERUBAHAN */
            margin-top: 1rem;
            margin-bottom: 1rem;
        }

        /* 4. Daftar Menu di dalam container */
        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        /* Styling untuk item menu */
        .sidebar-menu-header {
            padding: 0.5rem 1rem;
            font-size: 0.8rem;
            color: #6c757d;
            text-transform: uppercase;
        }
        .sidebar-menu-item a {
            color: #adb5bd;
            text-decoration: none;
            display: block;
            padding: 0.8rem 1rem;
            border-radius: 0.25rem;
            margin-bottom: 0.5rem;
            transition: background-color 0.2s, color 0.2s;
        }
        .sidebar-menu-item a:hover {
            background-color: #343a40;
            color: #fff;
        }
        .sidebar-menu-item.active a {
            background-color: #0d6efd; /* Warna biru Bootstrap */
            color: #fff;
            font-weight: bold;
        }

        /* 5. Footer Sidebar (tidak ikut scroll) */
        .sidebar-footer {
            padding-top: 1rem;
            border-top: 1px solid #495057;
            flex-shrink: 0; /* Mencegah footer mengecil saat konten penuh */ /* <-- KUNCI PERUBAHAN */
        }
        .sidebar-footer a {
            color: #adb5bd;
            text-decoration: none;
        }
        .sidebar-footer a:hover {
            color: #fff;
        }

        /* --- CSS UNTUK KONTEN UTAMA --- */
        .main-content {
            margin-left: 280px; /* Memberi ruang selebar sidebar */
            padding: 2rem;
            width: 100%;
        }
    </style>
    
   
    @stack('styles')
</head>
<body>
    {{-- STRUKTUR HTML SIDEBAR --}}
    <nav class="sidebar">
        <div class="sidebar-header">
            PT Dapur Sehat Keluarga
        </div>

        {{-- Container ini ditambahkan untuk membungkus menu agar bisa scroll --}} 
        <div class="sidebar-menu-container">
            
        
            <ul class="sidebar-menu">

                 <li class="sidebar-menu-header">Laporan & Monitoring</li>
               
                 <li class="sidebar-menu-item {{ request()->is('Monitoring*') ? 'active' : '' }}">
                    <a href="{{ route('Monitoring.index') }}">Monitoring</a>
                </li>
                 <li class="sidebar-menu-item {{ request()->is('Laporan*') ? 'active' : '' }}">
                    <a href="{{ route('Laporan.index') }}">Laporan</a>
                </li>

               

                <li class="sidebar-menu-header">Transaksi</li>
                <li class="sidebar-menu-item {{ request()->is('barang-masuk*') ? 'active' : '' }}">
                    <a href="{{ route('barang-masuk.index') }}">Barang Masuk</a>
                </li>
                <li class="sidebar-menu-item {{ request()->is('barang-keluar*') ? 'active' : ''}}">
                    <a href="{{ route('barang-keluar.index') }}">Barang Keluar</a>
                </li>
    
                <li class="sidebar-menu-header">Analisa ROP</li>
                <li class="sidebar-menu-item {{ request()->is('rop*') ? 'active' : '' }}">
                    <a href="{{ route('rop.index') }}">ROP</a>
                </li>
    
                <li class="sidebar-menu-header">Master Data</li>
                <li class="sidebar-menu-item {{ request()->is('Produk*') ? 'active' : '' }}">
                    <a href="{{ route('produk.index') }}">Manajemen Produk</a>
                </li>
                <li class="sidebar-menu-item {{ request()->is('Kategori*') ? 'active' : '' }}">
                    <a href="{{ route('kategori.index') }}">Manajemen Kategori</a>
                </li>
                <li class="sidebar-menu-item {{ request()->is('Tipe*') ? 'active' : '' }}">
                    <a href="{{ route('tipe.index') }}">Manajemen Tipe</a>
                </li>
                 <li class="sidebar-menu-item {{ request()->is('Bahan*') ? 'active' : '' }}">
                    <a href="{{ route('bahan.index') }}">Manajemen Bahan</a>
                </li>
                <li class="sidebar-menu-item {{ request()->is('Satuan*') ? 'active' : '' }}">
                    <a href="{{ route('satuan.index') }}">Manajemen Satuan</a>
                </li>
                <li class="sidebar-menu-item {{ request()->is('Supplier*') ? 'active' : '' }}">
                    <a href="{{ route('supplier.index') }}">Manajemen Supplier</a>
                </li>
                <li class="sidebar-menu-item {{ request()->is('User*') ? 'active' : '' }}">
                    <a href="{{ route('user.index') }}">Manajemen User</a>
                </li>
            </ul>
        </div>

        <div class="sidebar-footer">
            <strong>{{ Auth::user()->role_name ?? 'Guest' }}</strong><br>
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </nav>

    {{-- KONTEN UTAMA HALAMAN --}}
    <main class="main-content">
        @yield('content')
    </main>
    
   
</body>
</html>


