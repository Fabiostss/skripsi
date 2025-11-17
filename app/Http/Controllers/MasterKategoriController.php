<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MasterKategoriController extends Controller
{

    public function index(Request $request) // PERBAIKAN: Menambahkan Request $request
    { 
        try{
            //  untuk mengambil input pencarian dan filter dari URL
            $search = $request->input('search');
            $isActiveFilter = $request->input('is_active');

            //  query untuk mengambil daftar kategori untuk dropdown
            $kategoriList = DB::table('kategori')->orderBy('nama_kategori', 'asc')->get();

            // catataaan salah  gara2 langsung mengambil data tanpa memfilter.
            /*
            $kategori = DB::table('kategori')
                ->orderBy('kategori_id', 'desc')->paginate(10);
            */

            // 
            $query = DB::table('kategori');

            if ($search) {
                $query->where('nama_kategori', 'like', '%' . $search . '%');
            }

            if($isActiveFilter && in_array($isActiveFilter, ['yes', 'no'])){
                $query->where('is_active', $isActiveFilter);
            }
            

            $kategori = $query->orderBy('kategori_id', 'desc')->paginate(10);
            
            $kategori->appends($request->all());

            return view('ManejemenKategori',[
                'kategori' => $kategori,
                'kategoriList' => $kategoriList // Mengirim variabel baru ke view
            ]);
        } 
        catch (\Exception $e) {
     
            Log::error("Error saat mengambil data kategori: " . $e->getMessage());
            return Redirect::back()->with('error', 'Gagal memuat data kategori.');
        }
    }

    public function store(Request $request){
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori,nama_kategori',
            'deskripsi' => 'nullable|string',
            'is_active' => 'required|in:yes,no', 
        ]);

       
        try {
            DB::table('kategori')->insert([
                'nama_kategori' => $request->input('nama_kategori'),
                'deskripsi' => $request->input('deskripsi'),
                'is_active' => $request->input('is_active'), // KESALAHAN: Ini belum ada di insert Anda
            ]);
            return Redirect::back()->with('success', 'Kategori berhasil ditambahkan!');
        } catch (\Exception $e) {
            Log::error("Error saat menyimpan kategori: " . $e->getMessage());
            return Redirect::back()->with('error', 'Gagal menambahkan kategori.');
        }
    }

    // 
    public function toggleStatus($id)
    {
        try {
            $kategori = DB::table('kategori')->where('kategori_id', $id)->first();

            if ($kategori) {
                $newStatus = $kategori->is_active == 'yes' ? 'no' : 'yes';
                
                DB::table('kategori')
                    ->where('kategori_id', $id)
                    ->update(['is_active' => $newStatus]);
                
                return Redirect::back()->with('success', 'Status kategori berhasil diubah.');
            }
            return Redirect::back()->with('error', 'Kategori tidak ditemukan.');

        } catch (\Exception $e) {
            Log::error('Gagal mengubah status kategori: ' . $e->getMessage());
            return Redirect::back()->with('error', 'Gagal mengubah status kategori.');
        }
    }

      /*

    FITUR EDIT & DELETE 
    Route::put('/Kategori/{id}', [MasterKategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/Kategori/{id}', [MasterKategoriController::class, 'destroy'])->name('kategori.destroy');
    
    */

    /*
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => ['required', 'string', 'max:255', Rule::unique('kategori')->ignore($id, 'kategori_id')],
            'deskripsi' => 'nullable|string',
        ]);

        try {
            DB::table('kategori')
                ->where('kategori_id', $id)
                ->update([
                    'nama_kategori' => $request->nama_kategori,
                    'deskripsi' => $request->deskripsi,
                ]);

            return Redirect::route('kategori.index')->with('success', 'Kategori berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error("Error saat memperbarui kategori: " . $e->getMessage());
            return Redirect::back()->with('error', 'Gagal memperbarui kategori.');
        }
    }
    */

    /*
    public function destroy($id)
    {
        try {
            // Peringatan: Idealnya, periksa dulu apakah kategori ini terikat dengan data produk.
            $isUsed = DB::table('master_produk')->where('kategori_id', $id)->exists();
            if ($isUsed) {
                return Redirect::back()->with('error', 'Gagal menghapus kategori karena masih digunakan oleh produk lain.');
            }

            $deleted = DB::table('kategori')->where('kategori_id', $id)->delete();

            if ($deleted) {
                return Redirect::route('kategori.index')->with('success', 'Kategori berhasil dihapus.');
            }
            return Redirect::back()->with('error', 'Kategori tidak ditemukan.');

        } catch (\Exception $e) {
            Log::error("Error saat menghapus kategori: " . $e->getMessage());
            return Redirect::back()->with('error', 'Gagal menghapus kategori.');
        }
    }
    */
}

