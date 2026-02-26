<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class PasswordController extends Controller
{
    // Menampilkan Form Ubah Password
    public function edit()
    {
        return view('auth.ubah-password');
    }

    // Memproses Perubahan Password
    public function update(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'], // Memastikan password lama benar
            'password' => ['required', 'min:8', 'confirmed'], // Memastikan password baru & konfirmasi sama
        ]);

        // Update password di database
        $request->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password Anda berhasil diperbarui!');
    }
}