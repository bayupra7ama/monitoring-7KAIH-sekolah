<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Otp;
use App\Models\User;
use App\Services\OtpService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class OtpController extends Controller
{
    public function index()
    {
        if (!session('otp_user_id')) {
            return redirect()->route('login');
        }

        return view('auth.otp', [
            'otpExpiredAt' => session('otp_expired_at'),
        ]);
    }

    public function send(OtpService $otpService)
    {
        $user = User::findOrFail(session('otp_user_id'));

        /**
         * LIMIT OTP PER HARI
         * maksimal 5 kali
         */
        $todayCount = Otp::where('user_id', $user->id)
            ->whereDate('created_at', now()->toDateString())
            ->count();

        if ($todayCount >= 5) {
            return back()->withErrors([
                'otp' => 'Batas permintaan OTP hari ini sudah tercapai.',
            ]);
        }

        /**
         * COOLDOWN 5 MENIT
         */
        $lastOtp = Otp::where('user_id', $user->id)
            ->latest()
            ->first();

        if ($lastOtp && $lastOtp->expired_at->isFuture()) {
            return back()->withErrors([
                'otp' => 'OTP masih aktif. Tunggu hingga 5 menit.',
            ]);
        }

        /**
         * KIRIM OTP
         */
        $otpService->generateAndSend($user);

        // simpan waktu expired ke session
        session([
            'otp_expired_at' => now()->addMinutes(5)->timestamp,
        ]);

        return back()->with('success', 'OTP berhasil dikirim ke WhatsApp.');

    }

    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'required|digits:4',
        ]);

        $otp = Otp::where('user_id', session('otp_user_id'))
            ->where('code', $request->code)
            ->where('expired_at', '>', now())
            ->latest()
            ->first();

        if (!$otp) {
            return back()->withErrors([
                'code' => 'OTP salah atau sudah kedaluwarsa.',
            ]);
        }

        $user = User::findOrFail(session('otp_user_id'));

        // ✅ LOGIN FINAL
        Auth::login($user);

        // ✅ WAJIB INI
        session([
            'otp_verified' => true,
        ]);

        // keamanan
        request()->session()->regenerate();

        // bersihkan OTP
        Otp::where('user_id', $user->id)->delete();
        session()->forget('otp_user_id');

        return redirect()->intended('dashboard');
    }

}
