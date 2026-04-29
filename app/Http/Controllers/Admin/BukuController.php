<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BukuController extends Controller
{
    public function index()
    {
        $bukus = Buku::with('kategori')->latest()->paginate(10);
        return view('admin.buku.index', compact('bukus'));
    }

    public function create()
    {
        $categories = Kategori::orderBy('nama_kategori')->get();
        return view('admin.buku.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'        => 'required|string|max:255',
            'penulis'      => 'required|string|max:255',
            'penerbit'     => 'nullable|string|max:255',
            'isbn'         => 'nullable|string|unique:bukus,isbn',
            'tahun_terbit' => 'nullable|digits:4|integer|min:1900|max:' . date('Y'),
            'category_id'  => 'required|exists:kategoris,id',
            'stok'         => 'required|integer|min:0',
            'bahasa'       => 'nullable|string|max:50',
            'deskripsi'    => 'nullable|string',
            'cover'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->except(['cover', 'hapus_cover']);
        $data['kode_buku'] = 'BK' . strtoupper(Str::random(5));

        if ($request->hasFile('cover')) {
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        Buku::create($data);

        return redirect()->route('admin.buku.index')
                         ->with('success', 'Buku berhasil ditambahkan.');
    }

    public function show(Buku $buku)
    {
        $buku->load('kategori');
        return view('admin.buku.show', compact('buku'));
    }

    public function edit(Buku $buku)
    {
        $categories = Kategori::orderBy('nama_kategori')->get();
        return view('admin.buku.edit', compact('buku', 'categories'));
    }

    public function update(Request $request, Buku $buku)
    {
        $request->validate([
            'judul'        => 'required|string|max:255',
            'penulis'      => 'required|string|max:255',
            'penerbit'     => 'nullable|string|max:255',
            'isbn'         => 'nullable|string|unique:bukus,isbn,' . $buku->id,
            'tahun_terbit' => 'nullable|digits:4|integer|min:1900|max:' . date('Y'),
            'category_id'  => 'required|exists:kategoris,id',
            'stok'         => 'required|integer|min:0',
            'bahasa'       => 'nullable|string|max:50',
            'deskripsi'    => 'nullable|string',
            'cover'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->except(['cover', 'hapus_cover']);

        // ✅ Hapus cover jika checkbox dicentang
        if ($request->hapus_cover && $buku->cover) {
            Storage::disk('public')->delete($buku->cover);
            $data['cover'] = null;
        }

        // ✅ Upload cover baru jika ada
        if ($request->hasFile('cover')) {
            if ($buku->cover) {
                Storage::disk('public')->delete($buku->cover);
            }
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        $buku->update($data);

        return redirect()->route('admin.buku.index')
                         ->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy(Buku $buku)
    {
        if ($buku->cover) {
            Storage::disk('public')->delete($buku->cover);
        }

        $buku->delete();

        return redirect()->route('admin.buku.index')
                         ->with('success', 'Buku berhasil dihapus.');
    }
}