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
            <h1 class="text-2xl font-bold text-gray-800">Rapor Jurnal Siswa</h1>
            <p class="text-sm text-gray-500">Detail perkembangan karakter <span
                    class="font-bold text-teal-600">{{ $student->name }}</span></p>
        </div>

        <div class="flex bg-gray-100 p-1 rounded-lg">
            <a href="{{ route('guru.monitoring.student', $student->id) }}"
                class="px-4 py-2 text-sm font-bold text-teal-700 bg-white shadow-sm rounded-md cursor-default">
                Bulanan
            </a>
            <a href="{{ route('guru.monitoring.student.daily', $student->id) }}"
                class="px-4 py-2 text-sm font-medium text-gray-500 rounded-md hover:text-gray-700">
                Harian
            </a>
        </div>

        <a href="{{ route('guru.monitoring.student.export', ['studentId' => $student->id, 'bulan' => $bulan, 'tahun' => $tahun]) }}"
            class="flex items-center gap-2 bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors shadow-sm font-bold text-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                </path>
            </svg>
            Cetak Jurnal
        </a>

       
        <form action="{{ route('guru.monitoring.student', $student->id) }}" method="GET"
            class="flex items-center gap-2 bg-white p-2 rounded-lg shadow-sm border border-gray-100">
            <select name="bulan"
                class="border-none text-sm font-semibold text-gray-700 focus:ring-0 cursor-pointer bg-transparent">
                @foreach (range(1, 12) as $m)
                    <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>
                        {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                    </option>
                @endforeach
            </select>
            <select name="tahun"
                class="border-none text-sm font-semibold text-gray-700 focus:ring-0 cursor-pointer bg-transparent">
                @foreach (range(date('Y'), date('Y') - 1) as $y)
                    <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endforeach
            </select>
            <button type="submit" class="bg-teal-600 text-white p-2 rounded-md hover:bg-teal-700 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </button>
        </form>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- BAGIAN 1: ANALISIS KEKUATAN (Statistik Per Kebiasaan) --}}
        <div class="lg:col-span-1 space-y-4">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h3 class="font-bold text-gray-800 mb-4 border-b border-gray-100 pb-2">Analisis Kebiasaan</h3>

                <div class="space-y-4">
                    @foreach ($masterKebiasaans as $master)
                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-xs font-semibold text-gray-600 flex items-center">
                                    <span class="mr-2 text-base">{{ $master->icon }}</span> {{ $master->nama_kebiasaan }}
                                </span>
                                <span class="text-xs font-bold text-gray-800">{{ $master->persentase }}%</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2">
                                <div class="{{ $master->color }} h-2 rounded-full"
                                    style="width: {{ $master->persentase }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Card Kesimpulan --}}
            <div class="bg-teal-50 p-6 rounded-xl border border-teal-100">
                <h4 class="font-bold text-teal-800 text-sm mb-2">Catatan Guru:</h4>
                <p class="text-xs text-teal-600 leading-relaxed">
                    Evaluasi berdasarkan data bulan ini. Siswa sangat baik dalam
                    <strong>{{ $masterKebiasaans->sortByDesc('persentase')->first()->nama_kebiasaan }}</strong>, namun
                    perlu ditingkatkan dalam
                    <strong>{{ $masterKebiasaans->sortBy('persentase')->first()->nama_kebiasaan }}</strong>.
                </p>
            </div>
        </div>

        {{-- BAGIAN 2: KALENDER TABEL (Detail Harian) --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-50 bg-gray-50">
                    <h3 class="font-bold text-gray-800">Detail Harian (Tanggal 1 - {{ count($calendarData) }})</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                            <tr>
                                <th class="px-4 py-3 font-semibold w-16 text-center">Tgl</th>
                                @foreach ($masterKebiasaans as $master)
                                    <th class="px-2 py-3 text-center" title="{{ $master->nama_kebiasaan }}">
                                        {{ $master->icon }}
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($calendarData as $day => $data)
                                <tr
                                    class="hover:bg-gray-50 transition-colors {{ $data['date']->isWeekend() ? 'bg-red-50/30' : '' }}">
                                    <td class="px-4 py-2 text-center">
                                        <span class="block text-sm font-bold text-gray-700">{{ $day }}</span>
                                        <span
                                            class="block text-[9px] text-gray-400 uppercase">{{ $data['date']->isoFormat('ddd') }}</span>
                                    </td>

                                    @php
                                        // 1. CEK BATAS WAKTU (Apakah tanggal di baris ini sudah lewat batas 5 hari?)
                                        $tanggalKalender = $data['date']->copy();
                                        $batasBawah = \Carbon\Carbon::today()->subDays(5);
                                        $isLewatBatas = $tanggalKalender->startOfDay()->lt($batasBawah);

                                        // 2. CEK APAKAH ADA MINIMAL 1 YANG DIISI PADA HARI TERSEBUT
                                        $adaYangDiisi = false;
                                        foreach ($data['jurnals'] as $j) {
                                            if (!empty($j->keterangan)) {
                                                $adaYangDiisi = true;
                                                break;
                                            }
                                        }
                                    @endphp

                                    @foreach ($masterKebiasaans as $master)
                                        <td class="px-1 py-2 text-center border-l border-gray-50 align-top">
                                            @php
                                                // Cari data jurnal untuk kebiasaan ini
                                                $jurnalHariIni = $data['jurnals'][$master->id] ?? null;
                                                $diisi = $jurnalHariIni && !empty($jurnalHariIni->keterangan);
                                            @endphp

                                            @if ($diisi)
                                                {{-- JIKA ORANG TUA MENGISI DATA --}}
                                                <div title="{{ $jurnalHariIni->keterangan }}"
                                                    class="cursor-help flex flex-col items-center justify-center">

                                                    @if ($jurnalHariIni->status)
                                                        {{-- Status True -> Centang Hijau --}}
                                                        <svg class="w-4 h-4 text-green-500 mb-0.5" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="3" d="M5 13l4 4L19 7"></path>
                                                        </svg>
                                                    @else
                                                        {{-- Status False (Tidak Sesuai Jam) -> Silang Merah Terang --}}
                                                        <svg class="w-4 h-4 text-red-500 mb-0.5" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="3" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                    @endif

                                                    {{-- Potongan Teks Keterangan (Agar tabel tetap ramping) --}}
                                                    <span
                                                        class="text-[9px] font-medium {{ $jurnalHariIni->status ? 'text-green-700' : 'text-red-700' }} bg-gray-50 px-1 rounded block max-w-[45px] truncate">
                                                        {{ $jurnalHariIni->keterangan }}
                                                    </span>
                                                </div>
                                            @else
                                                {{-- JIKA KOSONG --}}
                                                @if ($adaYangDiisi || $isLewatBatas)
                                                    {{-- Sengaja Dikosongkan / Expired -> Silang Merah Pucat --}}
                                                    <div class="flex h-full items-center justify-center pt-2"
                                                        title="Tidak Dikerjakan / Expired">
                                                        <svg class="w-4 h-4 text-red-300" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="3" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                    </div>
                                                @else
                                                    {{-- Masih Ada Waktu 5 Hari & Belum Diisi -> Strip Abu-abu --}}
                                                    <div class="flex h-full items-center justify-center pt-1"
                                                        title="Belum Diisi">
                                                        <span class="text-gray-300 text-lg font-bold">-</span>
                                                    </div>
                                                @endif
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection
