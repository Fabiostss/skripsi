<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;

class MasterUserController extends Controller
{
    public function index(Request $request){
        try{
            $search = $request->input('search');
            $isActiveFilter = $request->input('is_active');

            // Mengambil daftar lengkap semua user untuk dropdown pencarian
            $userList = DB::table('users')->orderBy('nama_lengkap', 'asc')->get();

            $query = DB::table('users');

            if ($search) {
                // Mencari berdasarkan nama lengkap
                $query->where('nama_lengkap', 'like', '%' . $search . '%');
            }

            if($isActiveFilter && in_array($isActiveFilter, ['yes', 'no'])){
                $query->where('is_active', $isActiveFilter);
            }

            $users = $query->orderBy('user_id', 'desc')->paginate(10);
            
            $users->appends($request->all());

            return view('ManejemenUser',[
                'users' => $users,
                'userList' => $userList // Mengirim daftar lengkap ke view
            ]);
        }
        catch(\Exception $e){
            Log::error("Error saat mengambil data user: " . $e->getMessage());
            return Redirect::back()->with('error', 'Terjadi kesalahan saat mengambil data user.');
        }
    }

    public function store(Request $request){
        $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'role_name' => ['required', 'string', 'in:admin,owner'],
            'nomor_telepon' => ['required', 'string', 'max:15'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'is_active' => 'required|in:yes,no', // Menambahkan validasi is_active
        ]);
        
        try {
            DB::table('users')->insert([
                'nama_lengkap' => $request->input('nama_lengkap'),
                'username' => $request->input('username'),
                'role_name' => $request->input('role_name'),
                'nomor_telepon' => $request->input('nomor_telepon'),
                'password' => Hash::make($request->input('password')),
                'is_active' => $request->input('is_active'), // Menyimpan data is_active
            ]);
            return Redirect::back()->with('success', 'User berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error("Error saat menyimpan user: " . $e->getMessage());
            return Redirect::back()->with('error', 'Gagal menambahkan user.');
        }
    }

    /**
     * FUNGSI BARU: Untuk mengubah status is_active.
     */
    public function toggleStatus($id)
    {
        try {
            $user = DB::table('users')->where('user_id', $id)->first();

            if ($user) {
                // Balik nilainya: jika 'yes' jadi 'no', dan sebaliknya
                $newStatus = $user->is_active == 'yes' ? 'no' : 'yes';
                
                DB::table('users')
                    ->where('user_id', $id)
                    ->update(['is_active' => $newStatus]);
                
                return Redirect::back()->with('success', 'Status user berhasil diubah.');
            }
            return Redirect::back()->with('error', 'User tidak ditemukan.');

        } catch (\Exception $e) {
            Log::error('Gagal mengubah status user: ' . $e->getMessage());
            return Redirect::back()->with('error', 'Gagal mengubah status user.');
        }
    }
}
