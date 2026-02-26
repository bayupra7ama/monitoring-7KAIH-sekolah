<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\SiswaImport;
use App\Models\ClassRoom;
use App\Models\Student;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SiswaController extends Controller
{
    public function index()
    {
        // Ambil data siswa beserta info kelasnya
        $students = Student::with('class')->latest()->get();
        return view('admin.siswa.index', compact('students'));
    }

    public function create()
    {
        // Ambil data kelas untuk dropdown
        $classes = ClassRoom::all();
        return view('admin.siswa.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nisn' => 'required|unique:students,nisn',
            'class_id' => 'required|exists:classes,id', // Wajib pilih kelas
        ]);

        Student::create([
            'name' => $request->name,
            'nisn' => $request->nisn,
            'class_id' => $request->class_id,
        ]);

        return redirect()->route('siswa.index')->with('success', 'Siswa berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $student = Student::findOrFail($id);
        $classes = ClassRoom::all();
        return view('admin.siswa.edit', compact('student', 'classes'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nisn' => 'required|unique:students,nisn,' . $id,
            'class_id' => 'required|exists:classes,id',
        ]);

        $student = Student::findOrFail($id);
        $student->update([
            'name' => $request->name,
            'nisn' => $request->nisn,
            'class_id' => $request->class_id,
        ]);

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return back()->with('success', 'Siswa berhasil dihapus.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:5120', // Maksimal 5MB
        ]);

        try {
            Excel::import(new SiswaImport, $request->file('file'));
            return redirect()->route('siswa.index')->with('success', 'Data Siswa berhasil diimport! Jika kelas sudah ada, siswa otomatis masuk kelas.');
        } catch (\Exception $e) {
            return redirect()->route('siswa.index')->with('error', 'Terjadi kesalahan saat import: ' . $e->getMessage());
        }
    }
}