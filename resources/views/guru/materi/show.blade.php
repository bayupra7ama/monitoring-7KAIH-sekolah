@extends('layouts.guru')

@section('content')

<div class="mb-6">
    <a href="{{ route('guru.materi.index') }}" class="flex items-center text-gray-500 hover:text-teal-600 transition-colors">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Daftar Materi
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    {{-- KOLOM KIRI: INFO MATERI & STATISTIK --}}
    <div class="lg:col-span-1 space-y-6">
        
        {{-- Card Materi --}}
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <span class="text-xs font-bold text-teal-600 bg-teal-50 px-3 py-1 rounded-full">Detail Materi</span>
            <h1 class="text-xl font-bold text-gray-800 mt-3 mb-2">{{ $materi->judul }}</h1>
            <p class="text-sm text-gray-500 mb-4">{{ $materi->created_at->format('d M Y, H:i') }}</p>
            
            <div class="text-sm text-gray-600 leading-relaxed mb-4 line-clamp-4">
                {{ $materi->deskripsi }}
            </div>

            <div class="flex gap-2">
                @if($materi->file_pdf)
                    <a href="{{ Storage::url($materi->file_pdf) }}" target="_blank" class="flex-1 bg-red-50 text-red-600 py-2 rounded-lg text-xs font-bold text-center hover:bg-red-100 transition-colors">
                        Lihat PDF
                    </a>
                @endif
                @if($materi->video)
                    <a href="{{ Storage::url($materi->video) }}" target="_blank" class="flex-1 bg-indigo-50 text-indigo-600 py-2 rounded-lg text-xs font-bold text-center hover:bg-indigo-100 transition-colors">
                        Lihat Video
                    </a>
                @endif
            </div>
        </div>

        {{-- Card Statistik Kelas --}}
        <div class="bg-gradient-to-br from-teal-500 to-teal-700 rounded-xl shadow-lg p-6 text-white">
            <h3 class="font-semibold text-teal-100 mb-1">Progress Kelas</h3>
            <div class="flex items-end gap-2 mb-4">
                <span class="text-4xl font-bold">{{ $sudahMengerjakan }}</span>
                <span class="text-sm text-teal-100 mb-1">dari {{ $totalSiswa }} Siswa</span>
            </div>

            {{-- Progress Bar --}}
            <div class="w-full bg-teal-800/30 rounded-full h-2.5 mb-2">
                <div class="bg-white h-2.5 rounded-full transition-all duration-1000" style="width: {{ $persentase }}%"></div>
            </div>
            <p class="text-xs text-right text-teal-100">{{ $persentase }}% Sudah Menerapkan</p>
        </div>

    </div>

    {{-- KOLOM KANAN: DAFTAR SISWA & FEEDBACK --}}
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-50 bg-gray-50 flex justify-between items-center">
                <h3 class="font-bold text-gray-800">Laporan Aktivitas Siswa</h3>
                <span class="text-xs text-gray-500">Urut berdasarkan Absen</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                        <tr>
                            <th class="px-6 py-3 font-semibold">Nama Siswa</th>
                            <th class="px-6 py-3 font-semibold text-center">Status</th>
                            <th class="px-6 py-3 font-semibold">Catatan Orang Tua</th>
                            <th class="px-6 py-3 font-semibold text-right">Waktu Lapor</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($students as $student)
                            @php
                                // Ambil feedback pertama (jika ada) karena relasi hasMany
                                $feedback = $student->feedbacks->first();
                                $isDone = $feedback && $feedback->sudah_diterapkan;
                            @endphp
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center text-xs font-bold text-gray-500 mr-3">
                                        {{ substr($student->name, 0, 1) }}
                                    </div>
                                    <span class="text-sm font-medium text-gray-800">{{ $student->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($isDone)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                        Sudah
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-400">
                                        Belum
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                @if($isDone && $feedback->isi_feedback)
                                    <div class="bg-yellow-50 p-2 rounded-lg border border-yellow-100 italic text-xs text-gray-600 max-w-xs">
                                        "{{ $feedback->isi_feedback }}"
                                    </div>
                                @elseif($isDone)
                                    <span class="text-xs text-gray-400 italic">- Tidak ada catatan -</span>
                                @else
                                    <span class="text-xs text-gray-300">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right text-xs text-gray-500">
                                @if($isDone)
                                    {{ $feedback->created_at->diffForHumans() }}
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if($students->isEmpty())
                <div class="p-8 text-center text-gray-400">
                    Belum ada siswa di kelas Anda.
                </div>
            @endif
        </div>
    </div>
</div>

@endsection