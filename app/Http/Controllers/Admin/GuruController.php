<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\GuruImport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class GuruController extends Controller
{
    public function index()
    {
        $gurus = User::where('role', 'guru')->latest()->get();
        return view('admin.guru.index', compact('gurus'));
    }

    public function create()
    {
        return view('admin.guru.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'phone' => 'required|unique:users,phone',
        ]);

        User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'password' => Hash::make('guru12345'),
            'role' => 'guru',
        ]);

        return redirect()->route('guru.index')
            ->with('success', 'Guru berhasil ditambahkan.');
    }

    public function edit(User $guru)
    {
        return view('admin.guru.edit', compact('guru'));
    }

    public function update(Request $request, User $guru)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required|unique:users,phone,' . $guru->id,
        ]);

        $guru->update([
            'name' => $request->name,
            'phone' => $request->phone,
        ]);

        return redirect()->route('guru.index')
            ->with('success', 'Data guru berhasil diperbarui.');
    }

    public function destroy(User $guru)
    {
        $guru->delete();

        return back()->with('success', 'Guru berhasil dihapus.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:5120', // Maks 5MB
        ]);

        try {
            Excel::import(new GuruImport, $request->file('file'));
            return back()->with('success', 'Data Guru dan Wali Kelas berhasil diimport ✨');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat import: ' . $e->getMessage());
        }
    }
}
