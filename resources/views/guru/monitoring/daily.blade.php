@extends('layouts.guru')

@section('content')
    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Monitoring Harian</h1>
            <p class="text-sm text-gray-500">Cek detail checklist siswa per hari</p>
        </div>

        {{-- Tombol Ganti Mode (Bulanan / Harian) --}}
        <div class="flex bg-gray-100 p-1 rounded-lg">
            <a href="{{ route('guru.monitoring.index') }}"
                class="px-4 py-2 text-sm font-medium text-gray-500 rounded-md hover:text-gray-700">
                Bulanan
            </a>
            <a href="{{ route('guru.monitoring.daily') }}"
                class="px-4 py-2 text-sm font-bold text-teal-700 bg-white shadow-sm rounded-md">
                Harian
            </a>
        </div>
    </div>

    {{-- Navigasi Tanggal --}}
    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 mb-6 flex justify-between items-center">
        <a href="{{ route('guru.monitoring.daily', ['date' => $tanggal->copy()->subDay()->format('Y-m-d')]) }}"
            class="p-2 hover:bg-gray-50 rounded-lg text-gray-500 hover:text-teal-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </a>

        <div class="text-center">
            <span class="block text-lg font-bold text-gray-800">{{ $tanggal->isoFormat('dddd, D MMMM Y') }}</span>
            @if ($tanggal->isToday())
                <span class="inline-block px-2 py-0.5 bg-green-100 text-green-700 text-xs font-bold rounded-full">Hari
                    Ini</span>
            @endif
        </div>

        @if ($tanggal->isToday())
            <span class="p-2 text-gray-200 cursor-not-allowed"><svg class="w-5 h-5" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg></span>
        @else
            <a href="{{ route('guru.monitoring.daily', ['date' => $tanggal->copy()->addDay()->format('Y-m-d')]) }}"
                class="p-2 hover:bg-gray-50 rounded-lg text-gray-500 hover:text-teal-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        @endif
    </div>

    {{-- Tabel Matriks Harian --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                    <tr>
                        <th class="px-4 py-4 font-semibold w-10">No</th>
                        <th class="px-4 py-4 font-semibold min-w-[150px]">Nama Siswa</th>
                        <th class="px-4 py-4 font-semibold text-center w-20">Status</th>

                        {{-- Loop Header 7 Kebiasaan (Pakai Icon biar muat) --}}
                        @foreach ($masterKebiasaans as $master)
                            <th class="px-2 py-4 font-semibold text-center" title="{{ $master->nama_kebiasaan }}">
                                <span class="text-lg">{{ $master->icon ?? '📝' }}</span>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($students as $index => $student)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-3 text-gray-400 text-xs text-center">{{ $index + 1 }}</td>
                            <td class="px-4 py-3">
                                <a href="{{ route('guru.monitoring.student', $student->id) }}" class="group">
                                    <span
                                        class="text-sm font-bold text-gray-700 group-hover:text-teal-600 transition-colors block">
                                        {{ $student->name }}
                                    </span>
                                    <span class="text-[10px] text-gray-400 group-hover:text-teal-500">Lihat Profil</span>
                                </a>
                            </td>

                            {{-- Kolom Status Pengisian --}}
                            <td class="px-4 py-3 text-center">
                                @if ($student->sudah_lapor)
                                    <span
                                        class="text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded-full">Isi</span>
                                @else
                                    <span
                                        class="text-xs font-bold text-red-500 bg-red-50 px-2 py-1 rounded-full">Kosong</span>
                                @endif
                            </td>

                            {{-- Loop Checklist Harian --}}
                            @foreach ($masterKebiasaans as $master)
                                <td class="px-2 py-3 text-center border-l border-gray-50">
                                    @php
                                        // Ambil status check dari array jurnal_harian
                                        $isChecked = $student->jurnal_harian[$master->id] ?? false;
                                    @endphp

                                    @if ($isChecked)
                                        <svg class="w-5 h-5 text-teal-500 mx-auto" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    @else
                                        <span class="text-gray-200 text-xl font-light">-</span>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="p-4 bg-gray-50 text-xs text-gray-500 flex justify-between">
            <span>* Arahkan mouse ke ikon untuk melihat nama kebiasaan.</span>
            <span>Total Siswa: {{ $students->count() }}</span>
        </div>
    </div>
@endsection
