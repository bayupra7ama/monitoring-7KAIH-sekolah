{{-- OTOMATIS MENYESUAIKAN LAYOUT (admin / guru / orangtua) --}}
@extends('layouts.' . auth()->user()->role)

@section('content')
<div class="max-w-2xl mx-auto mt-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-2">Ubah Password</h2>
    <p class="text-sm text-gray-500 mb-6">Pastikan akun Anda menggunakan password yang panjang dan acak agar tetap aman.</p>

    {{-- ALERT SUKSES --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4 font-semibold shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <form action="{{ route('password.update') }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Password Lama --}}
            <div class="mb-4">
                <label class="block text-sm font-bold text-gray-700 mb-2">Password Saat Ini</label>
                <input type="password" name="current_password" class="w-full border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500 shadow-sm" required>
                @error('current_password') 
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> 
                @enderror
            </div>

            {{-- Password Baru --}}
            <div class="mb-4">
                <label class="block text-sm font-bold text-gray-700 mb-2">Password Baru</label>
                <input type="password" name="password" class="w-full border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500 shadow-sm" required minlength="8">
                @error('password') 
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> 
                @enderror
            </div>

            {{-- Konfirmasi Password Baru --}}
            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" class="w-full border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500 shadow-sm" required minlength="8">
            </div>

            <div class="flex justify-end border-t pt-4">
                <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white font-bold py-2 px-6 rounded-lg transition-colors shadow-sm">
                    Simpan Password
                </button>
            </div>
        </form>
    </div>
</div>
@endsection