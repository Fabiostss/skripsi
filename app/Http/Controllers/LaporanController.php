<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Dompdf\Dompdf;
use Dompdf\Options;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $kelompok = $request->input('kelompok'); // produk, kategori, tipe, bahan
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');

        $data = [];
        $ringkasan = [
          'keluar_terbanyak' => collect(),
            'keluar_tersedikit' => collect(),
            'masuk_terbanyak' => collect(),
            'masuk_tersedikit' => collect(),
        ];

        // kalau param kosong, langsung kirim view kosong
        if (!$kelompok || !$tanggalAwal || !$tanggalAkhir) {
            return view('Laporan', compact('data', 'ringkasan'));
        }

        $queryTanggalKeluar = "
            WHERE bk.tanggal_keluar BETWEEN STR_TO_DATE(?, '%d-%m-%Y') 
            AND DATE_ADD(STR_TO_DATE(?, '%d-%m-%Y'), INTERVAL 1 DAY) - INTERVAL 1 SECOND
        ";

        $queryTanggalMasuk = "
            WHERE bm.tanggal_masuk BETWEEN STR_TO_DATE(?, '%d-%m-%Y') 
            AND DATE_ADD(STR_TO_DATE(?, '%d-%m-%Y'), INTERVAL 1 DAY) - INTERVAL 1 SECOND
        ";

        // Logika query utama tetap sama
        switch ($kelompok) {
            case 'bahan':
                $query = "
                    SELECT mp.bahan_id as id, bhn.nama_bahan as nama, 
                           SUM(mp.stock) as stok, 
                           IFNULL(SUM(dbk1.totalkeluar),0) as total_keluar, 
                           IFNULL(SUM(dbm1.totalmasuk),0) as total_masuk
                    FROM bahan bhn
                    JOIN master_produk mp ON bhn.bahan_id = mp.bahan_id
                    LEFT JOIN (
                        SELECT SUM(dbk.jumlah) as totalkeluar, dbk.produk_id
                        FROM barang_keluar bk 
                        JOIN detail_barang_keluar dbk ON bk.transaksi_keluar_id = dbk.transaksi_keluar_id
                        $queryTanggalKeluar
                        GROUP BY produk_id
                    ) dbk1 ON dbk1.produk_id = mp.produk_id
                    LEFT JOIN (
                        SELECT SUM(dbm.jumlah) as totalmasuk, dbm.produk_id
                        FROM barang_masuk bm 
                        JOIN detail_barang_masuk dbm ON bm.transaksi_masuk_id = dbm.transaksi_masuk_id
                        $queryTanggalMasuk
                        GROUP BY produk_id
                    ) dbm1 ON dbm1.produk_id = mp.produk_id
                    GROUP BY mp.bahan_id, bhn.nama_bahan
                ";
                break;

            case 'kategori':
                $query = "
                    SELECT mp.kategori_id as id, ktg.nama_kategori as nama, 
                           SUM(mp.stock) as stok, 
                           IFNULL(SUM(dbk1.totalkeluar),0) as total_keluar, 
                           IFNULL(SUM(dbm1.totalmasuk),0) as total_masuk
                    FROM kategori ktg
                    JOIN master_produk mp ON ktg.kategori_id = mp.kategori_id
                    LEFT JOIN (
                        SELECT SUM(dbk.jumlah) as totalkeluar, dbk.produk_id
                        FROM barang_keluar bk 
                        JOIN detail_barang_keluar dbk ON bk.transaksi_keluar_id = dbk.transaksi_keluar_id
                        $queryTanggalKeluar
                        GROUP BY produk_id
                    ) dbk1 ON dbk1.produk_id = mp.produk_id
                    LEFT JOIN (
                        SELECT SUM(dbm.jumlah) as totalmasuk, dbm.produk_id
                        FROM barang_masuk bm 
                        JOIN detail_barang_masuk dbm ON bm.transaksi_masuk_id = dbm.transaksi_masuk_id
                        $queryTanggalMasuk
                        GROUP BY produk_id
                    ) dbm1 ON dbm1.produk_id = mp.produk_id
                    GROUP BY mp.kategori_id, ktg.nama_kategori
                ";
                break;

            case 'tipe':
                $query = "
                    SELECT mp.tipe_id as id, tp.nama_tipe as nama, 
                           SUM(mp.stock) as stok, 
                           IFNULL(SUM(dbk1.totalkeluar),0) as total_keluar, 
                           IFNULL(SUM(dbm1.totalmasuk),0) as total_masuk
                    FROM tipe tp
                    JOIN master_produk mp ON tp.tipe_id = mp.tipe_id
                    LEFT JOIN (
                        SELECT SUM(dbk.jumlah) as totalkeluar, dbk.produk_id
                        FROM barang_keluar bk 
                        JOIN detail_barang_keluar dbk ON bk.transaksi_keluar_id = dbk.transaksi_keluar_id
                        $queryTanggalKeluar
                        GROUP BY produk_id
                    ) dbk1 ON dbk1.produk_id = mp.produk_id
                    LEFT JOIN (
                        SELECT SUM(dbm.jumlah) as totalmasuk, dbm.produk_id
                        FROM barang_masuk bm 
                        JOIN detail_barang_masuk dbm ON bm.transaksi_masuk_id = dbm.transaksi_masuk_id
                        $queryTanggalMasuk
                        GROUP BY produk_id
                    ) dbm1 ON dbm1.produk_id = mp.produk_id
                    GROUP BY mp.tipe_id, tp.nama_tipe
                ";
                break;
            
            case 'produk':
                $query = "
                    SELECT mp.produk_id as id, mp.nama_produk as nama, 
                           SUM(mp.stock) as stok, 
                           IFNULL(SUM(dbk1.totalkeluar),0) as total_keluar, 
                           IFNULL(SUM(dbm1.totalmasuk),0) as total_masuk
                    FROM master_produk mp
                    LEFT JOIN (
                        SELECT SUM(dbk.jumlah) as totalkeluar, dbk.produk_id
                        FROM barang_keluar bk 
                        JOIN detail_barang_keluar dbk ON bk.transaksi_keluar_id = dbk.transaksi_keluar_id
                        $queryTanggalKeluar
                        GROUP BY produk_id
                    ) dbk1 ON dbk1.produk_id = mp.produk_id
                    LEFT JOIN (
                        SELECT SUM(dbm.jumlah) as totalmasuk, dbm.produk_id
                        FROM barang_masuk bm 
                        JOIN detail_barang_masuk dbm ON bm.transaksi_masuk_id = dbm.transaksi_masuk_id
                        $queryTanggalMasuk
                        GROUP BY produk_id
                    ) dbm1 ON dbm1.produk_id = mp.produk_id
                    GROUP BY mp.produk_id, mp.nama_produk
                ";
                break;

            default:
                return view('Laporan', ['data' => [], 'ringkasan' => $ringkasan]);
        }






        

        $data = DB::select($query, [$tanggalAwal, $tanggalAkhir, $tanggalAwal, $tanggalAkhir]);
       
        // perubahan analisis data 
        if (!empty($data)) {
            $collection = collect($data);

            //  Keluar
            // Filter data keluar yang LEBIH BESAR DARI 0
            $dataKeluarPositif = $collection->where('total_keluar', '>', 0);
            
            // Cek apakah ada data setelah difilter
            if ($dataKeluarPositif->isNotEmpty()) {
                // Ambil terbanyak (dari yang > 0)
                $ringkasan['keluar_terbanyak'] = $dataKeluarPositif->sortByDesc('total_keluar')->take(5);
                // Ambil tersedikit (dari yang > 0)
                $ringkasan['keluar_tersedikit'] = $dataKeluarPositif->sortBy('total_keluar')->take(5);
            }

            //  Logika Masuk 
            // Filter data masuk yang LEBIH BESAR DARI 0
            $dataMasukPositif = $collection->where('total_masuk', '>', 0);

            // Cek apakah ada data setelah difilter
            if ($dataMasukPositif->isNotEmpty()) {
                // Ambil terbanyak (dari yang > 0)
                $ringkasan['masuk_terbanyak'] = $dataMasukPositif->sortByDesc('total_masuk')->take(5);
                // Ambil tersedikit (dari yang > 0)
                $ringkasan['masuk_tersedikit'] = $dataMasukPositif->sortBy('total_masuk')->take(5);
            }
        }
         // perubahan analisis data 


       

        // kalau akses dari browser biasa
        return view('Laporan', compact('data', 'ringkasan'));
    }

   






    public function exportPDF(Request $request)
    {
        $kelompok = $request->input('kelompok');
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');

        if (!$kelompok || !$tanggalAwal || !$tanggalAkhir) {
            return response()->json(['error' => 'Parameter tidak lengkap.'], 400);
        }

        // Query dan switch case tetap sama
        $queryTanggalKeluar = "
            WHERE bk.tanggal_keluar BETWEEN STR_TO_DATE(?, '%d-%m-%Y') 
            AND DATE_ADD(STR_TO_DATE(?, '%d-%m-%Y'), INTERVAL 1 DAY) - INTERVAL 1 SECOND
        ";

        $queryTanggalMasuk = "
            WHERE bm.tanggal_masuk BETWEEN STR_TO_DATE(?, '%d-%m-%Y') 
            AND DATE_ADD(STR_TO_DATE(?, '%d-%m-%Y'), INTERVAL 1 DAY) - INTERVAL 1 SECOND
        ";

        switch ($kelompok) {
            case 'bahan':
                $query = "
                    SELECT mp.bahan_id as id, bhn.nama_bahan as nama, 
                           SUM(mp.stock) as stok, 
                           IFNULL(SUM(dbk1.totalkeluar),0) as total_keluar, 
                           IFNULL(SUM(dbm1.totalmasuk),0) as total_masuk
                    FROM bahan bhn
                    JOIN master_produk mp ON bhn.bahan_id = mp.bahan_id
                    LEFT JOIN (
                        SELECT SUM(dbk.jumlah) as totalkeluar, dbk.produk_id
                        FROM barang_keluar bk 
                        JOIN detail_barang_keluar dbk ON bk.transaksi_keluar_id = dbk.transaksi_keluar_id
                        $queryTanggalKeluar
                        GROUP BY produk_id
                    ) dbk1 ON dbk1.produk_id = mp.produk_id
                    LEFT JOIN (
                        SELECT SUM(dbm.jumlah) as totalmasuk, dbm.produk_id
                        FROM barang_masuk bm 
                        JOIN detail_barang_masuk dbm ON bm.transaksi_masuk_id = dbm.transaksi_masuk_id
                        $queryTanggalMasuk
                        GROUP BY produk_id
                    ) dbm1 ON dbm1.produk_id = mp.produk_id
                    GROUP BY mp.bahan_id, bhn.nama_bahan
                ";
                break;
            case 'kategori':
                $query = "
                    SELECT mp.kategori_id as id, ktg.nama_kategori as nama, 
                           SUM(mp.stock) as stok, 
                           IFNULL(SUM(dbk1.totalkeluar),0) as total_keluar, 
                           IFNULL(SUM(dbm1.totalmasuk),0) as total_masuk
                    FROM kategori ktg
                    JOIN master_produk mp ON ktg.kategori_id = mp.kategori_id
                    LEFT JOIN (
                        SELECT SUM(dbk.jumlah) as totalkeluar, dbk.produk_id
                        FROM barang_keluar bk 
                        JOIN detail_barang_keluar dbk ON bk.transaksi_keluar_id = dbk.transaksi_keluar_id
                        $queryTanggalKeluar
                        GROUP BY produk_id
                    ) dbk1 ON dbk1.produk_id = mp.produk_id
                    LEFT JOIN (
                        SELECT SUM(dbm.jumlah) as totalmasuk, dbm.produk_id
                        FROM barang_masuk bm 
                        JOIN detail_barang_masuk dbm ON bm.transaksi_masuk_id = dbm.transaksi_masuk_id
                        $queryTanggalMasuk
                        GROUP BY produk_id
                    ) dbm1 ON dbm1.produk_id = mp.produk_id
                    GROUP BY mp.kategori_id, ktg.nama_kategori
                ";
                break;
            case 'tipe':
                $query = "
                    SELECT mp.tipe_id as id, tp.nama_tipe as nama, 
                           SUM(mp.stock) as stok, 
                           IFNULL(SUM(dbk1.totalkeluar),0) as total_keluar, 
                           IFNULL(SUM(dbm1.totalmasuk),0) as total_masuk
                    FROM tipe tp
                    JOIN master_produk mp ON tp.tipe_id = mp.tipe_id
                    LEFT JOIN (
                        SELECT SUM(dbk.jumlah) as totalkeluar, dbk.produk_id
                        FROM barang_keluar bk 
                        JOIN detail_barang_keluar dbk ON bk.transaksi_keluar_id = dbk.transaksi_keluar_id
                        $queryTanggalKeluar
                        GROUP BY produk_id
                    ) dbk1 ON dbk1.produk_id = mp.produk_id
                    LEFT JOIN (
                        SELECT SUM(dbm.jumlah) as totalmasuk, dbm.produk_id
                        FROM barang_masuk bm 
                        JOIN detail_barang_masuk dbm ON bm.transaksi_masuk_id = dbm.transaksi_masuk_id
                        $queryTanggalMasuk
                        GROUP BY produk_id
                    ) dbm1 ON dbm1.produk_id = mp.produk_id
                    GROUP BY mp.tipe_id, tp.nama_tipe
                ";
                break;
            case 'produk':
                $query = "
                    SELECT mp.produk_id as id, mp.nama_produk as nama, 
                           SUM(mp.stock) as stok, 
                           IFNULL(SUM(dbk1.totalkeluar),0) as total_keluar, 
                           IFNULL(SUM(dbm1.totalmasuk),0) as total_masuk
                    FROM master_produk mp
                    LEFT JOIN (
                        SELECT SUM(dbk.jumlah) as totalkeluar, dbk.produk_id
                        FROM barang_keluar bk 
                        JOIN detail_barang_keluar dbk ON bk.transaksi_keluar_id = dbk.transaksi_keluar_id
                        $queryTanggalKeluar
                        GROUP BY produk_id
                    ) dbk1 ON dbk1.produk_id = mp.produk_id
                    LEFT JOIN (
                        SELECT SUM(dbm.jumlah) as totalmasuk, dbm.produk_id
                        FROM barang_masuk bm 
                        JOIN detail_barang_masuk dbm ON bm.transaksi_masuk_id = dbm.transaksi_masuk_id
                        $queryTanggalMasuk
                        GROUP BY produk_id
                    ) dbm1 ON dbm1.produk_id = mp.produk_id
                    GROUP BY mp.produk_id, mp.nama_produk
                ";
                break;
            default:
                return response()->json(['error' => 'Kelompok tidak valid.'], 400);
        }

        $data = DB::select($query, [$tanggalAwal, $tanggalAkhir, $tanggalAwal, $tanggalAkhir]);
        
       // perubahan analisis data 
         $ringkasan = [
            'keluar_terbanyak' => collect(),
            'keluar_tersedikit' => collect(),
            'masuk_terbanyak' => collect(),
            'masuk_tersedikit' => collect(),
         ]; // <-- Inisialisasi agar konsisten

        if (!empty($data)) {
            $collection = collect($data);

            //  Keluar 
            // Filter data keluar yang LEBIH BESAR DARI 0
            $dataKeluarPositif = $collection->where('total_keluar', '>', 0);
            
            // Cek apakah ada data setelah difilter
            if ($dataKeluarPositif->isNotEmpty()) {
                //  Ambil terbanyak (dari yang > 0)
                $ringkasan['keluar_terbanyak'] = $dataKeluarPositif->sortByDesc('total_keluar')->take(5);
                //  Ambil tersedikit (dari yang > 0)
                $ringkasan['keluar_tersedikit'] = $dataKeluarPositif->sortBy('total_keluar')->take(5);
            }

            //  Logika Masuk 
            //Filter data masuk yang LEBIH BESAR DARI 0
            $dataMasukPositif = $collection->where('total_masuk', '>', 0);

            // Cek apakah ada data setelah difilter
            if ($dataMasukPositif->isNotEmpty()) {
                // Ambil terbanyak (dari yang > 0)
                $ringkasan['masuk_terbanyak'] = $dataMasukPositif->sortByDesc('total_masuk')->take(5);
                // Ambil tersedikit (dari yang > 0)
                $ringkasan['masuk_tersedikit'] = $dataMasukPositif->sortBy('total_masuk')->take(5);
            }
        }
     // perubahan analisis data 

        // --- Render HTML untuk PDF ---
        $html = view('laporan.pdf', [
            'kelompok' => ucfirst($kelompok),
            'tanggalAwal' => $tanggalAwal,
            'tanggalAkhir' => $tanggalAkhir,
            'data' => $data,
            'ringkasan' => $ringkasan // <-- Tambahkan ini
        ])->render();

        // --- Generate PDF ---
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = "Laporan_{$kelompok}_" . date('Ymd_His') . ".pdf";
        return $dompdf->stream($filename, ["Attachment" => true]);
    }
}