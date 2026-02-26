@extends('layouts.guru')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('guru.materi.index') }}" class="text-gray-500 hover:text-gray-700 flex items-center gap-2 mb-2 text-sm font-medium">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar
        </a>
        <h1 class="text-2xl font-bold text-gray-800">Upload Materi Baru</h1>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sm:p-8">
        {{-- Error Validation --}}
        @if ($errors->any())
            <div class="bg-red-50 text-red-700 p-4 rounded-lg mb-6 border border-red-100">
                <p class="font-bold mb-1">Ada kesalahan input:</p>
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('guru.materi.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Input Judul --}}
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2" for="judul">Judul Materi <span class="text-red-500">*</span></label>
                <input type="text" name="judul" id="judul" value="{{ old('judul') }}"
                       class="w-full border-gray-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200 focus:ring-opacity-50 transition-colors py-2.5 px-4" 
                       placeholder="Contoh: Kebiasaan Bangun Pagi dan Merapikan Tempat Tidur" required>
            </div>

            {{-- Input Deskripsi --}}
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2" for="deskripsi">Teks Penjelasan / Deskripsi <span class="text-red-500">*</span></label>
                <textarea name="deskripsi" id="deskripsi" rows="6" 
                          class="w-full border-gray-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200 focus:ring-opacity-50 transition-colors py-2.5 px-4"
                          placeholder="Tuliskan materi pembelajaran atau instruksi untuk orang tua dan siswa disini..." required>{{ old('deskripsi') }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                {{-- Input File PDF --}}
                <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:bg-gray-50 transition-colors">
                    <div class="mb-3">
                        <svg class="mx-auto h-10 w-10 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    </div>
                    <label for="file_pdf" class="cursor-pointer">
                        <span class="block text-sm font-semibold text-gray-900">Upload Modul (PDF)</span>
                        <span class="block text-xs text-gray-500 mt-1">Max 10MB</span>
                        <input type="file" name="file_pdf" id="file_pdf" accept=".pdf" class="mt-3 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100">
                    </label>
                </div>

                {{-- Input Video --}}
                <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:bg-gray-50 transition-colors">
                    <div class="mb-3">
                        <svg class="mx-auto h-10 w-10 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                    </div>
                    <label for="video" class="cursor-pointer">
                        <span class="block text-sm font-semibold text-gray-900">Upload Video Edukasi</span>
                        <span class="block text-xs text-gray-500 mt-1">Format MP4 (Max 50MB)</span>
                        <input type="file" name="video" id="video" accept="video/mp4,video/quicktime" class="mt-3 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    </label>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('guru.materi.index') }}" class="px-6 py-2.5 rounded-lg border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-lg bg-teal-600 text-white font-medium hover:bg-teal-700 shadow-md transition-colors flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                    Simpan Materi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection