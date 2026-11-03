<?php

namespace App\Http\Controllers;

use App\Models\MataKuliah;
use App\Models\Material;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MaterialController extends Controller
{
    public function create(MataKuliah $course): View|RedirectResponse
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (!Auth::user()->isDosen() || $course->dosen_id !== Auth::id()) {
            abort(403, 'Akses ditolak. Anda bukan dosen pengampu mata kuliah ini.');
        }

        $nextMinggu = ($course->materials()->max('minggu_ke') ?? 0) + 1;

        return view('materials.create', compact('course', 'nextMinggu'));
    }

    public function store(Request $request, MataKuliah $course): RedirectResponse
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (!Auth::user()->isDosen() || $course->dosen_id !== Auth::id()) {
            abort(403, 'Akses ditolak. Anda bukan dosen pengampu mata kuliah ini.');
        }

        // TODO 5: Validasi data input, simpan materi pembelajaran baru, dan redirect ke detail mata kuliah.
        
        // 1. Periksa kelayakan input
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'konten' => ['required', 'string'],
            'minggu_ke' => ['required', 'integer', 'min:1'],
            'urutan' => ['required', 'integer', 'min:0'],
        ]);

        // 2. Simpan materi baru melalui relasi mata kuliah (otomatis mengisi course_id)
        $course->materials()->create($validated);

        // 3. Kembalikan redirect ke route detail mata kuliah
        return redirect()->route('courses.show', $course->id)
            ->with('success', "Materi pembelajaran \"{$validated['judul']}\" berhasil ditambahkan.");
    }

    public function edit(Material $material): View|RedirectResponse
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (!Auth::user()->isDosen() || $material->course->dosen_id !== Auth::id()) {
            abort(403, 'Akses ditolak. Anda bukan dosen pengampu mata kuliah materi ini.');
        }

        return view('materials.edit', compact('material'));
    }

    public function update(Request $request, Material $material): RedirectResponse
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (!Auth::user()->isDosen() || $material->course->dosen_id !== Auth::id()) {
            abort(403, 'Akses ditolak. Anda bukan dosen pengampu mata kuliah materi ini.');
        }

        // TODO 7: Validasi data input, perbarui data materi pembelajaran, dan redirect ke detail mata kuliah.
        
        // 1. Periksa kelayakan input
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'konten' => ['required', 'string'],
            'minggu_ke' => ['required', 'integer', 'min:1'],
            'urutan' => ['required', 'integer', 'min:0'],
        ]);

        // 2. Perbarui data materi
        $material->update($validated);

        // 3. Kembalikan redirect ke rute detail mata kuliah
        return redirect()->route('courses.show', $material->course_id)
            ->with('success', "Materi pembelajaran \"{$material->judul}\" berhasil diperbarui.");
    }

    public function destroy(Material $material): RedirectResponse
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (!Auth::user()->isDosen() || $material->course->dosen_id !== Auth::id()) {
            abort(403, 'Akses ditolak. Anda bukan dosen pengampu mata kuliah materi ini.');
        }

        // TODO 7 (Lanjutan): Hapus data materi pembelajaran dan redirect ke detail mata kuliah.
        
        // 1. Simpan ID mata kuliah dan judul sebelum dihapus untuk keperluan route dan pesan notifikasi
        $courseId = $material->course_id;
        $judulMateri = $material->judul;

        // 2. Hapus data materi dari basis data
        $material->delete();

        // 3. Kembalikan redirect
        return redirect()->route('courses.show', $courseId)
            ->with('success', "Materi pembelajaran \"{$judulMateri}\" berhasil dihapus.");
    }
}