<?php
// File: app/Http/Controllers/Admin/KelasController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\User;
use App\Models\Student;

use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        // Ambil semua kelas beserta data gurunya
        $kelas = ClassRoom::with('teacher')->latest()->get();
        return view('admin.kelas.index', compact('kelas'));
    }

    public function create()
    {
        // Ambil semua user yang role-nya guru untuk dropdown
        $gurus = User::where('role', 'guru')->get();
        return view('admin.kelas.create', compact('gurus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'teacher_id' => 'required|exists:users,id', // Pastikan guru yang dipilih valid
        ]);

        ClassRoom::create([
            'name' => $request->name,
            'teacher_id' => $request->teacher_id,
        ]);

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil dibuat.');
    }

    public function edit($id)
    {
        // 1. Ambil Data Kelas
        $kelas = ClassRoom::findOrFail($id);

        // 2. Ambil Guru (Wali Kelas)
        $gurus = User::where('role', 'guru')->get();

        // 3. Ambil Murid yang SUDAH ada di kelas ini (untuk ditampilkan sebagai Chip)
        $currentStudents = Student::where('class_id', $id)->orderBy('name')->get();

        // 4. Ambil SEMUA murid untuk dropdown "Tambah Murid"
        // Kita perlu data 'class_room' nya juga untuk cek konflik
        $allStudents = Student::with('class')->orderBy('name')->get();

        return view('admin.kelas.edit', compact('kelas', 'gurus', 'currentStudents', 'allStudents'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'teacher_id' => 'required|exists:users,id',
        ]);

        $kelas = ClassRoom::findOrFail($id);
        $kelas->update([
            'name' => $request->name,
            'teacher_id' => $request->teacher_id,
        ]);

        return redirect()->route('kelas.index')->with('success', 'Info kelas berhasil diperbarui.');
    }

    // --- FITUR BARU: TAMBAH MURID KE KELAS ---
    public function addStudent(Request $request, $id)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
        ]);

        $student = Student::findOrFail($request->student_id);

        // Update kelas murid tersebut ke kelas yang sedang diedit
        $student->update(['class_id' => $id]);

        return back()->with('success', 'Murid berhasil ditambahkan ke kelas.');
    }

    // --- FITUR BARU: HAPUS MURID DARI KELAS ---
    public function removeStudent($id, $studentId)
    {
        $student = Student::where('id', $studentId)->where('class_id', $id)->firstOrFail();

        // Set kelas jadi NULL (Keluarkan dari kelas)
        $student->update(['class_id' => null]);

        return back()->with('success', 'Murid berhasil dikeluarkan dari kelas.');
    }

    public function destroy($id)
    {
        $kelas = ClassRoom::findOrFail($id);

      
        Student::where('class_id', $id)->update(['class_id' => null]);

        $kelas->delete();

        return back()->with('success', 'Kelas berhasil dihapus.');
    }
}