<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule; // Diperlukan untuk validasi edit

class MasterSupplierController extends Controller
{
    
    public function index(Request $request)
    {
        try {
            $search = $request->input('search');
            $isActiveFilter = $request->input('is_active');

            $supplierList = DB::table('suppliers')->orderBy('nama_supplier', 'asc')->get();
            
            $query = DB::table('suppliers');

            if($search){
                $query->where('nama_supplier', 'like', '%' . $search . '%');
            }

            if($isActiveFilter && in_array($isActiveFilter, ['yes', 'no'])){
                $query->where('is_active', $isActiveFilter);
            }

            $supplier = $query
                ->orderBy('supplier_id','desc')->paginate(10);

            $supplier->appends($request->all());

            return view('ManejemenSupplier', [
                'supplier' => $supplier,
                'supplierList' => $supplierList 
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return Redirect::back()->with('error', 'Terjadi kesalahan saat mengambil data supplier.');
        }
    }

  
    public function store(Request $request)
    {
        $request->validate([
            'nama_supplier' => 'required|string|max:45|unique:suppliers,nama_supplier',
            'nomor_telepon' => 'required|string|max:45|unique:suppliers,nomor_telepon',
            'alamat' => 'required|string|max:100',
            'is_active' => 'required|in:yes,no',
        ]);

        try {
            DB::table('suppliers')->insert([
                'nama_supplier' => $request->input('nama_supplier'),
                'nomor_telepon' => $request->input('nomor_telepon'),
                'alamat' => $request->input('alamat'),
                'is_active' => $request->input('is_active'),
            ]);

            return Redirect::back()->with('success', 'Supplier berhasil ditambahkan!');

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return Redirect::back()->with('error', 'Gagal menambahkan supplier.');
        }
    }

    
    public function toggleStatus($id)
    {
        try {
            $supplier = DB::table('suppliers')->where('supplier_id', $id)->first();

            if ($supplier) {
                $newStatus = $supplier->is_active == 'yes' ? 'no' : 'yes';
                
                DB::table('suppliers')
                    ->where('supplier_id', $id)
                    ->update(['is_active' => $newStatus]);
                
                return Redirect::back()->with('success', 'Status supplier berhasil diubah.');
            }
            return Redirect::back()->with('error', 'Supplier tidak ditemukan.');

        } catch (\Exception $e) {
            Log::error('Gagal mengubah status supplier: ' . $e->getMessage());
            return Redirect::back()->with('error', 'Gagal mengubah status supplier.');
        }
    }


    /*

     FITUR EDIT & DELETE 
 
    
    */

    /*
    public function update(Request $request, $id)
    {
        // Fungsi ini dipanggil saat form 'Edit' di-submit.
        $request->validate([
            // Aturan 'unique' diubah agar tidak error saat menyimpan nama yang sama
            'nama_supplier' => ['required', 'string', 'max:45', Rule::unique('suppliers')->ignore($id, 'supplier_id')],
            'nomor_telepon' => ['required', 'string', 'max:45', Rule::unique('suppliers')->ignore($id, 'supplier_id')],
            'alamat' => 'required|string|max:45',
        ]);

        try {
            DB::table('suppliers')
                ->where('supplier_id', $id)
                ->update([
                    'nama_supplier' => $request->nama_supplier,
                    'nomor_telepon' => $request->nomor_telepon,
                    'alamat' => $request->alamat,
                    //'updated_at' => now(),
                ]);

            return Redirect::route('supplier.index')->with('success', 'Supplier berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error("Error saat memperbarui supplier: " . $e->getMessage());
            return Redirect::back()->with('error', 'Gagal memperbarui supplier.');
        }
    }
     */

  /* 
    public function destroy($id)
    {
        // Fungsi ini dipanggil saat form 'Hapus' di-submit.
        try {
            // Peringatan: Idealnya, periksa dulu apakah supplier ini terikat dengan data lain (misal: barang_masuk).
            // Jika iya, sebaiknya jangan dihapus permanen, tapi ubah statusnya menjadi tidak aktif.
            // Untuk contoh ini, kita akan melakukan hapus permanen.
            
            $deleted = DB::table('suppliers')->where('supplier_id', $id)->delete();

            if ($deleted) {
                return Redirect::route('supplier.index')->with('success', 'Supplier berhasil dihapus.');
            }
            return Redirect::back()->with('error', 'Supplier tidak ditemukan.');

        } catch (\Exception $e) {
            Log::error("Error saat menghapus supplier: " . $e->getMessage());
            // Menambahkan pesan error jika supplier terikat dengan data lain (foreign key constraint)
            return Redirect::back()->with('error', 'Gagal menghapus supplier karena mungkin masih terikat dengan data transaksi.');
        }
    }
      */
}

