@extends('layouts.user')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-sub', 'Selamat datang di sistem perpustakaan')

@section('content')

<!-- Welcome Card -->
<div class="card fade-up" style="margin-bottom:24px;">
    <div class="card-body" style="padding:24px;">
        <div style="display:flex; align-items:center; gap:16px;">
            <div style="
                width:56px; height:56px; border-radius:50%; flex-shrink:0;
                background:linear-gradient(135deg, var(--brown-light), var(--brown-dark));
                display:flex; align-items:center; justify-content:center;
                font-family:'Playfair Display',serif; font-size:22px;
                color:white; font-weight:700;
            ">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <div>
                <div style="font-family:'Playfair Display',serif; font-size:18px; font-weight:700; color:var(--brown-deep);">
                    Selamat datang, {{ auth()->user()->name }}! 👋
                </div>
                <div style="font-size:13px; color:var(--text-muted); margin-top:4px; display:flex; gap:16px; flex-wrap:wrap;">
                    <span>📋 NISN: {{ auth()->user()->nisn ?? '-' }}</span>
                    <span>🏫 Kelas: {{ auth()->user()->kelas ?? '-' }}</span>
                    <span>📚 Jurusan: {{ auth()->user()->jurusan ?? '-' }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistik -->
<div style="display:grid; grid-template-columns:repeat(3, 1fr); gap:16px; margin-bottom:24px;">
    @php
        $stats = [
            ['label'=>'Buku Tersedia',   'val'=>$totalBuku,       'icon'=>'fa-book-open',         'color'=>'var(--brown)'],
            ['label'=>'Sedang Dipinjam', 'val'=>$peminjamanAktif, 'icon'=>'fa-rotate',            'color'=>'var(--gold)'],
            ['label'=>'Total Riwayat',   'val'=>$totalRiwayat,    'icon'=>'fa-clock-rotate-left',  'color'=>'#5C8A5C'],
        ];
    @endphp
    @foreach($stats as $s)
    <div class="card fade-up" style="margin-bottom:0;">
        <div class="card-body" style="padding:18px 20px; display:flex; align-items:center; gap:14px;">
            <div style="
                width:44px; height:44px; border-radius:12px;
                background:{{ $s['color'] }}18;
                display:flex; align-items:center; justify-content:center;
                color:{{ $s['color'] }}; font-size:18px; flex-shrink:0;
            "><i class="fas {{ $s['icon'] }}"></i></div>
            <div>
                <div style="font-family:'Playfair Display',serif; font-size:26px; font-weight:700; color:var(--brown-deep);">{{ $s['val'] }}</div>
                <div style="font-size:12px; color:var(--text-muted);">{{ $s['label'] }}</div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Peminjaman Aktif -->
<div class="card fade-up delay-1" style="margin-bottom:24px;">
    <div class="card-header">
        <div class="card-title">📌 Peminjaman Aktif</div>
    </div>
    <div class="card-body" style="padding:0;">
        @forelse($peminjamanAktifList as $item)
        <div style="display:flex; align-items:center; gap:16px; padding:16px 24px; border-bottom:1px solid var(--cream-dark);">
            @if($item->buku->cover)
                <img src="{{ asset('storage/' . $item->buku->cover) }}"
                     style="width:40px; height:56px; object-fit:cover; border-radius:6px; flex-shrink:0;">
            @else
                <div style="
                    width:40px; height:56px; border-radius:6px; flex-shrink:0;
                    background:linear-gradient(160deg, var(--brown-light), var(--brown-dark));
                    display:flex; align-items:center; justify-content:center;
                    color:rgba(255,255,255,.5); font-size:16px;
                "><i class="fas fa-book"></i></div>
            @endif
            <div style="flex:1;">
                <div style="font-weight:600; font-size:14px; color:var(--text-dark);">{{ $item->buku->judul }}</div>
                <div style="font-size:12px; color:var(--text-muted); margin-top:2px;">{{ $item->buku->penulis }}</div>
                <div style="font-size:12px; color:var(--text-muted); margin-top:4px;">
                    Dipinjam: {{ $item->tanggal_pinjam->format('d M Y') }}
                    &nbsp;·&nbsp;
                    Harus kembali:
                    <span style="
                        color:{{ $item->tanggal_kembali->isPast() ? '#8A4A3C' : 'var(--text-mid)' }};
                        font-weight:{{ $item->tanggal_kembali->isPast() ? '600' : '400' }};
                    ">{{ $item->tanggal_kembali->format('d M Y') }}</span>
                </div>
                @if($item->denda > 0)
                <div style="font-size:12px; color:#8A4A3C; margin-top:2px; font-weight:600;">
                    Denda: Rp {{ number_format($item->denda, 0, ',', '.') }}
                </div>
                @endif
            </div>
            @if($item->tanggal_kembali->isPast())
                <span class="badge badge-red">Terlambat</span>
            @else
                <span class="badge badge-gold">Dipinjam</span>
            @endif
        </div>
        @empty
        <div style="text-align:center; padding:48px; color:var(--text-muted);">
            <div style="font-size:36px; margin-bottom:12px; opacity:.3;">📭</div>
            <div style="font-size:14px;">Tidak ada peminjaman aktif.</div>
        </div>
        @endforelse
    </div>
</div>

<!-- Daftar Buku Tersedia -->
<div class="card fade-up delay-1" style="margin-bottom:24px;">
    <div class="card-header">
        <div class="card-title">📚 Daftar Buku Tersedia</div>
    </div>
    <div style="display:grid; grid-template-columns:repeat(4, 1fr); gap:16px; padding:20px 24px;">
        @forelse($bukuTersedia as $buku)
        <div style="
            border:1px solid var(--cream-darker);
            border-radius:var(--radius-sm);
            overflow:hidden;
            transition:box-shadow .2s;
        " onmouseover="this.style.boxShadow='var(--shadow-md)'"
           onmouseout="this.style.boxShadow='none'">
            @if($buku->cover)
                <img src="{{ asset('storage/' . $buku->cover) }}"
                     style="width:100%; height:140px; object-fit:cover;">
            @else
                <div style="
                    width:100%; height:140px;
                    background:linear-gradient(160deg, var(--brown-light), var(--brown-dark));
                    display:flex; align-items:center; justify-content:center;
                    color:rgba(255,255,255,.4); font-size:32px;
                "><i class="fas fa-book"></i></div>
            @endif
            <div style="padding:12px;">
                <div style="
                    font-weight:600; font-size:13px; color:var(--text-dark); line-height:1.4;
                    display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;
                ">{{ $buku->judul }}</div>
                <div style="font-size:11px; color:var(--text-muted); margin-top:4px;">{{ $buku->penulis }}</div>
                <div style="margin-top:8px;">
                    <span class="badge badge-green" style="font-size:10px;">{{ $buku->stok }} tersedia</span>
                </div>
            </div>
        </div>
        @empty
        <div style="grid-column:1/-1; text-align:center; padding:48px; color:var(--text-muted);">
            <div style="font-size:36px; margin-bottom:12px; opacity:.3;">📖</div>
            <div style="font-size:14px;">Belum ada buku tersedia.</div>
        </div>
        @endforelse
    </div>
</div>

<!-- Riwayat Peminjaman -->
<div class="card fade-up delay-2">
    <div class="card-header">
        <div class="card-title">🕘 Riwayat Peminjaman</div>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Judul Buku</th>
                    <th>Tgl Pinjam</th>
                    <th>Tgl Kembali</th>
                    <th>Dikembalikan</th>
                    <th>Denda</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($riwayat as $i => $item)
                <tr>
                    <td style="color:var(--text-muted); font-size:13px;">{{ $i + 1 }}</td>
                    <td>
                        <div style="font-weight:600; font-size:13px; color:var(--text-dark);">{{ $item->buku->judul }}</div>
                        <div style="font-size:11px; color:var(--text-muted);">{{ $item->buku->penulis }}</div>
                    </td>
                    <td style="font-size:13px; color:var(--text-mid);">{{ $item->tanggal_pinjam->format('d M Y') }}</td>
                    <td style="font-size:13px; color:var(--text-mid);">{{ $item->tanggal_kembali->format('d M Y') }}</td>
                    <td style="font-size:13px; color:var(--text-mid);">
                        {{ $item->tanggal_dikembalikan ? $item->tanggal_dikembalikan->format('d M Y') : '-' }}
                    </td>
                    <td style="font-size:13px; color:{{ $item->denda > 0 ? '#8A4A3C' : 'var(--text-muted)' }}; font-weight:{{ $item->denda > 0 ? '600' : '400' }};">
                        {{ $item->denda > 0 ? 'Rp ' . number_format($item->denda, 0, ',', '.') : '-' }}
                    </td>
                    <td>
                        @if($item->status === 'dikembalikan')
                            <span class="badge badge-green">Dikembalikan</span>
                        @elseif($item->status === 'terlambat')
                            <span class="badge badge-red">Terlambat</span>
                        @else
                            <span class="badge badge-gold">Dipinjam</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center; padding:48px; color:var(--text-muted);">
                        <div style="font-size:36px; margin-bottom:12px; opacity:.3;">🕘</div>
                        <div>Belum ada riwayat peminjaman.</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection