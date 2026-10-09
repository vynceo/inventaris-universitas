<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BarangController extends Controller
{
    /**
     * Display a listing of the items (Acara 15 & 16).
     */
    public function index(Request $request): View
    {
        $query = Barang::with('kategori');

        // Filter berdasarkan kategori
        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        // Filter berdasarkan kondisi
        if ($request->filled('kondisi')) {
            $query->where('kondisi', $request->kondisi);
        }

        // Pencarian nama atau deskripsi
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        $barangs = $query->latest()->paginate(10)->withQueryString();
        $kategoris = Kategori::all();

        return view('pages.barang.index', compact('barangs', 'kategoris'));
    }

    /**
     * Show the form for creating a new item (Acara 15 & 16).
     */
    public function create(): View
    {
        $kategoris = Kategori::all();

        return view('pages.barang.create', compact('kategoris'));
    }

    /**
     * Store a newly created item in storage (Acara 15 & 16).
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kategori_id' => ['required', 'exists:kategoris,id'],
            'nama'        => ['required', 'string', 'max:150'],
            'jumlah'      => ['required', 'integer', 'min:0'],
            'kondisi'     => ['required', 'in:baik,rusak,hilang'],
            'deskripsi'   => ['nullable', 'string'],
            'gambar'      => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $data = $request->except('gambar');

        // Upload gambar barang (Acara 16)
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('barang', $filename, 'public');
            $data['gambar'] = 'storage/barang/' . $filename;
        }

        Barang::create($data);

        return redirect()
            ->route('barang.index')
            ->with('success', 'Barang berhasil ditambahkan');
    }

    /**
     * Display the specified item (Acara 15 & 16).
     */
    public function show(Barang $barang): View
    {
        $barang->load(['kategori', 'transaksis.user']);

        return view('pages.barang.show', compact('barang'));
    }

    /**
     * Show the form for editing the specified item (Acara 15 & 16).
     */
    public function edit(Barang $barang): View
    {
        $kategoris = Kategori::all();

        return view('pages.barang.edit', compact('barang', 'kategoris'));
    }

    /**
     * Update the specified item in storage (Acara 15 & 16).
     */
    public function update(Request $request, Barang $barang): RedirectResponse
    {
        $request->validate([
            'kategori_id' => ['required', 'exists:kategoris,id'],
            'nama'        => ['required', 'string', 'max:150'],
            'jumlah'      => ['required', 'integer', 'min:0'],
            'kondisi'     => ['required', 'in:baik,rusak,hilang'],
            'deskripsi'   => ['nullable', 'string'],
            'gambar'      => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $data = $request->except('gambar');

        // Upload gambar baru dan hapus gambar lama (Acara 16)
        if ($request->hasFile('gambar')) {
            if ($barang->gambar && file_exists(public_path($barang->gambar))) {
                @unlink(public_path($barang->gambar));
            }
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('barang', $filename, 'public');
            $data['gambar'] = 'storage/barang/' . $filename;
        }

        $barang->update($data);

        return redirect()
            ->route('barang.index')
            ->with('success', 'Barang berhasil diupdate');
    }

    /**
     * Remove the specified item from storage with loan check (Acara 15).
     */
    public function destroy(Barang $barang): RedirectResponse
    {
        // Cek apakah barang sedang dipinjam
        if ($barang->transaksis()->where('status', 'dipinjam')->count() > 0) {
            return back()->with('error', 'Barang sedang dipinjam dan tidak dapat dihapus');
        }

        // Hapus file gambar jika ada
        if ($barang->gambar && file_exists(public_path($barang->gambar))) {
            @unlink(public_path($barang->gambar));
        }

        $barang->delete();

        return redirect()
            ->route('barang.index')
            ->with('success', 'Barang berhasil dihapus');
    }
}
