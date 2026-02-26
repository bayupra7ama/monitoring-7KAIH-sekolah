<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\OtpService; // <--- Panggil Service OTP
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request, OtpService $otpService): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'string', 'max:15', 'unique:'.User::class], // Validasi Phone
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // 1. Buat User Baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'orangtua', // Default role (sesuaikan kebutuhan)
        ]);

        event(new Registered($user));

        // ---------------------------------------------------------
        // PERUBAHAN DI SINI:
        // Jangan langsung Auth::login($user);
        // Tapi kirim OTP dan arahkan ke halaman verifikasi.
        // ---------------------------------------------------------

        // 2. Generate & Kirim OTP WA
        $otpService->generateAndSend($user);

        // 3. Simpan data sementara di session (seperti proses Login)
        session([
            'otp_user_id' => $user->id,
            'otp_expired_at' => now()->addMinutes(5)->timestamp,
        ]);

        // 4. Redirect ke Halaman Input OTP
        return redirect()->route('otp.index')->with('success', 'Untuk melanjutkan silahkan masukan OTP! Kode OTP telah dikirim ke WhatsApp Anda.');
    }
}