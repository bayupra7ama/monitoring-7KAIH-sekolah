{{-- File: resources/views/admin/siswa/edit.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow">
    <h2 class="text-xl font-bold mb-4">Edit Data Siswa</h2>

    <form action="{{ route('siswa.update', $student->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Nama Lengkap</label>
            <input type="text" name="name" value="{{ $student->name }}" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-indigo-300" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">NISN</label>
            <input type="number" name="nisn" value="{{ $student->nisn }}" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-indigo-300" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Pilih Kelas</label>
            <select name="class_id" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-indigo-300" required>
                <option value="">-- Pilih Kelas --</option>
                @foreach($classes as $kelas)
                    <option value="{{ $kelas->id }}" {{ $student->class_id == $kelas->id ? 'selected' : '' }}>
                        {{ $kelas->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex justify-end gap-2">
            <a href="{{ route('siswa.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Batal</a>
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Update</button>
        </div>
    </form>
</div>
@endsection