<x-guest-layout>

    <div class="max-w-md mx-auto bg-white p-6 rounded shadow">

        <h2 class="text-xl font-bold mb-4 text-center">
            Verifikasi OTP
        </h2>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-2 rounded mb-3 text-sm">
                {{ session('success') }}
            </div>
        @endif

      
        @if ($errors->any())
            <div class="mb-4 rounded bg-red-100 p-3 text-sm text-red-700">
                @foreach ($errors->all() as $error)
                    <div>• {{ $error }}</div>
                @endforeach
            </div>
        @endif


        <!-- RESEND OTP -->
        <form method="POST" action="{{ route('otp.send') }}">
            @csrf
            <button id="resendBtn" class="w-full bg-blue-600 text-white py-2 rounded mb-3 disabled:bg-gray-400">
                Minta OTP
            </button>
        </form>

        <!-- COUNTDOWN -->
        <p class="text-center text-sm text-gray-600 mb-4">
            Kirim ulang dalam
            <span id="timer" class="font-semibold text-red-600">05:00</span>
        </p>

        <!-- VERIFY OTP -->
        <form method="POST" action="{{ route('otp.verify') }}">
            @csrf

            <input type="text" name="code" maxlength="4"
                class="border w-full p-2 text-center text-lg tracking-widest" placeholder="• • • •" required>

            <button class="mt-4 w-full bg-green-600 text-white py-2 rounded">
                Verifikasi OTP
            </button>
        </form>

    </div>

    <!-- ================= JS ================= -->
    <script>
        const expiredAt = {{ $otpExpiredAt ?? 'null' }};
        const resendBtn = document.getElementById('resendBtn');
        const timerEl = document.getElementById('timer');

        function startCountdown() {
            if (!expiredAt) {
                resendBtn.disabled = false;
                timerEl.textContent = '00:00';
                return;
            }

            const interval = setInterval(() => {
                const now = Math.floor(Date.now() / 1000);
                let diff = expiredAt - now;

                if (diff <= 0) {
                    clearInterval(interval);
                    resendBtn.disabled = false;
                    timerEl.textContent = '00:00';
                    return;
                }

                resendBtn.disabled = true;

                const minutes = Math.floor(diff / 60);
                const seconds = diff % 60;

                timerEl.textContent =
                    String(minutes).padStart(2, '0') + ':' +
                    String(seconds).padStart(2, '0');
            }, 1000);
        }

        startCountdown();
    </script>

</x-guest-layout>
