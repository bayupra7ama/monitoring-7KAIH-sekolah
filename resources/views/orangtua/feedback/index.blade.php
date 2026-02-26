@extends('layouts.orangtua')

@section('content')

<div class="max-w-3xl mx-auto">
    
    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Riwayat Feedback</h1>
        <p class="text-sm text-gray-500 mt-1">
            Daftar laporan perkembangan kebiasaan yang telah Anda kirimkan untuk buah hati.
        </p>
    </div>

    {{-- List Feedback --}}
    <div class="space-y-4">
        @forelse($feedbacks as $feedback)
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition-shadow relative overflow-hidden">
            
            {{-- Hiasan Garis Pinggir (Indikator) --}}
            <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-indigo-500"></div>

            <div class="pl-3"> {{-- Padding left extra biar gak kena garis hiasan --}}
                
                {{-- Baris Atas: Info Anak & Tanggal --}}
                <div class="flex justify-between items-center mb-3">
                    <div class="flex items-center gap-2">
                        {{-- Badge Nama Anak --}}
                        <div class="flex items-center bg-red-50 text-red-600 px-3 py-1 rounded-full border border-red-100">
                            <div class="h-5 w-5 rounded-full bg-red-200 flex items-center justify-center text-[10px] font-bold mr-2">
                                {{ substr($feedback->student->name, 0, 1) }}
                            </div>
                            <span class="text-xs font-bold">{{ $feedback->student->name }}</span>
                        </div>
                    </div>
                    <span class="text-[10px] text-gray-400 font-medium bg-gray-50 px-2 py-1 rounded">
                        {{ $feedback->created_at->isoFormat('D MMMM Y, H:mm') }}
                    </span>
                </div>

                {{-- Judul Materi --}}
                <div class="mb-2">
                    <a href="{{ route('orangtua.materi.show', $feedback->materi_id) }}" class="text-lg font-bold text-gray-800 hover:text-indigo-600 hover:underline">
                        {{ $feedback->materi->judul }}
                    </a>
                </div>

                {{-- Info Guru --}}
                <div class="flex items-center gap-2 mb-4 text-xs text-gray-500">
                    <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    <span>Guru: <span class="font-semibold text-gray-700">{{ $feedback->materi->guru->name ?? 'Admin' }}</span></span>
                </div>

                {{-- Kotak Isi Feedback --}}
                <div class="bg-gray-50 rounded-xl p-4 border border-gray-100 relative">
                    {{-- Icon Quote --}}
                    <svg class="absolute top-2 left-2 w-6 h-6 text-gray-200 -z-0" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21L14.017 18C14.017 16.0547 15.352 14.5029 17.0676 13.9182C16.8906 13.9292 16.7115 13.9352 16.5294 13.9352C13.7971 13.9352 11.5882 11.7263 11.5882 8.99405C11.5882 6.26182 13.7971 4.05292 16.5294 4.05292C19.2618 4.05292 21.4706 6.26182 21.4706 8.99405C21.4706 13.7711 17.5029 21 14.017 21ZM5.19412 21L5.19412 18C5.19412 16.0547 6.52906 14.5029 8.24424 13.9182C8.06729 13.9292 7.88824 13.9352 7.70588 13.9352C4.97365 13.9352 2.76471 11.7263 2.76471 8.99405C2.76471 6.26182 4.97365 4.05292 7.70588 4.05292C10.4381 4.05292 12.6471 6.26182 12.6471 8.99405C12.6471 13.7711 8.67941 21 5.19412 21Z"></path></svg>
                    
                    <div class="relative z-10 pl-6">
                        <p class="text-sm text-gray-600 italic">
                            "{{ $feedback->isi_feedback ?? 'Sudah diterapkan (Tanpa catatan tambahan)' }}"
                        </p>
                    </div>

                    {{-- Status Badge --}}
                    <div class="absolute right-3 top-3">
                        <span class="flex items-center text-[10px] font-bold text-green-600 bg-green-100 px-2 py-0.5 rounded-full border border-green-200">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            Terkirim
                        </span>
                    </div>
                </div>

            </div>
        </div>
        @empty
        <div class="text-center py-16 bg-white rounded-2xl border border-dashed border-gray-200">
            <div class="h-16 w-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900">Belum ada feedback</h3>
            <p class="text-gray-500 mt-1 max-w-xs mx-auto">Anda belum mengirimkan laporan kegiatan apapun. Yuk mulai cek materi anak!</p>
            <a href="{{ route('orangtua.dashboard') }}" class="inline-block mt-4 px-6 py-2 bg-indigo-600 text-white text-sm font-bold rounded-xl hover:bg-indigo-700 transition-colors">
                Ke Dashboard
            </a>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $feedbacks->links() }}
    </div>

</div>
@endsection