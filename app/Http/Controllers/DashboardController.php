<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. KPI Box: Total Produk
        $totalProduk = DB::table('master_produk')->count();

        // 2. KPI Box: Total Supplier (Nama tabel diperbarui)
        $totalSupplier = DB::table('suppliers')->count(); 

        // 3. KPI Box: Produk Kritis (Stok <= ROP)
        // --- PERBAIKAN DI SINI ---
        // Query ini diubah agar HANYA mengambil ROP TERBARU untuk setiap produk
        
        // 1. Buat subquery untuk mendapatkan rop_id terbaru (tertinggi) untuk setiap produk_id
        $latestRop = DB::table('rop')
                       ->select('produk_id', DB::raw('MAX(rop_id) as max_rop_id'))
                       ->groupBy('produk_id');

        // 2. Gabungkan master_produk dengan ROP terbaru
        $produkKritis = DB::table('master_produk as mp')
            ->joinSub($latestRop, 'latest_r', function ($join) {
                // Join master_produk dengan subquery (produk_id -> produk_id)
                $join->on('mp.produk_id', '=', 'latest_r.produk_id');
            })
            ->join('rop as r', function ($join) {
                // Join hasil di atas dengan tabel rop (max_rop_id -> rop_id)
                $join->on('latest_r.max_rop_id', '=', 'r.rop_id');
            })
            ->whereRaw('mp.stock <= r.rop AND r.rop > 0') // Kondisi WHERE tetap sama
            ->count();
        // --- AKHIR PERBAIKAN ---

        // 4. KPI Box: Total Nilai Aset (DIHAPUS KARENA TIDAK ADA HARGA)
        
        // 5. KPI Box: Transaksi Hari Ini
        $transaksiMasukHariIni = DB::table('barang_masuk')
            ->whereDate('tanggal_masuk', Carbon::today())
            ->count();
            
        $transaksiKeluarHariIni = DB::table('barang_keluar')
            ->whereDate('tanggal_keluar', Carbon::today())
            ->count();

        // 6. Tabel Top 5: Produk Paling Banyak Keluar (Bulan Ini)
        $topProdukKeluar = DB::table('detail_barang_keluar as dbk')
            ->join('barang_keluar as bk', 'dbk.transaksi_keluar_id', '=', 'bk.transaksi_keluar_id')
            ->join('master_produk as mp', 'dbk.produk_id', '=', 'mp.produk_id')
            ->select('mp.nama_produk', DB::raw('SUM(dbk.jumlah) as total_keluar'))
            ->whereMonth('bk.tanggal_keluar', Carbon::now()->month)
            ->whereYear('bk.tanggal_keluar', Carbon::now()->year)
            ->groupBy('mp.produk_id', 'mp.nama_produk')
            ->orderByDesc('total_keluar')
            ->limit(5)
            ->get();

        // 7. Tabel Top 5: Produk Paling Banyak Masuk (Bulan Ini)
        $topProdukMasuk = DB::table('detail_barang_masuk as dbm')
            ->join('barang_masuk as bm', 'dbm.transaksi_masuk_id', '=', 'bm.transaksi_masuk_id')
            ->join('master_produk as mp', 'dbm.produk_id', '=', 'mp.produk_id')
            ->select('mp.nama_produk', DB::raw('SUM(dbm.jumlah) as total_masuk'))
            ->whereMonth('bm.tanggal_masuk', Carbon::now()->month)
            ->whereYear('bm.tanggal_masuk', Carbon::now()->year)
            ->groupBy('mp.produk_id', 'mp.nama_produk')
            ->orderByDesc('total_masuk')
            ->limit(5)
            ->get();

        // Kirim semua data ke view (totalNilaiAset dihapus)
        return view('Dashboard', compact(
            'totalProduk',
            'totalSupplier',
            'produkKritis',
            'transaksiMasukHariIni',
            'transaksiKeluarHariIni',
            'topProdukKeluar',
            'topProdukMasuk'
        ));
    }
}



