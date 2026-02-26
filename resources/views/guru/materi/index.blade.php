@extends('layouts.guru')

@section('content')

    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Kelola Materi</h1>
            <p class="text-gray-600 text-sm">Upload bahan ajar, modul PDF, dan video edukasi.</p>
        </div>
        <a href="{{ route('guru.materi.create') }}"
            class="bg-teal-600 hover:bg-teal-700 text-white px-5 py-2.5 rounded-lg shadow-sm font-medium flex items-center transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Upload Materi
        </a>
    </div>

    {{-- Alert Success --}}
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
        @if ($materis->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50 text-gray-500 text-xs uppercase border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 font-semibold">Judul & Deskripsi</th>
                            <th class="px-6 py-4 font-semibold text-center">Lampiran</th>
                            <th class="px-6 py-4 font-semibold">Tanggal Upload</th>
                            <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($materis as $materi)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 align-top">
                                    {{-- Tambahkan Link ke SHOW --}}
                                    <a href="{{ route('guru.materi.show', $materi->id) }}"
                                        class="hover:text-teal-600 transition-colors">
                                        <h3 class="text-gray-900 font-bold text-base mb-1">{{ $materi->judul }}</h3>
                                    </a>
                                    <p class="text-gray-500 text-sm line-clamp-2">{{ $materi->deskripsi }}</p>

                                    <a href="{{ route('guru.materi.show', $materi->id) }}"
                                        class="inline-flex items-center mt-2 text-xs font-bold text-teal-600 hover:underline">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                                            </path>
                                        </svg>
                                        Lihat Laporan Siswa
                                    </a>
                                </td>
                                <td class="px-6 py-4 align-top text-center">
                                    <div class="flex justify-center gap-2">
                                        {{-- Badge PDF --}}
                                        @if ($materi->file_pdf)
                                            <a href="{{ Storage::url($materi->file_pdf) }}" target="_blank"
                                                class="flex flex-col items-center group" title="Download PDF">
                                                <div
                                                    class="p-2 bg-red-100 text-red-600 rounded-lg group-hover:bg-red-200 transition-colors">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                                        </path>
                                                    </svg>
                                                </div>
                                                <span class="text-[10px] font-bold text-red-600 mt-1">PDF</span>
                                            </a>
                                        @else
                                            <span class="opacity-30 flex flex-col items-center">
                                                <div class="p-2 bg-gray-100 text-gray-400 rounded-lg">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                        </path>
                                                    </svg>
                                                </div>
                                            </span>
                                        @endif

                                        {{-- Badge Video --}}
                                        @if ($materi->video)
                                            <a href="{{ Storage::url($materi->video) }}" target="_blank"
                                                class="flex flex-col items-center group" title="Tonton Video">
                                                <div
                                                    class="p-2 bg-indigo-100 text-indigo-600 rounded-lg group-hover:bg-indigo-200 transition-colors">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z">
                                                        </path>
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                </div>
                                                <span class="text-[10px] font-bold text-indigo-600 mt-1">VIDEO</span>
                                            </a>
                                        @else
                                            <span class="opacity-30 flex flex-col items-center">
                                                <div class="p-2 bg-gray-100 text-gray-400 rounded-lg">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                                                        </path>
                                                    </svg>
                                                </div>
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 align-top text-sm text-gray-500">
                                    {{ $materi->created_at->format('d M Y') }} <br>
                                    <span class="text-xs">{{ $materi->created_at->format('H:i') }} WIB</span>
                                </td>
                                <td class="px-6 py-4 align-top text-right">
                                    <div class="flex justify-end gap-3">
                                        <a href="{{ route('guru.materi.edit', $materi->id) }}"
                                            class="text-teal-600 hover:text-teal-800 font-medium text-sm">Edit</a>
                                        <form action="{{ route('guru.materi.destroy', $materi->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus materi ini? File yang terlampir juga akan dihapus.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-600 hover:text-red-800 font-medium text-sm">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-12 text-center flex flex-col items-center justify-center">
                <div class="p-4 bg-gray-100 rounded-full mb-4">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900">Belum ada materi</h3>
                <p class="text-gray-500 mt-1 mb-6">Mulai upload materi kebiasaan untuk siswa Anda.</p>
                <a href="{{ route('guru.materi.create') }}"
                    class="bg-teal-600 hover:bg-teal-700 text-white px-5 py-2 rounded-lg shadow-sm font-medium">
                    Upload Materi Pertama
                </a>
            </div>
        @endif
    </div>
@endsection
