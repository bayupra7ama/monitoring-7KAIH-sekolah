@extends('layouts.orangtua')

@section('content')
    <div class="max-w-2xl mx-auto">

        {{-- Header & Navigasi Tanggal --}}
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 mb-6">
            <div class="flex justify-between items-center mb-4">
                <a href="{{ route('orangtua.dashboard') }}" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <h1 class="text-lg font-bold text-gray-800">Jurnal Harian</h1>
                <div class="w-6"></div> {{-- Spacer biar text tengah --}}
            </div>

            <div class="flex flex-col items-center">
                <div
                    class="h-16 w-16 bg-red-100 rounded-full flex items-center justify-center text-red-500 text-2xl font-bold mb-2">
                    {{ substr($anak->name, 0, 1) }}
                </div>
                <h2 class="font-bold text-gray-800">{{ $anak->name }}</h2>

                {{-- Form Ganti Tanggal --}}
                {{-- Form Ganti Tanggal --}}
                <form action="{{ route('orangtua.jurnal.index', $anak->id) }}" method="GET"
                    class="mt-4 flex items-center bg-gray-50 rounded-full px-4 py-2 border border-gray-200">

                    {{-- TOMBOL MUNDUR (KIRI) --}}
                    @if ($tanggal->gt($batasBawah))
                        {{-- Kalau tanggal masih lebih besar dari batas bawah, boleh mundur --}}
                        <a href="{{ route('orangtua.jurnal.index', ['studentId' => $anak->id, 'date' => $tanggal->copy()->subDay()->format('Y-m-d')]) }}"
                            class="text-gray-400 hover:text-indigo-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                                </path>
                            </svg>
                        </a>
                    @else
                        {{-- Kalau sudah mentok 5 hari, matikan tombol --}}
                        <span class="text-gray-200 cursor-not-allowed" title="Maksimal mundur 5 hari">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                                </path>
                            </svg>
                        </span>
                    @endif

                    {{-- Teks Tanggal --}}
                    <div class="mx-4 text-center">
                        <span class="block font-bold text-gray-700 text-sm">
                            {{ $tanggal->isoFormat('dddd, D MMMM') }}
                        </span>
                        @if ($tanggal->isToday())
                            <span class="text-[10px] text-green-600 font-bold bg-green-50 px-2 py-0.5 rounded-full">Hari
                                Ini</span>
                        @else
                            <span class="text-[10px] text-gray-400">
                                {{ $tanggal->diffForHumans() }}
                            </span>
                        @endif
                    </div>

                    {{-- TOMBOL MAJU (KANAN) --}}
                    @if (!$tanggal->isToday())
                        <a href="{{ route('orangtua.jurnal.index', ['studentId' => $anak->id, 'date' => $tanggal->copy()->addDay()->format('Y-m-d')]) }}"
                            class="text-gray-400 hover:text-indigo-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </a>
                    @else
                        <span class="text-gray-200 cursor-not-allowed">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </span>
                    @endif
                </form>
            </div>
        </div>

        {{-- Form Checklist --}}
        {{-- Form Checklist Model Tabel --}}
        <form action="{{ route('orangtua.jurnal.store', $anak->id) }}" method="POST">
            @csrf
            <input type="hidden" name="tanggal" value="{{ $tanggal->format('Y-m-d') }}">

            {{-- BANNER PETUNJUK (BARU) --}}
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-4 rounded-r-xl shadow-sm">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-800 leading-relaxed">
                            <strong>Petunjuk:</strong> Isi detail sesuai aktivitas anak hari ini. <br>
                            <span class="font-semibold text-blue-600">Biarkan kosong (jangan diisi)</span> jika anak tidak
                            mengerjakan kebiasaan tersebut.
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-indigo-50 text-indigo-800 text-sm">
                        <tr>
                            <th class="px-4 py-3 font-semibold rounded-tl-2xl w-1/3">Kebiasaan</th>
                            {{-- TAMBAHAN SUB-TEKS DI HEADER KOLOM --}}
                            <th class="px-4 py-3 font-semibold rounded-tr-2xl w-2/3">
                                Detail Aktivitas
                                <span class="block text-xs font-normal text-indigo-500 mt-0.5">* Kosongkan jika tidak
                                    dikerjakan</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($kebiasaans as $kebiasaan)
                            @php
                                $existing = $existingJurnal[$kebiasaan->id] ?? null;
                                $isiKeterangan = $existing ? $existing->keterangan : '';
                            @endphp
                            <tr class="hover:bg-gray-50 transition-colors">
                                {{-- Kolom Nama Kebiasaan --}}
                                <td class="px-4 py-4 align-middle">
                                    <div class="flex items-center">
                                        <span class="text-2xl mr-3">{{ $kebiasaan->icon }}</span>
                                        <span
                                            class="font-bold text-gray-700 text-sm">{{ $kebiasaan->nama_kebiasaan }}</span>
                                    </div>
                                </td>

                                {{-- Kolom Inputan --}}
                                <td class="px-4 py-4 align-middle">
                                    {{-- Kustomisasi Tipe Input Berdasarkan Nama Kebiasaan --}}
                                    @if ($kebiasaan->nama_kebiasaan == 'Bangun pagi' || $kebiasaan->nama_kebiasaan == 'Tidur cepat')
                                        <input type="time" name="keterangan[{{ $kebiasaan->id }}]"
                                            value="{{ $isiKeterangan }}"
                                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                                            placeholder="Contoh: 05:00">
                                    @elseif($kebiasaan->nama_kebiasaan == 'Beribadah')
                                        <input type="text" name="keterangan[{{ $kebiasaan->id }}]"
                                            value="{{ $isiKeterangan }}"
                                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                                            placeholder="Contoh: Sholat Subuh & Maghrib">
                                    @elseif($kebiasaan->nama_kebiasaan == 'Makan sehat dan bergizi')
                                        <input type="text" name="keterangan[{{ $kebiasaan->id }}]"
                                            value="{{ $isiKeterangan }}"
                                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                                            placeholder="Contoh: Nasi, Sayur Bayam, Telur rebus">
                                    @elseif($kebiasaan->nama_kebiasaan == 'Berolahraga')
                                        <input type="text" name="keterangan[{{ $kebiasaan->id }}]"
                                            value="{{ $isiKeterangan }}"
                                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                                            placeholder="Contoh: Lari pagi 15 menit">
                                    @else
                                        <input type="text" name="keterangan[{{ $kebiasaan->id }}]"
                                            value="{{ $isiKeterangan }}"
                                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                                            placeholder="Tulis aktivitas anak di sini...">
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <button type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 rounded-2xl shadow-lg shadow-indigo-200 transition-all transform hover:scale-[1.02] flex items-center justify-center">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Simpan Jurnal Hari Ini
            </button>
        </form>

    </div>



    {{-- Alert Sukses --}}
    @if (session('success'))
        <div
            class="fixed bottom-6 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white px-6 py-3 rounded-full shadow-xl flex items-center z-50 animate-bounce">
            <svg class="w-5 h-5 mr-2 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Alert Error (Jika maksa ganti tanggal lewat URL) --}}
    @if (session('error'))
        <div
            class="fixed top-24 left-1/2 transform -translate-x-1/2 bg-red-500 text-white px-6 py-3 rounded-full shadow-xl flex items-center z-50 animate-bounce">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            {{ session('error') }}
        </div>
    @endif
@endsection
