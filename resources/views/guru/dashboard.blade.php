@extends('layouts.guru')

@section('content')

<div class="bg-white rounded-xl shadow-sm p-6 mb-8 border-l-4 border-teal-500 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Selamat Datang, Bapak/Ibu {{ Auth::user()->name }}!</h1>
        <p class="text-gray-600 mt-1">Kelola materi kebiasaan baik dan pantau perkembangan siswa Anda di sini.</p>
    </div>
    <div class="hidden md:block">
        {{-- Icon Hiasan --}}
        <svg class="w-16 h-16 text-teal-100" fill="currentColor" viewBox="0 0 20 20"><path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"></path></svg>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    
    <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Wali Kelas</p>
                <p class="text-2xl font-bold text-gray-800">{{ $namaKelas }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Total Siswa</p>
                <p class="text-2xl font-bold text-gray-800">{{ $totalSiswa }} <span class="text-sm font-normal text-gray-400">Anak</span></p>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Materi Diupload</p>
                <p class="text-2xl font-bold text-gray-800">{{ $totalMateri }} <span class="text-sm font-normal text-gray-400">Topik</span></p>
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
        <h3 class="font-bold text-gray-800">Daftar Siswa Kelas {{ $namaKelas }}</h3>
        </div>
    <div class="p-0">
        @if($kelas && $kelas->students->count() > 0)
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                <tr>
                    <th class="px-6 py-3 font-medium">NISN</th>
                    <th class="px-6 py-3 font-medium">Nama Siswa</th>
                    <th class="px-6 py-3 font-medium text-right">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($kelas->students->take(5) as $student)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $student->nisn }}</td>
                    <td class="px-6 py-4 text-sm font-medium text-gray-800">{{ $student->name }}</td>
                    <td class="px-6 py-4 text-right">
                        <span class="inline-block px-2 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">Aktif</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @if($kelas->students->count() > 5)
            <div class="px-6 py-3 border-t text-center bg-gray-50">
                <span class="text-sm text-gray-500">Menampilkan 5 dari {{ $kelas->students->count() }} siswa</span>
            </div>
        @endif
        @else
            <div class="p-6 text-center text-gray-500">
                Belum ada data siswa di kelas ini.
            </div>
        @endif
    </div>
</div>

@endsection