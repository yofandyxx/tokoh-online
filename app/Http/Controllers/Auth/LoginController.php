<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validasi input 
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:4',
        ]);

        // Coba login 
        if (Auth::attempt($request->only('email', 'password'))) {

            // Jika login berhasil, cek role 
            $user = Auth::user();

            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            if ($user->role === 'kasir') {
                return redirect()->route('kasir.dashboard');
            }

            // Default fallback 
            return redirect('/');
        }

        // Jika gagal login 
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/login')->with('success', 'Anda berhasil logout.');
    }
}

