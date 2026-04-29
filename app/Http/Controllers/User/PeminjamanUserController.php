<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PeminjamanUserController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::with('buku')
            ->where('user_id', auth()->id())
            ->latest()->paginate(10);

        // Notifikasi denda yang belum dibayar
        $dendaBelumBayar = Peminjaman::with('buku')
            ->where('user_id', auth()->id())
            ->where('status', 'menunggu_bayar')
            ->where('denda_dibayar', false)
            ->get();

        return view('user.peminjaman.index', compact('peminjamans', 'dendaBelumBayar'));
    }

    public function create(Buku $buku)
    {
        if ($buku->stok <= 0) {
            return redirect()->route('user.buku.index')
                             ->with('error', 'Stok buku habis.');
        }

        $sudahPinjam = Peminjaman::where('user_id', auth()->id())
            ->where('buku_id', $buku->id)
            ->whereIn('status', ['menunggu', 'dipinjam', 'pengajuan_kembali', 'terlambat_review', 'menunggu_bayar'])
            ->exists();

        if ($sudahPinjam) {
            return redirect()->back()->with('error', 'Kamu sudah mengajukan atau masih meminjam buku ini.');
        }

        return view('user.peminjaman.create', compact('buku'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'buku_id'         => 'required|exists:bukus,id',
            'tanggal_pinjam'  => 'required|date|after_or_equal:today',
            'tanggal_kembali' => 'required|date|after:tanggal_pinjam',
        ]);

        $buku = Buku::findOrFail($request->buku_id);

        if ($buku->stok <= 0) {
            return redirect()->back()->with('error', 'Stok buku habis.');
        }

        Peminjaman::create([
            'user_id'         => auth()->id(),
            'buku_id'         => $buku->id,
            'tanggal_pinjam'  => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'status'          => 'menunggu',
        ]);

        return redirect()->route('user.peminjaman.index')
                         ->with('success', 'Peminjaman berhasil diajukan, menunggu persetujuan admin.');
    }

    // Form pengembalian
    public function formKembali(Peminjaman $peminjaman)
    {
        if ($peminjaman->user_id !== auth()->id() || $peminjaman->status !== 'dipinjam') {
            return redirect()->route('user.peminjaman.index')->with('error', 'Tidak bisa mengakses halaman ini.');
        }

        $terlambat = Carbon::today()->gt($peminjaman->tanggal_kembali);

        return view('user.peminjaman.kembali', compact('peminjaman', 'terlambat'));
    }

    // Submit pengembalian
    public function ajukanKembali(Request $request, Peminjaman $peminjaman)
    {
        if ($peminjaman->user_id !== auth()->id() || $peminjaman->status !== 'dipinjam') {
            return redirect()->route('user.peminjaman.index')->with('error', 'Tidak valid.');
        }

        $terlambat = Carbon::today()->gt($peminjaman->tanggal_kembali);

        $rules = ['tanggal_dikembalikan' => 'required|date'];
        if ($terlambat) {
            $rules['alasan_terlambat'] = 'required|string|max:500';
        }

        $request->validate($rules);

        $peminjaman->update([
            'tanggal_pengajuan_kembali' => $request->tanggal_dikembalikan,
            'alasan_terlambat'          => $terlambat ? $request->alasan_terlambat : null,
            'status'                    => $terlambat ? 'terlambat_review' : 'pengajuan_kembali',
        ]);

        return redirect()->route('user.peminjaman.index')
                         ->with('success', $terlambat
                             ? 'Pengajuan kembali dikirim. Admin akan mereview keterlambatan kamu.'
                             : 'Pengajuan pengembalian berhasil dikirim, menunggu konfirmasi admin.');
    }
}