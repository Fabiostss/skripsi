<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MasterBahanController extends Controller
{
    public function index(Request $request) 
    { 
        try{
            $search = $request->input('search');
            $isActiveFilter = $request->input('is_active');

            $bahanList = DB::table('bahan')->orderBy('nama_bahan', 'asc')->get();

            $query = DB::table('bahan');

            if ($search) {
                $query->where('nama_bahan', 'like', '%' . $search . '%');
            }

            if($isActiveFilter && in_array($isActiveFilter, ['yes', 'no'])){
                $query->where('is_active', $isActiveFilter);
            }

            // Mengurutkan berdasarkan nama 
            $bahan = $query->orderBy('bahan_id', 'desc')->paginate(10);
            
            $bahan->appends($request->all());

            return view('ManejemenBahan',[
                'bahan' => $bahan,
                'bahanList' => $bahanList
            ]);
        } 
        catch (\Exception $e) {
          
            Log::error("Error saat mengambil data bahan: " . $e->getMessage());
            return Redirect::back()->with('error', 'Gagal memuat data bahan.');
        }
    }

    public function store(Request $request){
        $request->validate([
            'nama_bahan' => 'required|string|max:255|unique:bahan,nama_bahan',
            'deskripsi' => 'nullable|string',
            'is_active' => 'required|in:yes,no',
        ]);

        
        try {
            DB::table('bahan')->insert([
                'nama_bahan' => $request->input('nama_bahan'),
                'deskripsi' => $request->input('deskripsi'),
                'is_active' => $request->input('is_active'),
            ]);
            return Redirect::back()->with('success', 'Bahan berhasil ditambahkan!');
        } catch (\Exception $e) {
            Log::error("Error saat menyimpan bahan: " . $e->getMessage());
            return Redirect::back()->with('error', 'Gagal menambahkan bahan.');
        }
    }

    public function toggleStatus($id)
    {
        try {
            $bahan = DB::table('bahan')->where('bahan_id', $id)->first();

            if ($bahan) {
                $newStatus = $bahan->is_active == 'yes' ? 'no' : 'yes';
                
                DB::table('bahan')
                    ->where('bahan_id', $id)
                    ->update(['is_active' => $newStatus]);
                
                return Redirect::back()->with('success', 'Status bahan berhasil diubah.');
            }
            return Redirect::back()->with('error', 'Bahan tidak ditemukan.');

        } catch (\Exception $e) {
            Log::error('Gagal mengubah status bahan: ' . $e->getMessage());
            return Redirect::back()->with('error', 'Gagal mengubah status bahan.');
        }
    }
    /*
    
     FITUR EDIT & DELETE 
    
    Route::put('/Bahan/{id}', [MasterBahanController::class, 'update'])->name('bahan.update');
    Route::delete('/Bahan/{id}', [MasterBahanController::class, 'destroy'])->name('bahan.destroy');
    */

    /*
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_bahan' => ['required', 'string', 'max:255', Rule::unique('bahan')->ignore($id, 'bahan_id')],
            'deskripsi' => 'nullable|string',
        ]);

        try {
            DB::table('bahan')
                ->where('bahan_id', $id)
                ->update([
                    'nama_bahan' => $request->nama_bahan,
                    'deskripsi' => $request->deskripsi,
                ]);

            return Redirect::route('bahan.index')->with('success', 'Bahan berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error("Error saat memperbarui bahan: " . $e->getMessage());
            return Redirect::back()->with('error', 'Gagal memperbarui bahan.');
        }
    }
    */

    /*
    public function destroy($id)
    {
        try {
            // Peringatan: Idealnya, periksa dulu apakah bahan ini terikat dengan data produk.
            $isUsed = DB::table('master_produk')->where('bahan_id', $id)->exists();
            if ($isUsed) {
                return Redirect::back()->with('error', 'Gagal menghapus bahan karena masih digunakan oleh produk lain.');
            }

            $deleted = DB::table('bahan')->where('bahan_id', $id)->delete();

            if ($deleted) {
                return Redirect::route('bahan.index')->with('success', 'Bahan berhasil dihapus.');
            }
            return Redirect::back()->with('error', 'Bahan tidak ditemukan.');

        } catch (\Exception $e) {
            Log::error("Error saat menghapus bahan: " . $e->getMessage());
            return Redirect::back()->with('error', 'Gagal menghapus bahan.');
        }
    }
    */
}

