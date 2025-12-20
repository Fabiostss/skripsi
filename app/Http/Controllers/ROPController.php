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

                    $ropProductIds = DB::table(DB::raw("
                (
                    SELECT 
                        produk_id,
                        ROW_NUMBER() OVER (PARTITION BY produk_id ORDER BY tanggal DESC) AS rn
                    FROM rop
                ) r
            "))
            ->where('rn', 1)
            ->pluck('produk_id')
            ->toArray();

            $products = DB::table('master_produk')
                ->where('is_active', 'yes')
                ->whereIn('produk_id', $ropProductIds)
                ->orderBy('produk_id', 'desc')
                ->get();



        $querySQL= "
                SELECT 
            mp.nama_produk,
            mp.produk_id,
            mp.stock,
            r.tanggal,
            r.rop_id,
            r.lead_time,
            r.safety_stock,
            r.tingkat_permintaan,
            r.rop
        FROM master_produk mp
        JOIN (
            SELECT 
                rop_id,
                produk_id,
                tanggal,
                lead_time,
                safety_stock,
                tingkat_permintaan,
                rop,
                ROW_NUMBER() OVER (PARTITION BY produk_id ORDER BY tanggal DESC) AS rn
            FROM rop
        ) r ON mp.produk_id = r.produk_id
        WHERE r.rn = 1
        

        ";
        // Variabel untuk menampung parameter query 
        $parameterQuery = [];


         if ($search) {
            $querySQL .= " AND mp.nama_produk LIKE ?";
            $parameterQuery[] = '%' . $search . '%'; 
        }
         if ($kritis) {
        $querySQL .= " AND mp.stock < op.rop";
    }
         $querySQL .= " ORDER BY produk_id DESC";

      
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
            DB::raw("DATE(rop.tanggal) as tanggal"), //  ambil tanggal (YYYY-MM-DD)
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
