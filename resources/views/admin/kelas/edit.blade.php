@extends('layouts.admin')

@section('content')
    <div class="max-w-6xl mx-auto">

        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Manajemen Kelas</h2>
            <a href="{{ route('kelas.index') }}" class="text-gray-500 hover:text-indigo-600 flex items-center">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
                Kembali
            </a>
        </div>

        {{-- ALERT SUKSES --}}
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Berhasil!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- KOLOM KIRI: EDIT INFO KELAS --}}
            <div class="lg:col-span-1">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 sticky top-4">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Info Kelas</h3>

                    <form action="{{ route('kelas.update', $kelas->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Nama Kelas</label>
                            <input type="text" name="name" value="{{ $kelas->name }}"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-200"
                                required>
                        </div>

                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Wali Kelas</label>
                            <select name="teacher_id"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-200"
                                required>
                                <option value="">-- Pilih Guru --</option>
                                @foreach ($gurus as $guru)
                                    <option value="{{ $guru->id }}"
                                        {{ $kelas->teacher_id == $guru->id ? 'selected' : '' }}>
                                        {{ $guru->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit"
                            class="w-full bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition-colors shadow-md">
                            Simpan Perubahan Info
                        </button>
                    </form>
                </div>
            </div>

            {{-- KOLOM KANAN: MANAJEMEN MURID --}}
            <div class="lg:col-span-2">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <div class="flex justify-between items-center mb-4 border-b pb-2">
                        <h3 class="text-lg font-bold text-gray-800">Anggota Kelas ({{ $currentStudents->count() }})</h3>
                    </div>

                    {{-- 1. SEARCH INPUT UNTUK TAMBAH MURID --}}
                    <div class="mb-6 bg-gray-50 p-4 rounded-xl border border-gray-200 relative">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Tambahkan Murid</label>
                        <p class="text-xs text-gray-500 mb-2">Ketik Nama atau NISN untuk mencari murid.</p>

                        <div class="relative">
                            <input type="text" id="student-search"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-200 pl-4 py-2"
                                placeholder="Cari murid..." autocomplete="off">

                            {{-- DROPDOWN RESULT --}}
                            <div id="dropdown-list"
                                class="absolute z-50 w-full bg-white border border-gray-300 mt-1 rounded-lg shadow-xl max-h-60 overflow-y-auto hidden">
                                {{-- Item hasil search akan muncul di sini via JS --}}
                            </div>
                        </div>
                    </div>

                    {{-- FORM HIDDEN UNTUK ADD STUDENT (Akan disubmit via JS) --}}
                    <form id="form-add-student" action="{{ route('kelas.addStudent', $kelas->id) }}" method="POST"
                        class="hidden">
                        @csrf
                        <input type="hidden" name="student_id" id="input-student-id">
                    </form>

                    {{-- 2. LIST MURID (CHIPS) --}}
                    <div id="student-chips-container" class="flex flex-wrap gap-3">
                        @if ($currentStudents->count() > 0)
                            @foreach ($currentStudents as $student)
                                <div
                                    class="flex items-center bg-indigo-50 text-indigo-700 px-3 py-1.5 rounded-full border border-indigo-100 shadow-sm transition-transform hover:scale-105 group">
                                    {{-- Avatar Kecil --}}
                                    <div
                                        class="h-6 w-6 rounded-full bg-indigo-200 flex items-center justify-center text-xs font-bold mr-2 group-hover:bg-indigo-300 transition-colors">
                                        {{ substr($student->name, 0, 1) }}
                                    </div>
                                    <span class="text-sm font-semibold mr-2">{{ $student->name }}</span>

                                    {{-- Tombol Hapus (Silang) --}}
                                    <form
                                        action="{{ route('kelas.removeStudent', ['id' => $kelas->id, 'studentId' => $student->id]) }}"
                                        method="POST" onsubmit="return confirmRemove('{{ $student->name }}');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-indigo-400 hover:text-red-500 focus:outline-none flex items-center justify-center h-5 w-5 rounded-full hover:bg-white transition-colors"
                                            title="Keluarkan dari kelas">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        @else
                            <div
                                class="w-full text-center py-8 bg-gray-50 rounded-lg border border-dashed border-gray-300 text-gray-400">
                                Belum ada murid di kelas ini.
                            </div>
                        @endif
                    </div>

                </div>
            </div>

        </div>
    </div>

    {{-- JAVASCRIPT LOGIC --}}
    {{-- PERSIAPAN DATA DI PHP AGAR TIDAK ERROR DI BLADE --}}
    @php
        $studentsForJs = $allStudents->map(function ($s) {
            return [
                'id' => $s->id,
                'name' => $s->name,
                'nisn' => $s->nisn,
                'class_id' => $s->class_id,
                'class_name' => $s->class ? $s->class->name : null,
            ];
        });
    @endphp

    {{-- JAVASCRIPT LOGIC --}}
    <script>
        // Ambil data yang sudah disiapkan di atas
        const allStudents = @json($studentsForJs);

        // ID Kelas yang sedang diedit
        const currentClassId = {{ $kelas->id }};

        const searchInput = document.getElementById('student-search');
        const dropdownList = document.getElementById('dropdown-list');

        // 1. Logic Search Input
        searchInput.addEventListener('input', function(e) {
            const keyword = e.target.value.toLowerCase();
            dropdownList.innerHTML = ''; // Kosongkan list dulu

            if (keyword.length === 0) {
                dropdownList.classList.add('hidden');
                return;
            }

            // Filter Murid:
            // 1. Nama/NISN cocok dengan keyword
            // 2. BELUM masuk di kelas ini (currentClassId)
            const filtered = allStudents.filter(s =>
                (s.name.toLowerCase().includes(keyword) || (s.nisn && s.nisn.toString().includes(keyword))) &&
                s.class_id != currentClassId
            );

            if (filtered.length > 0) {
                dropdownList.classList.remove('hidden');

                filtered.forEach(s => {
                    const item = document.createElement('div');
                    item.className =
                        'px-4 py-3 hover:bg-gray-50 cursor-pointer border-b last:border-b-0 transition-colors';

                    // Cek status kelas murid
                    let statusText =
                        '<span class="text-xs text-green-600 font-bold bg-green-50 px-2 py-0.5 rounded">Belum Punya Kelas</span>';
                    if (s.class_id) {
                        statusText =
                            `<span class="text-xs text-amber-600 font-bold bg-amber-50 px-2 py-0.5 rounded">Kelas: ${s.class_name}</span>`;
                    }

                    item.innerHTML = `
                    <div class="flex justify-between items-center">
                        <div>
                            <div class="font-bold text-gray-800 text-sm">${s.name}</div>
                            <div class="text-xs text-gray-500">NISN: ${s.nisn || '-'}</div>
                        </div>
                        <div>${statusText}</div>
                    </div>
                `;

                    // Event Listener Klik Item
                    item.addEventListener('click', () => confirmAddStudent(s));

                    dropdownList.appendChild(item);
                });
            } else {
                dropdownList.innerHTML =
                    `<div class="px-4 py-3 text-sm text-gray-400 italic text-center">Tidak ditemukan murid yang cocok.</div>`;
                dropdownList.classList.remove('hidden');
            }
        });

        // 2. Logic Tambah Murid (Dengan Konfirmasi)
        function confirmAddStudent(student) {
            // Jika murid sudah punya kelas (dan bukan kelas ini), tampilkan konfirmasi
            if (student.class_id && student.class_id != currentClassId) {
                const confirmMsg =
                    `Murid atas nama "${student.name}" sudah terdaftar di Kelas ${student.class_name}.\n\nApakah Anda yakin ingin memindahkannya ke kelas ini?`;

                if (confirm(confirmMsg)) {
                    submitForm(student.id);
                }
            } else {
                // Jika belum punya kelas, langsung gass
                submitForm(student.id);
            }

            // Reset search
            searchInput.value = '';
            dropdownList.classList.add('hidden');
        }

        // Submit Form Add Student
        function submitForm(studentId) {
            document.getElementById('input-student-id').value = studentId;
            document.getElementById('form-add-student').submit();
        }

        // 3. Logic Hapus Murid (Konfirmasi Native)
        function confirmRemove(studentName) {
            return confirm(`Apakah Anda yakin ingin mengeluarkan "${studentName}" dari kelas ini?`);
        }

        // Tutup dropdown jika klik di luar area
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !dropdownList.contains(e.target)) {
                dropdownList.classList.add('hidden');
            }
        });
    </script>
@endsection
