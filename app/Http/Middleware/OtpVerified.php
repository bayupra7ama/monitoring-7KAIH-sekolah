<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OtpVerified
{
    public function handle(Request $request, Closure $next): Response
    {
        // user belum login
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        // belum verifikasi OTP
        if (! session('otp_verified')) {
            return redirect()->route('otp.index')
                ->withErrors([
                    'otp' => 'Silakan verifikasi OTP terlebih dahulu.',
                ]);
        }

        return $next($request);
    }
}
