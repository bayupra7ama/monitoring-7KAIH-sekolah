@extends('layouts.admin')

@section('content')
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <h2 class="text-2xl font-bold text-gray-800">Data Guru</h2>

        <div class="flex gap-2">
            {{-- FORM IMPORT EXCEL --}}
            <form action="{{ route('guru.import') }}" method="POST" enctype="multipart/form-data" class="flex items-center gap-2 bg-white border rounded-lg px-2 py-1 shadow-sm">
                @csrf
                <input type="file" name="file" accept=".xlsx, .xls, .csv" required class="text-sm text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 cursor-pointer w-48">
                <button type="submit" class="bg-green-600 text-white text-sm font-bold px-3 py-1.5 rounded hover:bg-green-700 transition-colors flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                    Import
                </button>
            </form>

            <a href="{{ route('guru.create') }}" class="bg-indigo-600 text-white font-bold px-4 py-2 rounded-lg hover:bg-indigo-700 shadow-sm flex items-center">
                + Tambah Manual
            </a>
        </div>
    </div>

    {{-- ALERT SUKSES --}}
    @if (session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
            <span class="block sm:inline font-bold">{{ session('success') }}</span>
        </div>
    @endif

    {{-- ALERT ERROR --}}
    @if (session('error'))
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Nama</th>
                        <th class="px-6 py-4 font-semibold">No HP (WA)</th>
                        <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($gurus as $guru)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <span class="font-bold text-gray-800">{{ $guru->name }}</span>
                            </td>
                            <td class="px-6 py-4 text-gray-600">{{ $guru->phone }}</td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="{{ route('guru.edit', $guru->id) }}" class="text-indigo-600 hover:underline text-sm font-bold">Edit</a>
                                <form action="{{ route('guru.destroy', $guru->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:underline text-sm font-bold" onclick="return confirm('Hapus guru ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection