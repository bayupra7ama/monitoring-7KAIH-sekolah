@extends('layouts.admin')

@section('content')
    <h2 class="text-xl font-bold mb-4">Edit Guru</h2>

    <form method="POST" action="{{ route('guru.update', $guru->id) }}" class="max-w-md">

        @csrf
        @method('PUT')

        <input name="name" value="{{ $guru->name }}" class="w-full border p-2 mb-3">

        <input name="phone" value="{{ $guru->phone }}" class="w-full border p-2 mb-3">

        <button class="bg-indigo-600 text-white px-4 py-2 rounded">
            Update
        </button>
    </form>
@endsection
