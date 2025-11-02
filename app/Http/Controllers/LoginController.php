<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    function index(){
        return view('login');
    }

    function store(Request $request){
        
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->is_active == 'yes') {
                // 5. JIKA 'yes', maka login berhasil. Lanjutkan seperti biasa.
                $request->session()->regenerate();
                return redirect()->intended('Monitoring');
            } else {
                // 6. JIKA BUKAN 'yes', paksa logout lagi
                Auth::logout();
                
                // KIRIM PESAN ERROR KARENA AKUN TIDAK AKTIF
                return back()->withErrors([
                    'username' => 'Akun Anda tidak aktif. Silakan hubungi administrator.',
                ])->onlyInput('username'); // onlyInput akan mengisi kembali field 'username'
            }
            
        }

        // (USERNAME/PASSWORD SALAH)
    
        return back()->withErrors([
            'username' => 'Username atau Password salah. Silakan cek kembali.',
        ])->onlyInput('username'); // onlyInput akan mengisi kembali field 'username'
    }

    function logout(Request $request){
            Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/Login');
    }
}