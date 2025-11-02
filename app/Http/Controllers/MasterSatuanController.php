<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule; // Diperlukan untuk validasi edit

class MasterSatuanController extends Controller
{
    public function index(Request $request)
    { 
        try{
            $search = $request->input('search');
            $isActiveFilter = $request->input('is_active');

            $satuanList = DB::table('satuan')->orderBy('nama_satuan', 'asc')->get();

            $query = DB::table('satuan');

            if($search){
                $query->where('nama_satuan', 'like', '%' . $search . '%');
            }

            if($isActiveFilter && in_array($isActiveFilter, ['yes', 'no'])){
                $query->where('is_active', $isActiveFilter);
            }

            $satuan = $query->orderBy('satuan_id', 'desc')->paginate(10);

            $satuan->appends($request->all());

            return view('ManejemenSatuan',[
                'satuan' => $satuan,
                'satuanList' => $satuanList
            ]);
        } 
        catch (\Exception $e) {
            Log::error("Error saat mengambil data satuan: " . $e->getMessage());
            return Redirect::back()->with('error', 'Gagal memuat data satuan.');
        }
    }

    public function store(Request $request){
        $request->validate([
            'nama_satuan' => 'required|string|max:255|unique:satuan,nama_satuan',
            'is_active' => 'required|in:yes,no',
        ]);

        try {
            DB::table('satuan')->insert([
                'nama_satuan' => $request->input('nama_satuan'),
                'is_active' => $request->input('is_active'),
            ]);
            return Redirect::back()->with('success', 'Satuan berhasil ditambahkan!');
        } catch (\Exception $e) {
            Log::error("Error saat menyimpan satuan: " . $e->getMessage());
            return Redirect::back()->with('error', 'Gagal menambahkan satuan.');
        }
    }
    
    public function toggleStatus($id)
    {
        try {
            $satuan = DB::table('satuan')->where('satuan_id', $id)->first();

            if ($satuan) {
                $newStatus = $satuan->is_active == 'yes' ? 'no' : 'yes';
                
                DB::table('satuan')
                    ->where('satuan_id', $id)
                    ->update(['is_active' => $newStatus]);
                
                return Redirect::back()->with('success', 'Status satuan berhasil diubah.');
            }
            return Redirect::back()->with('error', 'Satuan tidak ditemukan.');

        } catch (\Exception $e) {
            Log::error('Gagal mengubah status satuan: ' . $e->getMessage());
            return Redirect::back()->with('error', 'Gagal mengubah status satuan.');
        }
    }

    /*

    | FITUR EDIT & DELETE 

    */

     /* 
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_satuan' => ['required', 'string', 'max:255', Rule::unique('satuan')->ignore($id, 'satuan_id')],
        ]);

        try {
            DB::table('satuan')
                ->where('satuan_id', $id)
                ->update([
                    'nama_satuan' => $request->nama_satuan,
                    //'updated_at' => now(),
                ]);

            return Redirect::route('satuan.index')->with('success', 'Satuan berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error("Error saat memperbarui satuan: " . $e->getMessage());
            return Redirect::back()->with('error', 'Gagal memperbarui satuan.');
        }
    }
  */
/*
    
    public function destroy($id)
    {
        try {
            $deleted = DB::table('satuan')->where('satuan_id', $id)->delete();

            if ($deleted) {
                return Redirect::route('satuan.index')->with('success', 'Satuan berhasil dihapus.');
            }
            return Redirect::back()->with('error', 'Satuan tidak ditemukan.');

        } catch (\Exception $e) {
            Log::error("Error saat menghapus satuan: " . $e->getMessage());
            return Redirect::back()->with('error', 'Gagal menghapus satuan karena mungkin masih terikat dengan data produk.');
        }
    }
    */
}

