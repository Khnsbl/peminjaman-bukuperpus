<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Peminjaman;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $totalBuku = Buku::where('stok', '>', 0)->count();

        $peminjamanAktif = Peminjaman::where('user_id', $user->id)
            ->where('status', 'dipinjam')
            ->count();

        $totalRiwayat = Peminjaman::where('user_id', $user->id)->count();

        $peminjamanAktifList = Peminjaman::with('buku')
            ->where('user_id', $user->id)
            ->where('status', 'dipinjam')
            ->latest()
            ->get();

        $bukuTersedia = Buku::where('stok', '>', 0)
            ->latest()
            ->take(8)
            ->get();

        $riwayat = Peminjaman::with('buku')
            ->where('user_id', $user->id)
            ->latest()
            ->take(10)
            ->get();

        return view('user.dashboard', compact(
            'totalBuku',
            'peminjamanAktif',
            'totalRiwayat',
            'peminjamanAktifList',
            'bukuTersedia',
            'riwayat'
        ));
    }
}