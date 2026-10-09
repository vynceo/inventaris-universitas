<?php

namespace App\Http\Controllers;

use App\Http\Requests\KategoriRequest;
use App\Models\Kategori;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class KategoriController extends Controller
{
    /**
     * Display a listing of the categories (Acara 13).
     */
    public function index(): View
    {
        $kategoris = Kategori::withCount('barangs')->get();

        return view('pages.kategori.index', compact('kategoris'));
    }

    /**
     * Show the form for creating a new category (Acara 13).
     */
    public function create(): View
    {
        return view('pages.kategori.create');
    }

    /**
     * Store a newly created category in storage (Acara 13).
     */
    public function store(KategoriRequest $request): RedirectResponse
    {
        Kategori::create($request->validated());

        return redirect()
            ->route('kategori.index')
            ->with('success', 'Kategori berhasil ditambahkan');
    }

    /**
     * Display the specified category.
     */
    public function show(Kategori $kategori): View
    {
        $kategori->load('barangs');

        return view('pages.kategori.show', compact('kategori'));
    }

    /**
     * Show the form for editing the specified category (Acara 14).
     */
    public function edit(Kategori $kategori): View
    {
        return view('pages.kategori.edit', compact('kategori'));
    }

    /**
     * Update the specified category in storage (Acara 14).
     */
    public function update(KategoriRequest $request, Kategori $kategori): RedirectResponse
    {
        $kategori->update($request->validated());

        return redirect()
            ->route('kategori.index')
            ->with('success', 'Kategori berhasil diupdate');
    }

    /**
     * Remove the specified category from storage with relation check (Acara 14).
     */
    public function destroy(Kategori $kategori): RedirectResponse
    {
        // Pengecekan relasi sebelum menghapus
        if ($kategori->barangs()->count() > 0) {
            return back()->with('error', 'Kategori tidak bisa dihapus karena masih memiliki barang');
        }

        $kategori->delete();

        return redirect()
            ->route('kategori.index')
            ->with('success', 'Kategori berhasil dihapus');
    }
}
