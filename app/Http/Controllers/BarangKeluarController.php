<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BarangKeluarController extends Controller
{
    /**
     * Menampilkan form input dan riwayat barang keluar dalam satu halaman.
     */
    public function index(Request $request) // Tambahkan Request $request
    {
        try {
            // Data untuk form transaksi utama (produk aktif dengan stok > 0)
            $productsForForm = DB::table('master_produk')
                ->where('stock', '>', 0)
                ->where('is_active', 'yes')
                ->orderBy('nama_produk', 'asc')->get();

            // Data HANYA untuk form filter (produk yang pernah ada di transaksi keluar)
            $productsForFilter = DB::table('detail_barang_keluar as dbk')
                                ->join('master_produk as mp', 'dbk.produk_id', '=', 'mp.produk_id')
                                ->select('mp.nama_produk')
                                ->distinct()
                                ->orderBy('mp.nama_produk', 'asc')
                                ->get();

            // Memulai query builder untuk riwayat
            $historyQuery = DB::table('barang_keluar as bk')
                ->join('detail_barang_keluar as dbk', 'bk.transaksi_keluar_id', '=', 'dbk.transaksi_keluar_id') // dikomen jika ada mau ubahhh
                ->join('master_produk as mp', 'dbk.produk_id', '=', 'mp.produk_id')  // comand kalo kalo mau ubah
                ->join('users', 'bk.user_id', '=', 'users.user_id')
                ->select(
                    'bk.tanggal_keluar',
                    'mp.nama_produk', //comand kalo kalo mau ubah
                    'dbk.jumlah', //comand kalo kalo mau ubah
                    'users.nama_lengkap as user_name',
                    'bk.keterangan',
                    'bk.transaksi_keluar_id'//dbk//
                );

            // Terapkan filter tanggal mulai jika ada
            if ($request->filled('tanggal_mulai')) {
                 $tanggalMulai = Carbon::createFromFormat('d-m-Y', $request->input('tanggal_mulai'))->format('Y-m-d');
                $historyQuery->whereDate('bk.tanggal_keluar', '>=', $tanggalMulai);
            }

            // Terapkan filter tanggal selesai jika ada
            if ($request->filled('tanggal_selesai')) {
                $tanggalSelesai = Carbon::createFromFormat('d-m-Y', $request->input('tanggal_selesai'))->format('Y-m-d');
                 $historyQuery->whereDate('bk.tanggal_keluar', '<=', $tanggalSelesai);
            }

            // Filter berdasarkan NAMA PRODUK (case-insensitive)
            if ($request->filled('nama_produk')) {
                $nama_produk_lower = strtolower($request->input('nama_produk'));
                $historyQuery->where(DB::raw('LOWER(mp.nama_produk)'), 'like', '%' . $nama_produk_lower . '%');
            }

            // Ambil data setelah semua filter diterapkan
            $history = $historyQuery->orderBy('bk.tanggal_keluar', 'desc')
                ->orderBy('bk.transaksi_keluar_id', 'desc')
                ->get();
            
            // Mengirim semua data yang diperlukan ke view
            return view('BarangKeluar', [
                'products' => $productsForForm,
                'productsForFilter' => $productsForFilter, // Kirim data baru ke view
                'history' => $history,
                'filters' => $request->only(['tanggal_mulai', 'tanggal_selesai', 'nama_produk'])
            ]);

        } catch (\Exception $e) {
            // Jika ada error, kembali ke dashboard dengan pesan yang jelas
            return redirect()->route('barang-keluar.index')->with('error', 'Gagal memuat halaman barang keluar: ' . $e->getMessage());
        }
    }
    

    /**
     * Menyimpan data transaksi barang keluar baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'keterangan' => 'nullable|string',
            'produk_id' => 'required|array|min:1',
            'produk_id.*' => 'required|exists:master_produk,produk_id',
            'jumlah' => 'required|array',
            'jumlah.*' => 'required|integer|min:1',
        ]);

        try {
            DB::transaction(function () use ($request) {
                // Validasi stok
                foreach ($request->produk_id as $key => $produkId) {
                    $jumlahDiminta = $request->jumlah[$key];
                    $produkDb = DB::table('master_produk')->where('produk_id', $produkId)->first();
                    
                    if (!$produkDb || $produkDb->stock < $jumlahDiminta) {
                        throw new \Exception("Stok untuk produk '{$produkDb->nama_produk}' tidak mencukupi. Sisa stok: {$produkDb->stock}.");
                    }
                }

                // Simpan ke tabel master 'barang_keluar'
                $transaksiId = DB::table('barang_keluar')->insertGetId([
                    'user_id' => Auth::id(),
                    'tanggal_keluar' => Carbon::now(),
                    'keterangan' => $request->keterangan,
                ]);

                // Simpan ke detail dan kurangi stok
                foreach ($request->produk_id as $key => $produkId) {
                    $jumlah = $request->jumlah[$key];
                    
                    DB::table('detail_barang_keluar')->insert([
                        'transaksi_keluar_id' => $transaksiId,
                        'produk_id' => $produkId,
                        'jumlah' => $jumlah,
                    ]);

                    DB::table('master_produk')->where('produk_id', $produkId)->decrement('stock', $jumlah);
                }
            });
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan transaksi: ' . $e->getMessage());
        }
        
        return redirect()->route('barang-keluar.index')->with('success', 'Transaksi barang keluar berhasil disimpan!');
    }
   public function detail($id){
    // Ambil data header transaksi (barang_keluar)
    $header = DB::table('barang_keluar as bk')
        // ->join('suppliers as s', 'bk.supplier_id', '=', 's.supplier_id')
        ->join('users', 'bk.user_id', '=', 'users.user_id')
        ->select(
            'bk.transaksi_keluar_id',
            'bk.tanggal_keluar',
            // 's.nama_supplier',
            'users.nama_lengkap as user_name',
            'bk.keterangan'
        )
        ->where('bk.transaksi_keluar_id', $id)
        ->first();

    // Ambil data detail (produk dan jumlah)
    $details = DB::table('detail_barang_keluar as dbk')
        ->join('master_produk as mp', 'dbk.produk_id', '=', 'mp.produk_id')
        ->select(
            'mp.nama_produk',
            'dbk.jumlah'
        )
        ->where('dbk.transaksi_keluar_id', $id)
        ->get();

    // Kirim ke view
    return view('BarangKeluarDetail', compact('header', 'details'));
}
}

