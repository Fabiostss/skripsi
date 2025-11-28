<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MasterTipeController extends Controller
{
    
    public function index(Request $request) 
    {
        try {
            //  untuk menangani pencarian dan filter
            $search = $request->input('search');
            $isActiveFilter = $request->input('is_active');

            // Mengambil daftar lengkap semua tipe untuk dropdown pencarian
            $tipeList = DB::table('tipe')->orderBy('nama_tipe', 'asc')->get();

            $query = DB::table('tipe');

            // Jika ada input pencarian, filter data berdasarkan nama_tipe
            if ($search) {
                $query->where('nama_tipe', 'like', '%' . $search . '%');
            }

            //  filter data berdasarkan is_active
            if ($isActiveFilter && in_array($isActiveFilter, ['yes', 'no'])) {
                $query->where('is_active', $isActiveFilter);
            }

            //  paginasi pada data yang sudah difilter
            $tipe = $query->orderBy('tipe_id', 'desc')->paginate(10);
            
            // Memastikan parameter pencarian tetap ada saat berpindah halaman
            $tipe->appends($request->all());

            return view('ManejemenTipe', [
                'tipe' => $tipe,
                'tipeList' => $tipeList
            ]);

        } catch (\Exception $e) {
            Log::error("Error saat mengambil data tipe: " . $e->getMessage());
            return Redirect::back()->with('error', 'Terjadi kesalahan saat mengambil data tipe.');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_tipe' => 'required|string|max:255|unique:tipe,nama_tipe',
            'deskripsi' => 'nullable|string',
            'is_active' => 'required|in:yes,no',
        ]);

        try {
            DB::table('tipe')->insert([
                'nama_tipe' => $request->input('nama_tipe'),
                'deskripsi' => $request->input('deskripsi'),
                'is_active' => $request->input('is_active'),
            ]);
            return Redirect::back()->with('success', 'Tipe berhasil ditambahkan!');
        } catch (\Exception $e) {
            Log::error("Error saat menyimpan tipe: " . $e->getMessage());
            return Redirect::back()->with('error', 'Gagal menambahkan tipe.');
        }
    }

    public function toggleStatus($id)
    {
        try {
            $tipe = DB::table('tipe')->where('tipe_id', $id)->first();

            if ($tipe) {
                $newStatus = $tipe->is_active == 'yes' ? 'no' : 'yes';
                
                DB::table('tipe')
                    ->where('tipe_id', $id)
                    ->update(['is_active' => $newStatus]);
                
                return Redirect::back()->with('success', 'Status tipe berhasil diubah.');
            }
            return Redirect::back()->with('error', 'Tipe tidak ditemukan.');

        } catch (\Exception $e) {
            Log::error('Gagal mengubah status tipe: ' . $e->getMessage());
            return Redirect::back()->with('error', 'Gagal mengubah status tipe.');
        }
    }



     /*

    FITUR EDIT & DELETE 

    
     Route::put('/Tipe/{id}', [MasterTipeController::class, 'update'])->name('tipe.update');
     Route::delete('/Tipe/{id}', [MasterTipeController::class, 'destroy'])->name('tipe.destroy');
    
    */

    /*
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_tipe' => ['required', 'string', 'max:255', Rule::unique('tipe')->ignore($id, 'tipe_id')],
            'deskripsi' => 'nullable|string',
        ]);

        try {
            DB::table('tipe')
                ->where('tipe_id', $id)
                ->update([
                    'nama_tipe' => $request->nama_tipe,
                    'deskripsi' => $request->deskripsi,
                ]);

            return Redirect::route('tipe.index')->with('success', 'Tipe berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error("Error saat memperbarui tipe: " . $e->getMessage());
            return Redirect::back()->with('error', 'Gagal memperbarui tipe.');
        }
    }
    */

    /*
    public function destroy($id)
    {
        try {
            // Peringatan: Idealnya, periksa dulu apakah tipe ini terikat dengan data produk.
            $isUsed = DB::table('master_produk')->where('tipe_id', $id)->exists();
            if ($isUsed) {
                return Redirect::back()->with('error', 'Gagal menghapus tipe karena masih digunakan oleh produk lain.');
            }

            $deleted = DB::table('tipe')->where('tipe_id', $id)->delete();

            if ($deleted) {
                return Redirect::route('tipe.index')->with('success', 'Tipe berhasil dihapus.');
            }
            return Redirect::back()->with('error', 'Tipe tidak ditemukan.');

        } catch (\Exception $e) {
            Log::error("Error saat menghapus tipe: " . $e->getMessage());
            return Redirect::back()->with('error', 'Gagal menghapus tipe.');
        }
    }
    */
}

