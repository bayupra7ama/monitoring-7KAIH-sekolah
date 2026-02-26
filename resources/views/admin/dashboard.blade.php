@extends('layouts.admin')

@section('content')

<h2 class="text-2xl font-bold mb-6">Dashboard Admin</h2>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <div class="bg-white rounded shadow p-5">
        <p class="text-gray-500 text-sm">Total Guru</p>
        <p class="text-2xl font-bold mt-2">{{ $totalGuru }}</p>
    </div>

    <div class="bg-white rounded shadow p-5">
        <p class="text-gray-500 text-sm">Total Orang Tua</p>
        <p class="text-2xl font-bold mt-2">{{ $totalOrangtua }}</p>
    </div>

    <div class="bg-white rounded shadow p-5">
        <p class="text-gray-500 text-sm">Total Siswa</p>
        <p class="text-2xl font-bold mt-2">{{ $totalSiswa }}</p>
    </div>

    <div class="bg-white rounded shadow p-5">
        <p class="text-gray-500 text-sm">Total Kelas</p>
        <p class="text-2xl font-bold mt-2">{{ $totalKelas }}</p>
    </div>
</div>

@endsection