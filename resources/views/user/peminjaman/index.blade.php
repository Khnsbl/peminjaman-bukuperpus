@extends('layouts.user')

@section('content')

{{-- Google Fonts --}}
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,400&display=swap" rel="stylesheet">

<style>
    .pmj-wrap * { box-sizing: border-box; }
    .pmj-wrap {
        font-family: 'DM Sans', sans-serif;
        background: #F5EFE6;
        min-height: 100vh;
        padding: 32px 28px;
    }

    /* ─── PAGE HEADER ─── */
    .pmj-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        margin-bottom: 28px;
    }
    .pmj-header-left {}
    .pmj-eyebrow {
        font-size: 10px;
        letter-spacing: 2.5px;
        text-transform: uppercase;
        color: #C8622A;
        font-weight: 500;
        margin-bottom: 4px;
    }
    .pmj-title {
        font-family: 'Playfair Display', serif;
        font-size: 28px;
        color: #2C1810;
        font-weight: 700;
        line-height: 1.2;
    }

    /* ─── STAT CARDS ─── */
    .pmj-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 14px;
        margin-bottom: 28px;
    }
    .pmj-stat {
        background: #fff;
        border-radius: 16px;
        padding: 18px 20px;
        border: 1px solid rgba(44,24,16,0.07);
        display: flex;
        align-items: center;
        gap: 14px;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .pmj-stat:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(44,24,16,0.09);
    }
    .pmj-stat-icon {
        width: 46px; height: 46px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }
    .pmj-stat-icon.orange { background: rgba(200,98,42,0.12); }
    .pmj-stat-icon.green  { background: rgba(34,197,94,0.12); }
    .pmj-stat-icon.red    { background: rgba(220,38,38,0.1); }
    .pmj-stat-num {
        font-family: 'Playfair Display', serif;
        font-size: 22px;
        color: #2C1810;
        font-weight: 700;
        line-height: 1;
    }
    .pmj-stat-label {
        font-size: 11px;
        color: #8B6B55;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        margin-top: 3px;
    }

    /* ─── ALERT DENDA ─── */
    .pmj-alert {
        background: #fff5f5;
        border: 1px solid rgba(220,38,38,0.25);
        border-left: 4px solid #DC2626;
        border-radius: 12px;
        padding: 14px 18px;
        display: flex;
        align-items: flex-start;
        gap: 12px;
        margin-bottom: 14px;
        animation: slideIn 0.3s ease;
    }
    .pmj-alert-icon { font-size: 20px; flex-shrink: 0; margin-top: 1px; }
    .pmj-alert-title { font-weight: 600; color: #991B1B; font-size: 13px; margin-bottom: 4px; }
    .pmj-alert-body  { font-size: 12px; color: #B91C1C; line-height: 1.6; }

    /* ─── CARD TABLE ─── */
    .pmj-card {
        background: #fff;
        border-radius: 20px;
        border: 1px solid rgba(44,24,16,0.07);
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(44,24,16,0.05);
    }
    .pmj-card-header {
        padding: 18px 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid rgba(44,24,16,0.07);
        background: #FDFAF7;
    }
    .pmj-card-title {
        font-family: 'Playfair Display', serif;
        font-size: 16px;
        color: #2C1810;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .pmj-count-badge {
        background: #2C1810;
        color: #F5EFE6;
        font-size: 10px;
        font-family: 'DM Sans', sans-serif;
        font-weight: 500;
        padding: 2px 9px;
        border-radius: 20px;
    }

    /* ─── TABLE ─── */
    .pmj-table { width: 100%; border-collapse: collapse; }
    .pmj-table thead tr {
        background: #FDFAF7;
    }
    .pmj-table thead th {
        padding: 12px 20px;
        text-align: left;
        font-size: 10px;
        font-weight: 500;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: #8B6B55;
        border-bottom: 1px solid rgba(44,24,16,0.08);
    }
    .pmj-table tbody tr {
        border-bottom: 1px solid rgba(44,24,16,0.05);
        transition: background 0.15s;
    }
    .pmj-table tbody tr:last-child { border-bottom: none; }
    .pmj-table tbody tr:hover { background: #FDFAF7; }
    .pmj-table td { padding: 14px 20px; vertical-align: middle; }

    .book-title { font-weight: 500; color: #2C1810; font-size: 13px; }
    .book-author { font-size: 11px; color: #8B6B55; margin-top: 2px; }

    .date-text { font-size: 13px; color: #5C3D2E; }

    /* Status badges */
    .badge {
        display: inline-flex; align-items: center; gap: 4px;
        font-size: 11px; font-weight: 500;
        padding: 4px 10px; border-radius: 20px;
        white-space: nowrap;
    }
    .badge::before { content: ''; width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }
    .badge-menunggu   { background: #FEF9C3; color: #854D0E; } .badge-menunggu::before { background: #CA8A04; }
    .badge-dipinjam   { background: #DBEAFE; color: #1E40AF; } .badge-dipinjam::before { background: #3B82F6; }
    .badge-kembali    { background: #F3E8FF; color: #6B21A8; } .badge-kembali::before { background: #9333EA; }
    .badge-review     { background: #FFEDD5; color: #9A3412; } .badge-review::before { background: #EA580C; }
    .badge-bayar      { background: #FEE2E2; color: #991B1B; } .badge-bayar::before { background: #DC2626; }
    .badge-selesai    { background: #DCFCE7; color: #14532D; } .badge-selesai::before { background: #22C55E; }
    .badge-terlambat  { background: #FEE2E2; color: #991B1B; } .badge-terlambat::before { background: #DC2626; }
    .badge-ditolak    { background: #F3F4F6; color: #6B7280; } .badge-ditolak::before { background: #9CA3AF; }

    /* Denda */
    .denda-amount { color: #DC2626; font-weight: 600; font-size: 13px; }
    .denda-lunas  { font-size: 10px; color: #16A34A; margin-top: 2px; }
    .denda-belum  { font-size: 10px; color: #DC2626; margin-top: 2px; }

    /* Action Button */
    .btn-kembalikan {
        background: linear-gradient(135deg, #C8622A, #A84E1E);
        color: #fff;
        font-size: 11px;
        font-weight: 500;
        padding: 7px 14px;
        border-radius: 8px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.2s;
        border: none;
        white-space: nowrap;
    }
    .btn-kembalikan:hover {
        background: linear-gradient(135deg, #A84E1E, #8B3D14);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(200,98,42,0.3);
        color: #fff;
        text-decoration: none;
    }

    /* Empty state */
    .pmj-empty {
        padding: 60px 20px;
        text-align: center;
    }
    .pmj-empty-icon {
        width: 80px; height: 80px;
        background: #F5EFE6;
        border-radius: 20px;
        display: flex; align-items: center; justify-content: center;
        font-size: 32px;
        margin: 0 auto 18px;
    }
    .pmj-empty-title {
        font-family: 'Playfair Display', serif;
        font-size: 18px;
        color: #2C1810;
        margin-bottom: 8px;
    }
    .pmj-empty-desc {
        font-size: 13px;
        color: #8B6B55;
        line-height: 1.7;
        max-width: 320px;
        margin: 0 auto 20px;
    }
    .btn-cari {
        display: inline-flex; align-items: center; gap: 8px;
        background: #2C1810;
        color: #F5EFE6;
        font-size: 13px;
        font-weight: 500;
        padding: 11px 24px;
        border-radius: 10px;
        text-decoration: none;
        transition: all 0.2s;
    }
    .btn-cari:hover {
        background: #C8622A;
        color: #fff;
        text-decoration: none;
        transform: translateY(-1px);
    }

    /* Pagination wrapper */
    .pmj-pagination {
        padding: 14px 20px;
        border-top: 1px solid rgba(44,24,16,0.07);
        background: #FDFAF7;
    }

    @keyframes slideIn {
        from { opacity: 0; transform: translateY(-6px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 768px) {
        .pmj-stats { grid-template-columns: 1fr; }
        .pmj-table thead { display: none; }
        .pmj-table tbody tr { display: block; padding: 12px 0; }
        .pmj-table td { display: block; padding: 4px 16px; }
    }
</style>

<div class="pmj-wrap">

    {{-- ─── HEADER ─── --}}
    <div class="pmj-header">
        <div class="pmj-header-left">
            <div class="pmj-eyebrow">Perpustakaan · Akun Saya</div>
            <div class="pmj-title">Peminjaman Saya</div>
        </div>
    </div>

    {{-- ─── STAT CARDS ─── --}}
    <div class="pmj-stats">
        <div class="pmj-stat">
            <div class="pmj-stat-icon orange">📖</div>
            <div>
                <div class="pmj-stat-num">
                    {{ $peminjamans->where('status','dipinjam')->count() + $peminjamans->where('status','menunggu')->count() }}
                </div>
                <div class="pmj-stat-label">Sedang Dipinjam</div>
            </div>
        </div>
        <div class="pmj-stat">
            <div class="pmj-stat-icon green">✅</div>
            <div>
                <div class="pmj-stat-num">{{ $peminjamans->where('status','dikembalikan')->count() }}</div>
                <div class="pmj-stat-label">Dikembalikan</div>
            </div>
        </div>
        <div class="pmj-stat">
            <div class="pmj-stat-icon red">💸</div>
            <div>
                <div class="pmj-stat-num">
                    Rp{{ number_format($peminjamans->sum('denda'), 0, ',', '.') }}
                </div>
                <div class="pmj-stat-label">Total Denda</div>
            </div>
        </div>
    </div>

    {{-- ─── NOTIFIKASI DENDA ─── --}}
    @foreach($dendaBelumBayar as $denda)
    <div class="pmj-alert">
        <div class="pmj-alert-icon">🔔</div>
        <div>
            <div class="pmj-alert-title">Kamu memiliki denda yang belum dibayar!</div>
            <div class="pmj-alert-body">
                Buku: <strong>{{ $denda->buku->judul }}</strong> &nbsp;·&nbsp;
                Nominal: <strong>Rp{{ number_format($denda->denda, 0, ',', '.') }}</strong><br>
                Segera bayar denda ke petugas perpustakaan.
            </div>
        </div>
    </div>
    @endforeach

    {{-- ─── TABEL PEMINJAMAN ─── --}}
    <div class="pmj-card">
        <div class="pmj-card-header">
            <div class="pmj-card-title">
                Riwayat Peminjaman
                <span class="pmj-count-badge">{{ $peminjamans->total() }} buku</span>
            </div>
        </div>

        <table class="pmj-table">
            <thead>
                <tr>
                    <th>Buku</th>
                    <th>Tgl Pinjam</th>
                    <th>Tgl Kembali</th>
                    <th>Dikembalikan</th>
                    <th>Denda</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peminjamans as $item)
                <tr>
                    <td>
                        <div class="book-title">{{ $item->buku->judul }}</div>
                        <div class="book-author">{{ $item->buku->penulis }}</div>
                    </td>
                    <td><span class="date-text">{{ $item->tanggal_pinjam->format('d M Y') }}</span></td>
                    <td><span class="date-text">{{ $item->tanggal_kembali->format('d M Y') }}</span></td>
                    <td>
                        <span class="date-text">
                            {{ $item->tanggal_dikembalikan ? $item->tanggal_dikembalikan->format('d M Y') : '—' }}
                        </span>
                    </td>
                    <td>
                        @if($item->denda > 0)
                            <div class="denda-amount">Rp{{ number_format($item->denda, 0, ',', '.') }}</div>
                            @if($item->denda_dibayar)
                                <div class="denda-lunas">✅ Lunas</div>
                            @else
                                <div class="denda-belum">⚠ Belum bayar</div>
                            @endif
                        @else
                            <span style="color:#8B6B55;font-size:13px;">—</span>
                        @endif
                    </td>
                    <td>
                        @if($item->status === 'menunggu')
                            <span class="badge badge-menunggu">Menunggu</span>
                        @elseif($item->status === 'dipinjam')
                            <span class="badge badge-dipinjam">Dipinjam</span>
                        @elseif($item->status === 'pengajuan_kembali')
                            <span class="badge badge-kembali">Pengajuan Kembali</span>
                        @elseif($item->status === 'terlambat_review')
                            <span class="badge badge-review">Review Admin</span>
                        @elseif($item->status === 'menunggu_bayar')
                            <span class="badge badge-bayar">Bayar Denda</span>
                        @elseif($item->status === 'dikembalikan')
                            <span class="badge badge-selesai">Selesai</span>
                        @elseif($item->status === 'terlambat')
                            <span class="badge badge-terlambat">Terlambat</span>
                        @elseif($item->status === 'ditolak')
                            <span class="badge badge-ditolak">Ditolak</span>
                        @endif
                    </td>
                    <td>
                        @if($item->status === 'dipinjam')
                            <a href="{{ route('user.peminjaman.formKembali', $item) }}" class="btn-kembalikan">
                                ↩ Kembalikan
                            </a>
                        @else
                            <span style="color:#C9B8AC;font-size:13px;">—</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">
                        <div class="pmj-empty">
                            <div class="pmj-empty-icon">📚</div>
                            <div class="pmj-empty-title">Belum ada riwayat peminjaman</div>
                            <div class="pmj-empty-desc">
                                Kamu belum pernah meminjam buku dari perpustakaan.<br>
                                Yuk mulai jelajahi koleksi yang tersedia!
                            </div>
                            <a href="{{ route('user.buku.index') }}" class="btn-cari">
                                📖 Cari Buku Sekarang
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @if($peminjamans->hasPages())
        <div class="pmj-pagination">
            {{ $peminjamans->links() }}
        </div>
        @endif
    </div>

</div>
@endsection