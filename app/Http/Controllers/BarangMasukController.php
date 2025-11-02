<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BarangMasukController extends Controller
{
    /**
     * Menampilkan halaman form input dan riwayat barang masuk.
     */
    public function index(Request $request)
    {
        try {
            // Data untuk form transaksi utama (semua master data aktif)
            $suppliersForForm = DB::table('suppliers')->where('is_active', 'yes')->orderBy('nama_supplier', 'asc')->get();
            $productsForForm = DB::table('master_produk')->where('is_active', 'yes')->orderBy('nama_produk', 'asc')->get();

            // Data HANYA untuk form filter (berdasarkan data yang ada di transaksi)
            $suppliersForFilter = DB::table('barang_masuk as bm')
                                ->join('suppliers as s', 'bm.supplier_id', '=', 's.supplier_id')
                                ->select('s.nama_supplier')
                                ->distinct()
                                ->orderBy('s.nama_supplier', 'asc')
                                ->get();
            
            // --- QUERY BARU UNTUK FILTER PRODUK ---
            $productsForFilter = DB::table('detail_barang_masuk as dbm')
                                ->join('master_produk as mp', 'dbm.produk_id', '=', 'mp.produk_id')
                                ->select('mp.nama_produk')
                                ->distinct()
                                ->orderBy('mp.nama_produk', 'asc')
                                ->get();

            // Memulai query builder untuk riwayat
            $historyQuery = DB::table('barang_masuk as bm')
                ->join('suppliers as s', 'bm.supplier_id', '=', 's.supplier_id')
                // ->join('detail_barang_masuk as dbm', 'bm.transaksi_masuk_id', '=', 'dbm.transaksi_masuk_id') // comand kalo kalo mau ubah
                // ->join('master_produk as mp', 'dbm.produk_id', '=', 'mp.produk_id') // comand kalo kalo mau ubah
                ->join('users', 'bm.user_id', '=', 'users.user_id')
                ->select(
                    'bm.tanggal_masuk',
                    's.nama_supplier',
                    // 'mp.nama_produk', // comand kalo kalo mau ubah
                    // 'dbm.jumlah', // comand kalo kalo mau ubah
                    'users.nama_lengkap as user_name',
                    'bm.keterangan',
                    'bm.transaksi_masuk_id'//dbm
                );
            
           if ($request->filled('tanggal_mulai')) {
                $tanggalMulai = Carbon::createFromFormat('d-m-Y', $request->input('tanggal_mulai'))->format('Y-m-d');
                $historyQuery->whereDate('bm.tanggal_masuk', '>=', $tanggalMulai);
            }

            if ($request->filled('tanggal_selesai')) {
                $tanggalSelesai = Carbon::createFromFormat('d-m-Y', $request->input('tanggal_selesai'))->format('Y-m-d');
                $historyQuery->whereDate('bm.tanggal_masuk', '<=', $tanggalSelesai);
            }
            
            if ($request->filled('nama_supplier')) {
                $nama_supplier_lower = strtolower($request->input('nama_supplier'));
                $historyQuery->where(DB::raw('LOWER(s.nama_supplier)'), 'like', '%' . $nama_supplier_lower . '%');
            }

            if ($request->filled('nama_produk')) {
                $nama_produk_lower = strtolower($request->input('nama_produk'));
                $historyQuery->where(DB::raw('LOWER(mp.nama_produk)'), 'like', '%' . $nama_produk_lower . '%');
            }

            $history = $historyQuery->orderBy('bm.tanggal_masuk', 'desc')
                ->orderBy('bm.transaksi_masuk_id', 'desc')
                ->get();
            
            return view('BarangMasuk', [
                'suppliers' => $suppliersForForm,
                'products' => $productsForForm,
                'suppliersForFilter' => $suppliersForFilter,
                'productsForFilter' => $productsForFilter, // Kirim data baru ke view
                'history' => $history,
                'filters' => $request->only(['tanggal_mulai', 'tanggal_selesai', 'nama_produk', 'nama_supplier'])
            ]);
        } catch (\Exception $e) {
             return redirect('/')->with('error', 'Gagal memuat halaman barang masuk: ' . $e->getMessage());
        }
    }

    /**
     * Menyimpan data transaksi barang masuk baru.
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'supplier_id' => 'required|exists:suppliers,supplier_id',
        //     'keterangan' => 'nullable|string',
        //     'produk_id' => 'required|array',
        //     'produk_id.*' => 'required|exists:master_produk,produk_id',
        //     'jumlah' => 'required|array',
        //     'jumlah.*' => 'required|integer|min:1',
        // ]);
      
        // try {
        //     DB::transaction(function () use ($request) {
        //         $transaksiId = DB::table('barang_masuk')->insertGetId([
        //             'supplier_id' => $request->supplier_id,
        //             'user_id' => Auth::id(),
        //             'tanggal_masuk' => Carbon::now(),
        //             'keterangan' => $request->keterangan,
        //         ]);

        //         foreach ($request->produk_id as $key => $produkId) {
        //             $jumlah = $request->jumlah[$key];
        //             DB::table('detail_barang_masuk')->insert([
        //                 'transaksi_masuk_id' => $transaksiId,
        //                 'produk_id' => $produkId,
        //                 'jumlah' => $jumlah,
        //             ]);

        //             DB::table('master_produk')->where('produk_id', $produkId)->increment('stock', $jumlah);
        //         }
        //     });
        // } catch (\Exception $e) {
        //     return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan transaksi: ' . $e->getMessage());
        // }
        
        // return redirect()->route('barang-masuk.index')->with('success', 'Transaksi barang masuk berhasil disimpan!');

        return $request;
    }
    
    public function detail($id){
    // Ambil data header transaksi (barang_masuk)
    $header = DB::table('barang_masuk as bm')
        ->join('suppliers as s', 'bm.supplier_id', '=', 's.supplier_id')
        ->join('users', 'bm.user_id', '=', 'users.user_id')
        ->select(
            'bm.transaksi_masuk_id',
            'bm.tanggal_masuk',
            's.nama_supplier',
            'users.nama_lengkap as user_name',
            'bm.keterangan'
        )
        ->where('bm.transaksi_masuk_id', $id)
        ->first();

    // Ambil data detail (produk dan jumlah)
    $details = DB::table('detail_barang_masuk as dbm')
        ->join('master_produk as mp', 'dbm.produk_id', '=', 'mp.produk_id')
        ->select(
            'mp.nama_produk',
            'dbm.jumlah'
        )
        ->where('dbm.transaksi_masuk_id', $id)
        ->get();

    // Kirim ke view
    return view('BarangMasukDetail', compact('header', 'details'));
}




}

