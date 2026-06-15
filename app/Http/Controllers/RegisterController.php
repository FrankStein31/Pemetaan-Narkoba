<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class RegisterController extends Controller
{
    public function index()
    {
        return view('register.register', [
            'app' => Application::all(),
            'title' => 'Registrasi'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|string|unique:users,username|max:255',
            'gender' => 'required|in:Male,Female',
            'alamat' => 'required|string',
            'tanggal_lahir' =>  'required|date_format:Y-m-d',
            'password' => 'required|string|min:8|',
        ]);

    //      // Menentukan path image default berdasarkan gender
    $imagePath = $request->gender === 'Female'
    ? 'profil-images/girl.jpeg'
    : 'profil-images/man.jpeg';

// Debugging: Cek data sebelum insert
        // dd([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'username' => $request->username,
        //     'gender' => $request->gender,
        //     'image' => $imagePath,
        //     'alamat' => $request->alamat,
        //     'tanggal_lahir' => $request->tanggal_lahir,
        //     'password' => bcrypt($request->password),
        // ]);
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'gender' => $request->gender,
            'image' => $imagePath,
            'alamat' => $request->alamat,
            'tanggal_lahir' => $request->tanggal_lahir,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('login')->with('registerBerhasil', 'Registrasi berhasil, silakan login.');
    }
}


