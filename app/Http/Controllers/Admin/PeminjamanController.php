<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $statusTab = $request->get('status', 'all');

        $query = Peminjaman::with(['user', 'buku'])->latest();

        // ── Filter berdasarkan tab ──────────────────────────────────────────
        match ($statusTab) {
            'aktif'        => $query->whereIn('status', ['menunggu', 'dipinjam', 'pengajuan_kembali', 'terlambat_review', 'menunggu_bayar']),
            'terlambat'    => $query->whereIn('status', ['terlambat_review', 'menunggu_bayar']),
            'dikembalikan' => $query->whereIn('status', ['dikembalikan', 'terlambat', 'ditolak']),
            default        => null, // 'all' — tidak difilter
        };

        $peminjaman = $query->paginate(15)->withQueryString();

        // ── Hitung untuk tab badge ─────────────────────────────────────────
        $total        = Peminjaman::count();
        $aktif        = Peminjaman::whereIn('status', ['menunggu', 'dipinjam', 'pengajuan_kembali', 'terlambat_review', 'menunggu_bayar'])->count();
        $terlambat    = Peminjaman::whereIn('status', ['terlambat_review', 'menunggu_bayar'])->count();
        $dikembalikan = Peminjaman::whereIn('status', ['dikembalikan', 'terlambat', 'ditolak'])->count();

        // ── Summary cards ──────────────────────────────────────────────────
        $jatuhTempo = Peminjaman::where('status', 'dipinjam')
                        ->whereDate('tanggal_kembali', today())
                        ->count();

        $returned = Peminjaman::whereIn('status', ['dikembalikan', 'terlambat'])
                        ->whereMonth('tanggal_dikembalikan', now()->month)
                        ->whereYear('tanggal_dikembalikan', now()->year)
                        ->count();

        return view('admin.peminjaman.index', compact(
            'peminjaman',
            'total', 'aktif', 'terlambat', 'dikembalikan',
            'jatuhTempo', 'returned'
        ));
    }

    // ── Setujui pengajuan peminjaman ────────────────────────────────────────
    public function approve(Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'menunggu') {
            return redirect()->back()->with('error', 'Peminjaman tidak bisa disetujui.');
        }

        if ($peminjaman->buku->stok <= 0) {
            return redirect()->back()->with('error', 'Stok buku habis.');
        }

        $peminjaman->update(['status' => 'dipinjam']);
        $peminjaman->buku->decrement('stok');

        return redirect()->back()->with('success', 'Peminjaman berhasil disetujui.');
    }

    // ── Tolak pengajuan peminjaman ──────────────────────────────────────────
    public function tolak(Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'menunggu') {
            return redirect()->back()->with('error', 'Peminjaman tidak bisa ditolak.');
        }

        $peminjaman->update(['status' => 'ditolak']);

        return redirect()->back()->with('success', 'Peminjaman berhasil ditolak.');
    }

    // ── Konfirmasi pengembalian tepat waktu ─────────────────────────────────
    public function konfirmasiKembali(Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'pengajuan_kembali') {
            return redirect()->back()->with('error', 'Status tidak valid untuk dikonfirmasi.');
        }

        $peminjaman->update([
            'tanggal_dikembalikan' => $peminjaman->tanggal_pengajuan_kembali,
            'status'               => 'dikembalikan',
        ]);

        $peminjaman->buku->increment('stok');

        return redirect()->back()->with('success', 'Pengembalian berhasil dikonfirmasi.');
    }

    // ── Review keterlambatan (dari status terlambat_review) ─────────────────
    public function reviewTerlambat(Request $request, Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'terlambat_review') {
            return redirect()->back()->with('error', 'Status tidak valid.');
        }

        $request->validate([
            'keputusan' => 'required|in:denda,tidak',
            'denda'     => 'required_if:keputusan,denda|nullable|integer|min:0',
        ]);

        if ($request->keputusan === 'denda') {
            $peminjaman->update([
                'status' => 'menunggu_bayar',
                'denda'  => $request->denda,
            ]);

            return redirect()->back()->with('success', 'Denda ditetapkan. User perlu membayar sebelum pengembalian selesai.');
        }

        // Tanpa denda
        $peminjaman->update([
            'tanggal_dikembalikan' => $peminjaman->tanggal_pengajuan_kembali,
            'status'               => 'terlambat',
            'denda'                => 0,
        ]);

        $peminjaman->buku->increment('stok');

        return redirect()->back()->with('success', 'Pengembalian dikonfirmasi tanpa denda.');
    }

    // ── Konfirmasi denda sudah dibayar (dari status menunggu_bayar) ─────────
    public function konfirmasiBayar(Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'menunggu_bayar') {
            return redirect()->back()->with('error', 'Status tidak valid.');
        }

        $peminjaman->update([
            'denda_dibayar'        => true,
            'tanggal_dikembalikan' => $peminjaman->tanggal_pengajuan_kembali,
            'status'               => 'terlambat',
        ]);

        $peminjaman->buku->increment('stok');

        return redirect()->back()->with('success', 'Pembayaran denda dikonfirmasi. Peminjaman selesai.');
    }
}