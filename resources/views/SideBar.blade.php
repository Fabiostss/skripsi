<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Inventori')</title>
    
  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        
        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            display: flex;
            background-color: #f8f9fa;
        }


        .sidebar {
            width: 280px;
            height: 100vh; 
            background-color: #212529;
            color: #adb5bd;
            position: fixed; 
            top: 0;
            left: 0;
            display: flex; 
            flex-direction: column; 
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
            flex-shrink: 0; 
        }


        .sidebar-menu-container {
            flex-grow: 1; 
            overflow-y: auto; 
            margin-top: 1rem;
            margin-bottom: 1rem;
        }

        
        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
     
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
            background-color: #0d6efd; 
            color: #fff;
            font-weight: bold;
        }

      
        .sidebar-footer {
            padding-top: 1rem;
            border-top: 1px solid #495057;
            flex-shrink: 0; 
        }
        .sidebar-footer a {
            color: #adb5bd;
            text-decoration: none;
        }
        .sidebar-footer a:hover {
            color: #fff;
        }

        
        .main-content {
            margin-left: 280px; 
            padding: 2rem;
            width: 100%;
        }
    </style>
    
   
    @stack('styles')
</head>
<body>
   
    <nav class="sidebar">
        <div class="sidebar-header">
            PT Dapur Sehat Keluarga
        </div>

   
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


    <main class="main-content">
        @yield('content')
    </main>
    
   
</body>
</html>


