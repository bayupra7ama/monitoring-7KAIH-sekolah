@extends('layouts.admin')

@section('content')
    <h2 class="text-xl font-bold mb-4">Tambah Guru</h2>

    <form method="POST" action="{{ route('guru.store') }}" class="max-w-md">
        @csrf

        <input name="name" placeholder="Nama Guru" class="w-full border p-2 mb-3">

        <input name="phone" placeholder="No WhatsApp" class="w-full border p-2 mb-3">

        <button class="bg-indigo-600 text-white px-4 py-2 rounded">
            Simpan
        </button>
    </form>
@endsection
