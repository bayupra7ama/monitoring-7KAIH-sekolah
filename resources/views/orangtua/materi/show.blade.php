@extends('layouts.orangtua')

@section('content')

<div class="max-w-6xl mx-auto">
    
    {{-- Breadcrumb / Tombol Kembali --}}
    <div class="mb-6">
        <a href="{{ route('orangtua.dashboard') }}" class="inline-flex items-center text-gray-500 hover:text-indigo-600 font-medium transition-colors text-sm">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Dashboard
        </a>
    </div>

    <div class="flex flex-col lg:flex-row gap-8 items-start">

        {{-- KOLOM KIRI: KONTEN MATERI --}}
        <div class="flex-1 w-full">
            
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                
                {{-- 1. Video Player (Jika ada) --}}
                @if($materi->video)
                <div class="w-full aspect-video bg-black">
                    <video controls class="w-full h-full" controlsList="nodownload">
                        <source src="{{ Storage::url($materi->video) }}" type="video/mp4">
                        Browser Anda tidak mendukung pemutar video.
                    </video>
                </div>
                @endif

                <div class="p-6 md:p-8">
                    {{-- Header Materi --}}
                    <div class="flex flex-col md:flex-row md:items-start justify-between mb-6 gap-4">
                        <div>
                            <span class="inline-block px-3 py-1 bg-indigo-50 text-indigo-600 text-xs font-bold rounded-full mb-3">
                                Materi Pembiasaan
                            </span>
                            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 leading-tight mb-2">{{ $materi->judul }}</h1>
                            
                            {{-- Tanggal --}}
                            <p class="text-sm text-gray-400 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ $materi->created_at->isoFormat('D MMMM Y') }}
                            </p>
                        </div>

                        {{-- Avatar Guru --}}
                        <div class="flex items-center gap-3 md:block md:text-center bg-gray-50 md:bg-transparent p-3 md:p-0 rounded-xl">
                            <div class="h-10 w-10 md:mx-auto rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold mb-0 md:mb-1 border border-indigo-200">
                                {{ substr($materi->guru->name, 0, 1) }}
                            </div>
                            <div class="text-left md:text-center">
                                <p class="text-xs font-bold text-gray-700 md:text-gray-500">Guru Pengajar</p>
                                <p class="text-xs text-gray-500">{{ $materi->guru->name }}</p>
                            </div>
                        </div>
                    </div>

                    <hr class="border-gray-100 mb-6">

                    {{-- Isi Deskripsi --}}
                    <div class="prose max-w-none text-gray-600 leading-relaxed mb-8 text-sm md:text-base">
                        {!! nl2br(e($materi->deskripsi)) !!}
                    </div>

                    {{-- 2. File PDF (Jika ada) --}}
                    @if($materi->file_pdf)
                    <div class="bg-red-50 rounded-xl p-4 border border-red-100 flex items-center justify-between group hover:bg-red-100 transition-colors cursor-pointer" onclick="window.open('{{ Storage::url($materi->file_pdf) }}', '_blank')">
                        <div class="flex items-center gap-4">
                            <div class="h-12 w-12 bg-white rounded-lg flex items-center justify-center shadow-sm text-red-500 border border-red-100">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800 group-hover:text-red-700 text-sm md:text-base">Modul Pembelajaran (PDF)</h4>
                                <p class="text-xs text-red-400">Klik untuk membaca atau download</p>
                            </div>
                        </div>
                        <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4-4m0 0l-4 4m4-4v12"></path></svg>
                    </div>
                    @endif

                </div>
            </div>

        </div>

        {{-- KOLOM KANAN: FORM LAPORAN --}}
        <div class="w-full lg:w-96 shrink-0">
            
            <div class="bg-white rounded-3xl shadow-lg border border-indigo-100 p-6 sticky top-24">
                <div class="flex items-center mb-4">
                    <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center text-green-600 mr-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="font-bold text-gray-800 text-lg">Laporan Kebiasaan</h3>
                </div>
                
                <p class="text-sm text-gray-500 mb-6 leading-snug">
                    Tandai jika anak sudah menerapkan materi ini. Data akan tersimpan otomatis untuk evaluasi guru.
                </p>

                @if(session('success'))
                    <div class="bg-green-50 text-green-700 p-3 rounded-xl text-sm mb-4 border border-green-200 flex items-start">
                        <svg class="w-5 h-5 mr-2 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('orangtua.materi.feedback', $materi->id) }}" method="POST">
                    @csrf
                    
                    {{-- LOGIKA FILTER: Hanya tampilkan anak yang diajar oleh guru ini --}}
                    @php
                        $relevantChildren = $children->filter(function($child) use ($materi) {
                            return $child->class && $child->class->teacher_id == $materi->guru_id;
                        });
                    @endphp

                    {{-- Pilihan Anak --}}
                    <div class="space-y-3 mb-6">
                        @if($relevantChildren->isEmpty())
                            <div class="p-4 bg-yellow-50 text-yellow-700 text-sm rounded-xl border border-yellow-100 text-center">
                                <p>Materi ini tidak ditujukan untuk kelas anak Anda.</p>
                            </div>
                        @else
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 ml-1">Pilih Anak</label>
                            @foreach($relevantChildren as $child)
                                @php
                                    $isDone = isset($existingFeedbacks[$child->id]) && $existingFeedbacks[$child->id]->sudah_diterapkan;
                                @endphp
                                <label class="flex items-center justify-between p-3 rounded-xl border cursor-pointer transition-all {{ $isDone ? 'bg-green-50 border-green-200' : 'bg-gray-50 border-gray-100 hover:border-indigo-200 hover:shadow-sm' }}">
                                    <div class="flex items-center gap-3">
                                        <div class="h-9 w-9 rounded-full bg-indigo-100 flex items-center justify-center text-sm font-bold text-indigo-600 shadow-sm border border-white">
                                            {{ substr($child->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <span class="block text-sm font-bold text-gray-800">{{ $child->name }}</span>
                                            <span class="block text-[10px] {{ $isDone ? 'text-green-600 font-semibold' : 'text-gray-400' }}">
                                                {{ $isDone ? 'Sudah Menerapkan' : 'Klik untuk menandai' }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    {{-- Checkbox --}}
                                    <input type="checkbox" name="student_ids[]" value="{{ $child->id }}" 
                                        class="w-5 h-5 text-indigo-600 rounded focus:ring-indigo-500 border-gray-300 cursor-pointer"
                                        {{ $isDone ? 'checked disabled' : '' }}> 
                                </label>
                            @endforeach
                        @endif
                    </div>

                    {{-- Komentar / Catatan --}}
                    @if($relevantChildren->isNotEmpty())
                    <div class="mb-6">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Catatan Orang Tua (Opsional)</label>
                        <textarea name="isi_feedback" rows="3" class="w-full border-gray-200 rounded-xl text-sm focus:border-indigo-500 focus:ring-indigo-200 placeholder-gray-400" placeholder="Contoh: Alhamdulillah, Ananda sangat antusias..."></textarea>
                    </div>

                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-xl shadow-md transition-all transform hover:scale-[1.02] flex justify-center items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                        Kirim Laporan
                    </button>
                    @endif
                </form>

            </div>

        </div>

    </div>
</div>
@endsection