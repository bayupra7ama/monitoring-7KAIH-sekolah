@extends('layouts.guru')

@section('content')
    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Monitoring Jurnal Karakter</h1>
            <p class="text-sm text-gray-500">Rekapitulasi kebiasaan siswa Kelas {{ $kelas->name }}</p>
        </div>

        <div class="flex flex-col md:flex-row gap-3">

            {{-- TOMBOL SWITCH MODE --}}
            <div class="flex bg-gray-100 p-1 rounded-lg self-start">
                <a href="{{ route('guru.monitoring.index') }}"
                    class="px-4 py-2 text-sm font-bold text-teal-700 bg-white shadow-sm rounded-md">
                    Bulanan
                </a>
                <a href="{{ route('guru.monitoring.daily') }}"
                    class="px-4 py-2 text-sm font-medium text-gray-500 rounded-md hover:text-gray-700">
                    Harian
                </a>
            </div>

            {{-- Filter Bulan (Yang lama) --}}
            <form action="{{ route('guru.monitoring.index') }}" method="GET"
                class="flex items-center gap-2 bg-white p-2 rounded-lg shadow-sm border border-gray-100">
                <select name="bulan"
                    class="border-none text-sm font-semibold text-gray-700 focus:ring-0 cursor-pointer bg-transparent">
                    @foreach (range(1, 12) as $m)
                        <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>
                            {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                        </option>
                    @endforeach
                </select>
                <span class="text-gray-300">|</span>
                <select name="tahun"
                    class="border-none text-sm font-semibold text-gray-700 focus:ring-0 cursor-pointer bg-transparent">
                    @foreach (range(date('Y'), date('Y') - 1) as $y)
                        <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="bg-teal-600 text-white p-2 rounded-md hover:bg-teal-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
            </form>

            <a href="{{ route('guru.monitoring.export', ['bulan' => $bulan, 'tahun' => $tahun]) }}"
                class="flex items-center gap-2 bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors shadow-sm font-bold text-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
                Export Excel
            </a>
        </div>

        {{-- Filter Bulan & Tahun --}}

    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                    <tr>
                        <th class="px-6 py-4 font-semibold">No</th>
                        <th class="px-6 py-4 font-semibold">Nama Siswa</th>
                        <th class="px-6 py-4 font-semibold text-center">Poin Kebiasaan</th>
                        <th class="px-6 py-4 font-semibold text-center">Persentase</th>
                        <th class="px-6 py-4 font-semibold text-center">Predikat</th>
                        <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($students as $index => $student)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-gray-400 text-xs font-bold">{{ $index + 1 }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div
                                        class="h-9 w-9 rounded-full bg-indigo-100 flex items-center justify-center text-sm font-bold text-indigo-600 mr-3">
                                        {{ substr($student->name, 0, 1) }}
                                    </div>
                                    <span class="text-sm font-bold text-gray-700">{{ $student->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-sm font-semibold text-gray-600">{{ $student->statistik->poin }}</span>
                                <span class="text-xs text-gray-400"> checklist</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <div class="w-24 bg-gray-200 rounded-full h-2">
                                        <div class="bg-teal-500 h-2 rounded-full"
                                            style="width: {{ $student->statistik->persentase }}%"></div>
                                    </div>
                                    <span
                                        class="text-xs font-bold text-gray-700">{{ $student->statistik->persentase }}%</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @php
                                    $p = $student->statistik->predikat;
                                    $color = match ($p) {
                                        'Sangat Baik' => 'bg-green-100 text-green-700 border-green-200',
                                        'Baik' => 'bg-blue-100 text-blue-700 border-blue-200',
                                        'Cukup' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                                        default => 'bg-red-100 text-red-700 border-red-200',
                                    };
                                @endphp
                                <span
                                    class="inline-block px-3 py-1 rounded-full text-[10px] font-bold border {{ $color }}">
                                    {{ $p }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('guru.monitoring.student', $student->id) }}"
                                    class="text-xs font-bold text-teal-600 hover:underline">
                                    Lihat Detail
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if ($students->isEmpty())
            <div class="p-12 text-center text-gray-400">
                <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                    </path>
                </svg>
                <p>Belum ada siswa di kelas Anda.</p>
            </div>
        @endif
    </div>
@endsection
