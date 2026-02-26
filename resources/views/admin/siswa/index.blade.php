@extends('layouts.admin')

@section('content')
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <h2 class="text-2xl font-bold text-gray-800">Daftar Siswa</h2>

        <div class="flex gap-2">
            {{-- FORM IMPORT EXCEL --}}
            <form action="{{ route('siswa.import') }}" method="POST" enctype="multipart/form-data"
                class="flex items-center gap-2 bg-white border rounded-lg px-2 py-1 shadow-sm">
                @csrf
                <input type="file" name="file" accept=".xlsx, .xls, .csv" required
                    class="text-sm text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 cursor-pointer w-48">
                <button type="submit"
                    class="bg-green-600 text-white text-sm font-bold px-3 py-1.5 rounded hover:bg-green-700 transition-colors flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                    </svg>
                    Import
                </button>
            </form>

            <a href="{{ route('siswa.create') }}"
                class="bg-indigo-600 text-white font-bold px-4 py-2 rounded-lg hover:bg-indigo-700 shadow-sm flex items-center">
                + Tambah Manual
            </a>
        </div>
    </div>

    {{-- ALERT SUKSES --}}
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4 shadow-sm">
            <span class="font-bold">Berhasil!</span> {{ session('success') }}
        </div>
    @endif

    {{-- ALERT ERROR --}}
    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4 shadow-sm">
            <span class="font-bold">Oops!</span> {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NISN</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Siswa
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($students as $item)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $item->nisn }}</td>
                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $item->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if ($item->class)
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    {{ $item->class->name }}
                                </span>
                            @else
                                <span class="text-red-500 text-xs">Belum masuk kelas</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('siswa.edit', $item->id) }}"
                                class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>

                            <form action="{{ route('siswa.destroy', $item->id) }}" method="POST" class="inline-block"
                                onsubmit="return confirm('Hapus siswa ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
