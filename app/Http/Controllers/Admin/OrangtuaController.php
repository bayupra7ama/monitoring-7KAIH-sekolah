<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class OrangtuaController extends Controller
{
    public function index()
    {
        $parents = User::where('role', 'orangtua')->with('children')->latest()->get();
        return view('admin.orangtua.index', compact('parents'));
    }

    public function create()
    {
        // Masukkan NISN ke dalam data JSON
        $students = Student::with('class')->orderBy('name')->get()->map(function($s) {
            return [
                'id' => $s->id,
                'name' => $s->name,
                'nisn' => $s->nisn, // Tambahan NISN
                'class_name' => $s->class->name ?? 'Belum ada kelas'
            ];
        });
        
        return view('admin.orangtua.create', compact('students'));
    }

    public function store(Request $request)
    {
        // Validasi dengan Pesan Kustom (Bahasa Indonesia)
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|numeric|unique:users,phone',
            'email' => 'nullable|email|unique:users,email',
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:students,id',
        ], [
            // Custom Error Messages
            'phone.unique' => 'Gagal: Nomor WhatsApp ini sudah digunakan oleh orang tua lain.',
            'phone.required' => 'Nomor WhatsApp wajib diisi.',
            'phone.numeric' => 'Nomor WhatsApp harus berupa angka.',
            'email.unique' => 'Gagal: Email ini sudah terdaftar.',
            'student_ids.required' => 'Gagal: Anda belum memilih anak (siswa).',
        ]);

        $orangtua = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make(value: 'orangtua12345'),
            'role' => 'orangtua',
        ]);

        $orangtua->children()->attach($request->student_ids);

        return redirect()->route('orangtua.index')->with('success', 'Orang Tua berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $parent = User::where('role', 'orangtua')->with('children')->findOrFail($id);
        
        $students = Student::with('class')->orderBy('name')->get()->map(function($s) {
            return [
                'id' => $s->id,
                'name' => $s->name,
                'nisn' => $s->nisn, // Tambahan NISN
                'class_name' => $s->class->name ?? 'Belum ada kelas'
            ];
        });

        $selectedStudents = $parent->children->map(function($s) {
            return [
                'id' => $s->id,
                'name' => $s->name,
                'nisn' => $s->nisn, // Tambahan NISN
                'class_name' => $s->class->name ?? 'Belum ada kelas'
            ];
        });
        
        return view('admin.orangtua.edit', compact('parent', 'students', 'selectedStudents'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|numeric|unique:users,phone,' . $id,
            'email' => 'nullable|email|unique:users,email,' . $id,
            'student_ids' => 'required|array',
        ], [
            'phone.unique' => 'Gagal: Nomor WhatsApp ini sudah digunakan oleh pengguna lain.',
            'email.unique' => 'Gagal: Email ini sudah digunakan oleh pengguna lain.',
        ]);

        $orangtua = User::findOrFail($id);

        $orangtua->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
        ]);

        $orangtua->children()->sync($request->student_ids);

        return redirect()->route('orangtua.index')->with('success', 'Data Orang Tua berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $orangtua = User::findOrFail($id);
        $orangtua->children()->detach();
        $orangtua->delete();

        return back()->with('success', 'Orang Tua berhasil dihapus.');
    }
}