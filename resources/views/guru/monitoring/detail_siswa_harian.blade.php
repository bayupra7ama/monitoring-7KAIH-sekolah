@extends('layouts.guru')

@section('content')
    <div class="mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <a href="{{ route('guru.monitoring.index') }}"
                class="text-sm text-gray-500 hover:text-teal-600 flex items-center mb-2">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
                Kembali ke Rekap
            </a>
            <h1 class="text-2xl font-bold text-gray-800">Detail Jurnal Harian</h1>
            <p class="text-sm text-gray-500">Melihat aktivitas <span
                    class="font-bold text-teal-600">{{ $student->name }}</span></p>
        </div>

        <div class="flex flex-col md:flex-row gap-3 items-center">
            {{-- TOMBOL SWITCH MODE --}}
            <div class="flex bg-gray-100 p-1 rounded-lg">
                <a href="{{ route('guru.monitoring.student', $student->id) }}"
                    class="px-4 py-2 text-sm font-medium text-gray-500 rounded-md hover:text-gray-700">
                    Bulanan
                </a>
                <a href="{{ route('guru.monitoring.student.daily', $student->id) }}"
                    class="px-4 py-2 text-sm font-bold text-teal-700 bg-white shadow-sm rounded-md cursor-default">
                    Harian
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-3xl mx-auto">
        {{-- NAVIGASI TANGGAL (GAYA ORANG TUA) --}}
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 mb-6 flex justify-center">
            <div class="flex items-center bg-gray-50 rounded-full px-6 py-3 border border-gray-200 shadow-sm">
                {{-- TOMBOL MUNDUR --}}
                <a href="{{ route('guru.monitoring.student.daily', ['studentId' => $student->id, 'date' => $tanggal->copy()->subDay()->format('Y-m-d')]) }}"
                    class="text-gray-400 hover:text-teal-600 transition-colors p-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>

                {{-- TEKS TANGGAL --}}
                <div class="mx-6 text-center w-48">
                    <span class="block font-bold text-gray-800 text-base">
                        {{ $tanggal->isoFormat('dddd, D MMMM') }}
                    </span>
                    @if ($tanggal->isToday())
                        <span
                            class="text-[10px] text-green-600 font-bold bg-green-50 px-2 py-0.5 rounded-full mt-1 inline-block">Hari
                            Ini</span>
                    @else
                        <span class="text-[11px] text-gray-500 font-medium">{{ $tanggal->year }}</span>
                    @endif
                </div>

                {{-- TOMBOL MAJU --}}
                @if (!$tanggal->isToday())
                    <a href="{{ route('guru.monitoring.student.daily', ['studentId' => $student->id, 'date' => $tanggal->copy()->addDay()->format('Y-m-d')]) }}"
                        class="text-gray-400 hover:text-teal-600 transition-colors p-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                @else
                    <span class="text-gray-200 cursor-not-allowed p-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </span>
                @endif
            </div>
        </div>

        {{-- TABEL LAPORAN --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
            <table class="w-full text-left border-collapse">
                <thead class="bg-teal-50 text-teal-800 text-sm">
                    <tr>
                        <th class="px-6 py-4 font-semibold w-1/3">Kebiasaan</th>
                        <th class="px-6 py-4 font-semibold w-7/12">Detail Aktivitas Anak</th>
                        <th class="px-6 py-4 font-semibold w-1/12 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @php
                        // 1. CEK BATAS WAKTU (Apakah hari ini sudah lewat batas 5 hari?)
                        $batasBawah = \Carbon\Carbon::today()->subDays(5);
                        $isLewatBatas = $tanggal->startOfDay()->lt($batasBawah);

                        // 2. CEK APAKAH ADA MINIMAL 1 YANG DIISI DI HARI INI
                        $adaYangDiisi = false;
                        foreach ($jurnalHariIni as $j) {
                            if (!empty($j->keterangan)) {
                                $adaYangDiisi = true;
                                break;
                            }
                        }
                    @endphp

                    @foreach ($masterKebiasaans as $master)
                        @php
                            $jurnal = $jurnalHariIni[$master->id] ?? null;
                            $diisi = $jurnal && !empty($jurnal->keterangan);
                        @endphp
                        <tr class="hover:bg-gray-50 transition-colors">
                            {{-- Kolom Kebiasaan --}}
                            <td class="px-6 py-5 align-middle">
                                <div class="flex items-center">
                                    <span class="text-2xl mr-3">{{ $master->icon }}</span>
                                    <span class="font-bold text-gray-700">{{ $master->nama_kebiasaan }}</span>
                                </div>
                            </td>

                            {{-- Kolom Detail Tulisan Ortu --}}
                            <td class="px-6 py-5 align-middle">
                                @if ($diisi)
                                    <p
                                        class="text-sm font-medium text-gray-800 bg-gray-50 px-3 py-2 rounded-lg border border-gray-100">
                                        "{{ $jurnal->keterangan }}"
                                    </p>
                                @else
                                    @if ($adaYangDiisi || $isLewatBatas)
                                        <span class="text-sm text-red-400 italic font-medium">Tidak Dikerjakan.</span>
                                    @else
                                        <span class="text-sm text-gray-400 italic">Belum ada laporan (Masih bisa
                                            diisi)...</span>
                                    @endif
                                @endif
                            </td>

                            {{-- Kolom Status --}}
                            <td class="px-6 py-5 align-middle text-center">
                                @if ($diisi)
                                    @if ($jurnal->status)
                                        {{-- CENTANG HIJAU (Tepat Waktu) --}}
                                        <div class="flex justify-center items-center bg-green-100 text-green-600 rounded-full w-8 h-8 mx-auto"
                                            title="Dikerjakan dengan baik">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                    d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                    @else
                                        {{-- SILANG MERAH TERANG (Diisi, tapi gagal kriteria jam) --}}
                                        <div class="flex justify-center items-center bg-red-100 text-red-600 rounded-full w-8 h-8 mx-auto"
                                            title="Tidak Memenuhi Kriteria Waktu">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                    d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </div>
                                    @endif
                                @else
                                    @if ($adaYangDiisi || $isLewatBatas)
                                        {{-- SILANG MERAH PUCAT (Sengaja tidak dikerjakan / Sudah expired) --}}
                                        <div class="flex justify-center items-center bg-red-50 text-red-300 rounded-full w-8 h-8 mx-auto"
                                            title="Tidak Dikerjakan / Expired">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                    d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </div>
                                    @else
                                        {{-- STRIP ABU-ABU (Belum dinilai, masih ada waktu 5 hari) --}}
                                        <div class="flex justify-center items-center text-gray-300 w-8 h-8 mx-auto"
                                            title="Belum Diisi Orang Tua">
                                            <span class="text-2xl font-bold">-</span>
                                        </div>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
