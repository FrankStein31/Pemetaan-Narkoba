<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Models\Application;

class LoginController extends Controller
{
    public function index()
    {
        return view('login.index', [
            'app' => Application::all(),
            'title' => 'Login'
        ]);
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = auth()->user();

            if ($user->is_admin == 1) {
                return redirect()->intended('/admin/dashboard');
            } elseif ($user->is_admin == 2) {
                return redirect()->intended('/masyarakat/dashboard');
            } elseif ($user->is_admin == 0) {
                return redirect()->intended('/masyarakat/dashboard');
            } else {
                Auth::logout();
                return back()->with('loginError', 'Hak akses tidak dikenali.');
            }
        }

        return back()->with('loginError', 'Username atau password salah!');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
