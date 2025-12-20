<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MonitoringController extends Controller
{
    
    public function index()
    {
        
        $data = DB::table('master_produk as mp')
            ->leftJoin('rop as r', function ($join) {
                $join->on('mp.produk_id', '=', 'r.produk_id')
                     ->whereRaw('r.tanggal = (select max(tanggal) from rop where produk_id = mp.produk_id)');
            })
            ->where('mp.is_active', 'yes')
            ->select(
                'mp.produk_id',
                'mp.nama_produk',
                'mp.stock as stok', 
                'r.rop'
            )
            ->orderBy('mp.produk_id', 'desc')
            ->get();

        // Mengirim data ke view
        return view('Monitoring', compact('data'));
    }
}
