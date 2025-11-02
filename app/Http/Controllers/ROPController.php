<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class ROPController extends Controller
{
    public function storeOrUpdate(Request $request)
    {
        $produk_id     = $request->input('produk_id');
        $lead_time     = $request->input('lead_time');
        $safety_stock  = $request->input('safety_stock');
        $today         = date('Y-m-d');

        // Cek apakah data untuk produk_id dan tanggal hari ini sudah ada
        $existing = DB::table('rop')
            ->where('produk_id', $produk_id)
            ->where('tanggal', $today)
            ->first();

        if ($existing) {
            // Update data
            DB::table('rop')
                ->where('rop_id', $existing->rop_id)
                ->update([
                    'lead_time'    => $lead_time,
                    'safety_stock' => $safety_stock,
                ]);
            return Redirect::back()->with('success', 'ROP berhasil diubah');
        } else {

            $lastPermintaan = DB::table('rop')
            ->where('produk_id', $produk_id)
            ->orderBy('tanggal', 'desc')
            ->value('tingkat_permintaan');
            // Insert baru
            DB::table('rop')->insert([
                'produk_id'     => $produk_id,
                'lead_time'     => $lead_time,
                'safety_stock'  => $safety_stock,
                'tingkat_permintaan' => $lastPermintaan ?? 0,
                'tanggal'       => $today,
           
            ]);
           return Redirect::back()->with('success', 'ROP berhasil di tambhakan!');
        }
    }

     public function index(request $request)
    {
        $search = $request->input('search');
         $kritis = $request->input('kritis');

        $products = DB::table('master_produk') ->where('is_active', 'yes')->orderBy('nama_produk', 'desc')->get();
        
        $querySQL= "
            SELECT 
                mp.nama_produk,
                mp.produk_id,
                mp.stock, 
                rp.tanggal,
                op.rop_id,
                op.lead_time,
                op.safety_stock,
                op.tingkat_permintaan,
                op.rop
            FROM master_produk mp
            JOIN (
                SELECT produk_id, MAX(tanggal) as tanggal 
                FROM rop 
                GROUP BY produk_id
            ) rp ON mp.produk_id = rp.produk_id
            JOIN rop op ON op.produk_id = mp.produk_id AND op.tanggal = rp.tanggal 

        ";
        // Variabel untuk menampung parameter query 
        $parameterQuery = [];


         if ($search) {
            $querySQL .= " WHERE mp.nama_produk LIKE ?";
            $parameterQuery[] = '%' . $search . '%'; // Tambahkan wildcard % untuk mencari bagian dari nama
        }
         if ($kritis) {
        $querySQL .= " AND mp.stock < op.rop";
    }
         $querySQL .= " ORDER BY rp.tanggal DESC";

      
        $data = DB::select($querySQL, $parameterQuery);

         return view('ROP', [
                'products' => $products,
                'data' => $data,
                'search' => $search
            ]);
    }

    public function history($id){
    $history = DB::table('rop')
        ->join('master_produk', 'rop.produk_id', '=', 'master_produk.produk_id')
        ->select(
            DB::raw("DATE(rop.tanggal) as tanggal"), // hanya ambil tanggal (YYYY-MM-DD)
            'master_produk.nama_produk',
            'rop.lead_time',
            'rop.safety_stock',
            'rop.tingkat_permintaan',
            'rop.rop'
        )
        ->where('rop.produk_id', $id)
        ->orderBy('rop.tanggal', 'desc')
        ->orderBy('rop.rop_id', 'desc')
        ->get();

    return response()->json($history);
}

 
}
