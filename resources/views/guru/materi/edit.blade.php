@extends('layouts.guru')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('guru.materi.index') }}" class="text-gray-500 hover:text-gray-700 flex items-center gap-2 mb-2 text-sm font-medium">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar
        </a>
        <h1 class="text-2xl font-bold text-gray-800">Edit Materi</h1>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sm:p-8">
        @if ($errors->any())
            <div class="bg-red-50 text-red-700 p-4 rounded-lg mb-6 border border-red-100">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('guru.materi.update', $materi->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Input Judul --}}
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2" for="judul">Judul Materi <span class="text-red-500">*</span></label>
                <input type="text" name="judul" id="judul" value="{{ old('judul', $materi->judul) }}"
                       class="w-full border-gray-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200 focus:ring-opacity-50 transition-colors py-2.5 px-4" required>
            </div>

            {{-- Input Deskripsi --}}
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2" for="deskripsi">Teks Penjelasan / Deskripsi <span class="text-red-500">*</span></label>
                <textarea name="deskripsi" id="deskripsi" rows="6" 
                          class="w-full border-gray-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200 focus:ring-opacity-50 transition-colors py-2.5 px-4"
                          required>{{ old('deskripsi', $materi->deskripsi) }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                {{-- Input File PDF --}}
                <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:bg-gray-50 transition-colors relative">
                    <div class="mb-3">
                        <svg class="mx-auto h-10 w-10 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    </div>
                    <label for="file_pdf" class="cursor-pointer">
                        <span class="block text-sm font-semibold text-gray-900">Ganti Modul (PDF)</span>
                        <span class="block text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengubah</span>
                        <input type="file" name="file_pdf" id="file_pdf" accept=".pdf" class="mt-3 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100">
                    </label>
                    
                    {{-- Status File Lama --}}
                    @if($materi->file_pdf)
                        <div class="mt-4 p-2 bg-green-50 rounded border border-green-100 text-xs text-green-700 flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            File PDF tersimpan. <a href="{{ Storage::url($materi->file_pdf) }}" target="_blank" class="underline font-bold">Cek File</a>
                        </div>
                    @else
                        <div class="mt-4 p-2 bg-gray-100 rounded border border-gray-200 text-xs text-gray-500">
                            Tidak ada PDF sebelumnya.
                        </div>
                    @endif
                </div>

                {{-- Input Video --}}
                <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:bg-gray-50 transition-colors">
                    <div class="mb-3">
                        <svg class="mx-auto h-10 w-10 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                    </div>
                    <label for="video" class="cursor-pointer">
                        <span class="block text-sm font-semibold text-gray-900">Ganti Video</span>
                        <span class="block text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengubah</span>
                        <input type="file" name="video" id="video" accept="video/mp4,video/quicktime" class="mt-3 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    </label>

                    {{-- Status Video Lama --}}
                    @if($materi->video)
                        <div class="mt-4 p-2 bg-green-50 rounded border border-green-100 text-xs text-green-700 flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Video tersimpan. <a href="{{ Storage::url($materi->video) }}" target="_blank" class="underline font-bold">Cek Video</a>
                        </div>
                    @else
                        <div class="mt-4 p-2 bg-gray-100 rounded border border-gray-200 text-xs text-gray-500">
                            Tidak ada Video sebelumnya.
                        </div>
                    @endif
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('guru.materi.index') }}" class="px-6 py-2.5 rounded-lg border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-lg bg-teal-600 text-white font-medium hover:bg-teal-700 shadow-md transition-colors flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    Update Materi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection