<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Materi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MateriController extends Controller
{
    public function index()
    {
        // Menampilkan materi milik guru yang sedang login
        $materis = Materi::where('guru_id', Auth::id())->latest()->get();
        return view('guru.materi.index', compact('materis'));
    }

    public function create()
    {
        return view('guru.materi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'file_pdf' => 'nullable|mimes:pdf|max:10240', // Max 10MB
            'video' => 'nullable|mimes:mp4,mov,ogg,qt|max:51200', // Max 50MB
        ], [
            'file_pdf.max' => 'Ukuran PDF maksimal 10MB',
            'video.max' => 'Ukuran Video maksimal 50MB',
        ]);

        $data = [
            'guru_id' => Auth::id(),
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
        ];

        // 1. Upload PDF
        if ($request->hasFile('file_pdf')) {
            $pdfPath = $request->file('file_pdf')->store('materi/pdf', 'public');
            $data['file_pdf'] = $pdfPath;
        }

        // 2. Upload Video
        if ($request->hasFile('video')) {
            $videoPath = $request->file('video')->store('materi/video', 'public');
            $data['video'] = $videoPath;
        }

        Materi::create($data);

        return redirect()->route('guru.materi.index')->with('success', 'Materi berhasil diunggah.');
    }

    public function edit($id)
    {
        $materi = Materi::where('guru_id', Auth::id())->findOrFail($id);
        return view('guru.materi.edit', compact('materi'));
    }

    public function update(Request $request, $id)
    {
        $materi = Materi::where('guru_id', Auth::id())->findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'file_pdf' => 'nullable|mimes:pdf|max:10240',
            'video' => 'nullable|mimes:mp4,mov,ogg,qt|max:51200',
        ]);

        $materi->judul = $request->judul;
        $materi->deskripsi = $request->deskripsi;

        // Logic Ganti PDF
        if ($request->hasFile('file_pdf')) {
            // Hapus file lama
            if ($materi->file_pdf) Storage::disk('public')->delete($materi->file_pdf);
            // Upload baru
            $materi->file_pdf = $request->file('file_pdf')->store('materi/pdf', 'public');
        }

        // Logic Ganti Video
        if ($request->hasFile('video')) {
            // Hapus file lama
            if ($materi->video) Storage::disk('public')->delete($materi->video);
            // Upload baru
            $materi->video = $request->file('video')->store('materi/video', 'public');
        }

        $materi->save();

        return redirect()->route('guru.materi.index')->with('success', 'Materi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $materi = Materi::where('guru_id', Auth::id())->findOrFail($id);
        
        // Hapus file fisik dari storage agar tidak menuh-menuhin server
        if ($materi->file_pdf) Storage::disk('public')->delete($materi->file_pdf);
        if ($materi->video) Storage::disk('public')->delete($materi->video);

        $materi->delete();

        return back()->with('success', 'Materi berhasil dihapus.');
    }

  
    public function show($id)
    {
        $guru = Auth::user();
        $materi = Materi::where('guru_id', $guru->id)->findOrFail($id);
        
       
        $kelas = $guru->classAsTeacher;

        if (!$kelas) {
            return back()->with('error', 'Anda belum memiliki kelas ajar.');
        }

     
        $students = $kelas->students()->with(['feedbacks' => function($q) use ($materi) {
            $q->where('materi_id', $materi->id);
        }])->orderBy('name')->get();

        
        $totalSiswa = $students->count();
        $sudahMengerjakan = $students->filter(function($s) {
            return $s->feedbacks->where('sudah_diterapkan', true)->isNotEmpty();
        })->count();

        $persentase = $totalSiswa > 0 ? round(($sudahMengerjakan / $totalSiswa) * 100) : 0;

        return view('guru.materi.show', compact('materi', 'students', 'totalSiswa', 'sudahMengerjakan', 'persentase'));
    }
}