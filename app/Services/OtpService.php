<?php

namespace App\Services;

use App\Models\Otp;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class OtpService
{
    public function generateAndSend($user): void
    {
        $code = random_int(1000, 9999);

        Otp::create([
            'user_id' => $user->id,
            'code' => $code,
            'expired_at' => now()->addMinutes(5),
        ]);

        $this->sendViaWhatsApp($user->phone, $code);
    }

    protected function sendViaWhatsApp(string $phone, string $code): void
    {
        Http::post(env('WA_SERVER_URL') . '/send-otp', [
            'phone' => $this->normalizePhone($phone),
            'message' =>
                "🔐 *Verifikasi Login*

Halo 👋  
Berikut kode OTP untuk masuk ke *7 Kebiasaan Anak Indonesia Hebat*:

👉 *$code*

⏳ Berlaku selama *5 menit*.  
⚠️ Jangan bagikan kode ini kepada siapa pun.

Terima kasih 🙏  
*7 Kebiasaan Anak Indonesia Hebat*"

        ]);
    }

    protected function normalizePhone(string $phone): string
    {
        if (str_starts_with($phone, '0')) {
            return '62' . substr($phone, 1);
        }

        if (str_starts_with($phone, '+')) {
            return ltrim($phone, '+');
        }

        return $phone;
    }
}
