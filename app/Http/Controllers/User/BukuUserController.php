<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;

class BukuUserController extends Controller
{
    public function index(Request $request)
    {
        $query = Buku::with('kategori')->where('stok', '>', 0);

        // ✅ Fix: judul_buku → judul, pengarang → penulis
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->search . '%')
                  ->orWhere('penulis', 'like', '%' . $request->search . '%')
                  ->orWhere('penerbit', 'like', '%' . $request->search . '%');
            });
        }

        // ✅ Fix: filter by category_id bukan kolom kategori
        if ($request->filled('kategori')) {
            $query->where('category_id', $request->kategori);
        }

        $bukus     = $query->latest()->paginate(12)->withQueryString();

        // ✅ Fix: ambil dari tabel kategoris bukan kolom kategori di bukus
        $kategoris = Kategori::orderBy('nama_kategori')->get();

        return view('user.buku.index', compact('bukus', 'kategoris'));
    }

    public function show(Buku $buku)
    {
        $buku->load('kategori');
        return view('user.buku.show', compact('buku'));
    }
}