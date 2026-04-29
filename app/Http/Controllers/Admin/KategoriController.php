<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $categories = Kategori::latest()->get();
        return view('admin.kategoris.index', compact('categories'));
    }

    public function create()
    {
        // ✅ Fix: view kategori, bukan view buku
        return view('admin.kategoris.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoris,nama_kategori',
            'deskripsi'     => 'nullable|string',
            'warna'         => 'nullable|string|max:20',
        ]);

        Kategori::create($request->only('nama_kategori', 'deskripsi', 'warna'));

        return redirect()->route('admin.kategoris.index')
            ->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function edit(Kategori $kategori)
    {
        return view('admin.kategoris.edit', compact('kategori'));
    }

    public function update(Request $request, Kategori $kategori)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoris,nama_kategori,' . $kategori->id,
            'deskripsi'     => 'nullable|string',
            'warna'         => 'nullable|string|max:20',
        ]);

        $kategori->update($request->only('nama_kategori', 'deskripsi', 'warna'));

        return redirect()->route('admin.kategoris.index')
            ->with('success', 'Kategori berhasil diupdate!');
    }

    public function destroy(Kategori $kategori)
    {
        $kategori->delete();

        return redirect()->route('admin.kategoris.index')
            ->with('success', 'Kategori berhasil dihapus!');
    }
}