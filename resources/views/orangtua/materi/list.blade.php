@extends('layouts.orangtua')

@section('content')

<div class="max-w-4xl mx-auto">
    
    {{-- Header --}}
    <div class="mb-6 flex items-center justify-between">
        <div>
            <a href="{{ route('orangtua.dashboard') }}" class="flex items-center text-gray-500 hover:text-indigo-600 text-sm font-medium mb-2 transition-colors">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                Kembali ke Dashboard
            </a>
            <h1 class="text-2xl font-bold text-gray-800">Materi Pembelajaran</h1>
            <p class="text-sm text-gray-500 mt-1">
                Daftar lengkap materi untuk <span class="font-bold text-indigo-600">{{ $anak->name }}</span> (Kelas {{ $anak->class->name }})
            </p>
        </div>
        
        {{-- Avatar Anak (Hiasan Kanan) --}}
        <div class="hidden sm:flex h-12 w-12 bg-indigo-100 rounded-full items-center justify-center text-indigo-600 font-bold text-xl">
            {{ substr($anak->name, 0, 1) }}
        </div>
    </div>

    {{-- List Materi --}}
    <div class="space-y-4">
        @forelse($materis as $materi)
        <a href="{{ route('orangtua.materi.show', $materi->id) }}" class="block group">
            <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 hover:shadow-md hover:border-indigo-200 transition-all flex items-start gap-4">
                
                {{-- Icon Materi --}}
                <div class="h-12 w-12 rounded-full bg-teal-50 text-teal-600 flex items-center justify-center shrink-0 group-hover:bg-teal-100 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>

                <div class="flex-1 min-w-0">
                    <div class="flex justify-between items-start">
                        <h3 class="text-base font-bold text-gray-800 group-hover:text-indigo-600 truncate pr-4">
                            {{ $materi->judul }}
                        </h3>
                        
                        {{-- Tanggal --}}
                        <span class="text-xs text-gray-400 whitespace-nowrap">
                            {{ $materi->created_at->format('d M Y') }}
                        </span>
                    </div>
                    
                    <p class="text-sm text-gray-500 line-clamp-2 mt-1">
                        {{ $materi->deskripsi }}
                    </p>

                    {{-- Footer Card: Badges & Status --}}
                    <div class="flex items-center justify-between mt-3 pt-3 border-t border-gray-50">
                        <div class="flex gap-2">
                            @if($materi->file_pdf)
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-red-50 text-red-700">
                                    PDF
                                </span>
                            @endif
                            @if($materi->video)
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-indigo-50 text-indigo-700">
                                    Video
                                </span>
                            @endif
                        </div>

                        {{-- Status Penerapan --}}
                        @if($materi->feedbacks->where('sudah_diterapkan', true)->isNotEmpty())
                            <div class="flex items-center text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded-lg">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Selesai
                            </div>
                        @else
                            <div class="flex items-center text-xs font-medium text-gray-400">
                                Belum Diterapkan
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </a>
        @empty
        <div class="text-center py-12 bg-white rounded-xl border border-dashed border-gray-200">
            <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada materi</h3>
            <p class="mt-1 text-sm text-gray-500">Guru belum mengupload materi untuk kelas ini.</p>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $materis->links() }}
    </div>

</div>
@endsection