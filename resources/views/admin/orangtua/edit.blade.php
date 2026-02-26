{{-- File: resources/views/admin/orangtua/edit.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow">
    <h2 class="text-xl font-bold mb-4">Edit Orang Tua</h2>

    {{-- ALERT ERROR --}}
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Gagal Update Data!</strong>
            <ul class="mt-1 list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('orangtua.update', $parent->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name', $parent->name) }}" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-indigo-300" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Email (Opsional)</label>
            <input type="email" name="email" value="{{ old('email', $parent->email) }}" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-indigo-300">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">No. WhatsApp</label>
            <input type="number" name="phone" value="{{ old('phone', $parent->phone) }}" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-indigo-300" required>
             @error('phone')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6 border-t pt-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Pilih Anak (Siswa)</label>
            <p class="text-xs text-gray-500 mb-2">Cari berdasarkan <strong>Nama</strong> atau <strong>NISN</strong>.</p>
            
            <div id="selected-chips" class="flex flex-wrap gap-2 mb-2"></div>

            <div class="relative">
                <input type="text" id="student-search" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-indigo-300" placeholder="Ketik Nama atau NISN..." autocomplete="off">
                <div id="dropdown-list" class="absolute z-10 w-full bg-white border border-gray-300 mt-1 rounded shadow-lg max-h-48 overflow-y-auto hidden"></div>
            </div>

            <div id="hidden-inputs"></div>
        </div>

        <div class="flex justify-end gap-2">
            <a href="{{ route('orangtua.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Batal</a>
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Update</button>
        </div>
    </form>
</div>

<script>
    const allStudents = @json($students);
    let selectedStudents = @json($selectedStudents);

    const searchInput = document.getElementById('student-search');
    const dropdownList = document.getElementById('dropdown-list');
    const chipsContainer = document.getElementById('selected-chips');
    const hiddenInputsContainer = document.getElementById('hidden-inputs');

    function renderChips() {
        chipsContainer.innerHTML = '';
        hiddenInputsContainer.innerHTML = '';

        selectedStudents.forEach(student => {
            const chip = document.createElement('div');
            chip.className = 'bg-indigo-100 text-indigo-800 text-sm font-semibold px-3 py-1 rounded-full flex items-center gap-2';
            chip.innerHTML = `
                ${student.name} (${student.nisn})
                <button type="button" onclick="removeStudent(${student.id})" class="text-indigo-500 hover:text-indigo-700 font-bold focus:outline-none">&times;</button>
            `;
            chipsContainer.appendChild(chip);

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'student_ids[]';
            input.value = student.id;
            hiddenInputsContainer.appendChild(input);
        });
    }

    function addStudent(id) {
        const student = allStudents.find(s => s.id === id);
        if (student && !selectedStudents.some(s => s.id === id)) {
            selectedStudents.push(student);
            renderChips();
        }
        searchInput.value = '';
        dropdownList.classList.add('hidden');
    }

    window.removeStudent = function(id) {
        selectedStudents = selectedStudents.filter(s => s.id !== id);
        renderChips();
    }

    searchInput.addEventListener('input', function(e) {
        const keyword = e.target.value.toLowerCase();
        dropdownList.innerHTML = '';
        
        if (keyword.length === 0) {
            dropdownList.classList.add('hidden');
            return;
        }

        const filtered = allStudents.filter(s => 
            (s.name.toLowerCase().includes(keyword) || s.nisn.toString().includes(keyword)) && 
            !selectedStudents.some(sel => sel.id === s.id)
        );

        if (filtered.length > 0) {
            dropdownList.classList.remove('hidden');
            filtered.forEach(s => {
                const item = document.createElement('div');
                item.className = 'px-4 py-2 hover:bg-gray-100 cursor-pointer border-b last:border-b-0 text-sm';
                item.innerHTML = `<strong>${s.name}</strong> (${s.nisn}) <br> <span class="text-xs text-gray-500">Kelas: ${s.class_name}</span>`;
                item.addEventListener('click', () => addStudent(s.id));
                dropdownList.appendChild(item);
            });
        } else {
            dropdownList.classList.add('hidden');
        }
    });

    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !dropdownList.contains(e.target)) {
            dropdownList.classList.add('hidden');
        }
    });

    renderChips();
</script>
@endsection