<?php

namespace App\Http\Controllers;

use App\Models\Jenis;
use App\Http\Requests\UpdateJenisRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // <--- Import ini ditambahkan agar Storage tidak error

class JenisController extends Controller
{
    /**
     * Menampilkan daftar semua jenis.
     */
    public function index()
    {
        $jenis = Jenis::with('user')->latest()->get();
        return view('jenis.index', compact('jenis'));
    }

    /**
     * Menampilkan form tambah jenis.
     */
    public function create()
    {
        return view('jenis.create');
    }

    /**
     * Menyimpan jenis baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_jenis' => 'required|string|max:255',
        ]);

        // Simpan ke database
        Jenis::create([
            'user_id'    => Auth::id() ?? $request->user_id,
            'nama_jenis' => $request->nama_jenis,
        ]);

        return redirect()->route('jenis.index')
            ->with('success', 'Jenis berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail 1 jenis beserta daftar produk di dalamnya.
     */
    public function show(Jenis $jenis)
    {
        // Load relasi produk dan user
        $jenis->load(['produk', 'user']);

        return view('jenis.show', compact('jenis'));
    }

    /**
     * Menampilkan form edit jenis.
     */
    public function edit(Jenis $jenis)
    {
        $this->authorize('update', $jenis);

        // Ambil data jenis untuk dropdown (jika diperlukan)
        $jenisList = Jenis::all();

        return view('jenis.edit', compact('jenis', 'jenisList'));
    }

    /**
     * Mengubah data jenis.
     */
    public function update(UpdateJenisRequest $request, Jenis $jenis)
    {
        $this->authorize('update', $jenis);

        $dataReq = $request->validated();

        $data = [
            'user_id'    => Auth::id() ?? $jenis->user_id,
            'nama_jenis' => $dataReq['nama_jenis'],
        ];

        $jenis->update($data);

        return redirect()->route('jenis.index')
            ->with('success', 'Jenis berhasil diperbarui.');
    }

    /**
     * Menghapus jenis dari database.
     */
    public function destroy(Jenis $jenis)
    {
        $this->authorize('delete', $jenis);

        if (!empty($jenis->foto) && Storage::disk('public')->exists($jenis->foto)) {
            Storage::disk('public')->delete($jenis->foto);
        }

        $jenis->delete();

        return redirect()->route('jenis.index')
            ->with('success', 'Jenis berhasil dihapus.');
    }
}