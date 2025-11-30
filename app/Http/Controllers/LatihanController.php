<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LatihanController extends Controller
{

    public function index(Request $request) 
    { 
        try{
           
          

            //  query untuk mengambil daftar kategori untuk dropdown
            $tes = DB::table('tes')->orderBy('tes_id', 'asc')->get();


            return view('Manejementes',[
                'teds' => $tes,
               
            ]);
        } 
        catch (\Exception $e) {
     
            Log::error("Error saat mengambil data tes: " . $e->getMessage());
            return Redirect::back()->with('error', 'Gagal memuat data tes.');
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
                'is_active' => $request->input('is_active'), 
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

