<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;

class MasterProdukController extends Controller
{
    public function index(Request $request)
    {
        try {
            // Mengambil semua input filter dari URL
            $filters = $request->only(['search', 'kategori_id', 'tipe_id', 'bahan_id', 'satuan_id', 'is_active']);

            // Mengambil data master untuk dropdown filter (hanya yang aktif)
            $kategoriList = DB::table('kategori')->where('is_active', 'yes')->orderBy('nama_kategori', 'asc')->get();
            $tipeList = DB::table('tipe')->where('is_active', 'yes')->orderBy('nama_tipe', 'asc')->get();
            $bahanList = DB::table('bahan')->where('is_active', 'yes')->orderBy('nama_bahan', 'asc')->get();
            $satuanList = DB::table('satuan')->where('is_active', 'yes')->orderBy('nama_satuan', 'asc')->get();
              // Menambahkan productList untuk dropdown pencarian nama produk
            $productList = DB::table('master_produk')->orderBy('nama_produk', 'asc')->get();

            // Memulai query dengan semua join yang diperlukan
            $query = DB::table('master_produk as mp')
                ->join('kategori as k', 'mp.kategori_id', '=', 'k.kategori_id')
                ->join('tipe as t', 'mp.tipe_id', '=', 't.tipe_id')
                ->join('bahan as b', 'mp.bahan_id', '=', 'b.bahan_id')
                ->join('satuan as s', 'mp.satuan_id', '=', 's.satuan_id');

            // Menerapkan filter 
            foreach ($filters as $key => $value) {
                if ($value) {
                    if ($key == 'search') {
                        $query->where('mp.nama_produk', 'like', '%' . $value . '%');
                    } elseif ($key == 'is_active') {
                        $query->where('mp.is_active', $value);
                    } else {
                        $query->where('mp.' . $key, $value);
                    }
                }
            }

            $products = $query->select(
                    'mp.produk_id', // tooge ststus
                    'mp.nama_produk', 'k.nama_kategori', 't.nama_tipe',
                    'b.nama_bahan', 's.nama_satuan', 'mp.stock', 'mp.is_active'
                )
                ->orderBy('mp.produk_id', 'desc')
                ->paginate(10);

            $products->appends($request->all());

            return view('ManejemenProduk', [
                'products' => $products,
                'kategoriList' => $kategoriList,
                'tipeList' => $tipeList,
                'bahanList' => $bahanList,
                'satuanList' => $satuanList,
                 'productList' => $productList,
            ]);

        } catch (\Exception $e) {
            Log::error("Error saat memuat manajemen produk: " . $e->getMessage());
            return Redirect::back()->with('error', 'Gagal memuat halaman manajemen produk.');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255|unique:master_produk,nama_produk',
            'kategori_id' => 'required|exists:kategori,kategori_id',
            'tipe_id' => 'required|exists:tipe,tipe_id',
            'bahan_id' => 'required|exists:bahan,bahan_id',
            'satuan_id' => 'required|exists:satuan,satuan_id',
            'stock' => 'required|integer|min:0',
            'is_active' => 'required|in:yes,no',
           
        ]);

        try {
            DB::table('master_produk')->insert([
                'nama_produk' => $request->nama_produk,
                'kategori_id' => $request->kategori_id,
                'tipe_id' => $request->tipe_id,
                'bahan_id' => $request->bahan_id,
                'satuan_id' => $request->satuan_id,
                'stock' => $request->stock,
                'is_active' => $request->is_active,
                'deskripsi' => $request->deskripsi,
            ]);
            return Redirect::back()->with('success', 'Produk baru berhasil ditambahkan!');
        } catch (\Exception $e) {
            Log::error("Error saat menyimpan produk: " . $e->getMessage());
            return Redirect::back()->with('error', 'Gagal menambahkan produk baru.');
        }
    }

    /**
     * FUNGSI BARU: Untuk mengubah status is_active produk.
     */
    public function toggleStatus($id)
    {
        try {
            $produk = DB::table('master_produk')->where('produk_id', $id)->first();
            if ($produk) {
                $newStatus = $produk->is_active == 'yes' ? 'no' : 'yes';
                DB::table('master_produk')->where('produk_id', $id)->update(['is_active' => $newStatus]);
                return Redirect::back()->with('success', 'Status produk berhasil diubah.');
            }
            return Redirect::back()->with('error', 'Produk tidak ditemukan.');
        } catch (\Exception $e) {
            Log::error('Gagal mengubah status produk: ' . $e->getMessage());
            return Redirect::back()->with('error', 'Gagal mengubah status produk.');
        }
    }
      /*
  
    FITUR EDIT & DELETE
    
    Route::put('/produk/{id}', [MasterProdukController::class, 'update'])->name('produk.update');
    Route::delete('/produk/{id}', [MasterProdukController::class, 'destroy'])->name('produk.destroy');
    
    */

    /*
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_produk' => [
                'required', 'string', 'max:255',
                Rule::unique('master_produk')->where(function ($query) use ($request) {
                    return $query->where('kategori_id', $request->kategori_id)
                                 ->where('tipe_id', $request->tipe_id)
                                 ->where('bahan_id', $request->bahan_id)
                                 ->where('satuan_id', $request->satuan_id);
                })->ignore($id, 'produk_id'),
            ],
            'kategori_id' => 'required|exists:kategori,kategori_id',
            'tipe_id' => 'required|exists:tipe,tipe_id',
            'bahan_id' => 'required|exists:bahan,bahan_id',
            'satuan_id' => 'required|exists:satuan,satuan_id',
            'stock' => 'required|integer|min:0',
        ]);

        try {
            DB::table('master_produk')
                ->where('produk_id', $id)
                ->update([
                    'nama_produk' => $request->nama_produk,
                    'kategori_id' => $request->kategori_id,
                    'tipe_id' => $request->tipe_id,
                    'bahan_id' => $request->bahan_id,
                    'satuan_id' => $request->satuan_id,
                    'stock' => $request->stock,
                ]);

            return Redirect::route('produk.index')->with('success', 'Produk berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error("Error saat memperbarui produk: " . $e->getMessage());
            return Redirect::back()->with('error', 'Gagal memperbarui produk.');
        }
    }
    */

    /*
    public function destroy($id)
    {
        try {
            // Peringatan: Idealnya, periksa dulu apakah produk ini terikat dengan data transaksi.
            $isUsed = DB::table('detail_barang_masuk')->where('produk_id', $id)->exists() || 
                      DB::table('detail_barang_keluar')->where('produk_id', $id)->exists();

            if ($isUsed) {
                return Redirect::back()->with('error', 'Gagal menghapus produk karena sudah memiliki riwayat transaksi.');
            }
            
            $deleted = DB::table('master_produk')->where('produk_id', $id)->delete();

            if ($deleted) {
                return Redirect::route('produk.index')->with('success', 'Produk berhasil dihapus.');
            }
            return Redirect::back()->with('error', 'Produk tidak ditemukan.');

        } catch (\Exception $e) {
            Log::error("Error saat menghapus produk: " . $e->getMessage());
            return Redirect::back()->with('error', 'Gagal menghapus produk.');
        }
    }
    */
}

