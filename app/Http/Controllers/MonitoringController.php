<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MonitoringController extends Controller
{
    /**
     * Menampilkan halaman Laporan Stok & ROP.
     */
    public function index()
    {
        // Query ini mengambil semua produk dan menggabungkannya dengan data ROP terbaru
        // untuk setiap produk (berdasarkan tanggal paling akhir).
        $data = DB::table('master_produk as mp')
            ->leftJoin('rop as r', function ($join) {
                $join->on('mp.produk_id', '=', 'r.produk_id')
                     ->whereRaw('r.tanggal = (select max(tanggal) from rop where produk_id = mp.produk_id)');
            })
            ->where('mp.is_active', 'yes')
            ->select(
                'mp.produk_id',
                'mp.nama_produk',
                'mp.stock as stok', // Menggunakan alias 'stok' agar konsisten
                'r.rop'
            )
            ->orderBy('mp.nama_produk', 'desc')
            ->get();

        // Mengirim data ke view
        return view('Monitoring', compact('data'));
    }
}
