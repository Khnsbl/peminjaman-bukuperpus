@extends('layouts.admin')

@section('title', 'Peminjaman')
@section('page-title', 'Kelola Peminjaman')
@section('page-sub', 'Monitor dan kelola transaksi peminjaman buku')

@section('content')

{{-- ─── STATUS FILTER TABS ─── --}}
<div style="display:flex; gap:8px; flex-wrap:wrap; margin-bottom:24px;" class="fade-up">
    @php
        $tabs = [
            ['key' => 'all',          'label' => 'Semua',        'count' => $total],
            ['key' => 'aktif',        'label' => 'Aktif',        'count' => $aktif],
            ['key' => 'terlambat',    'label' => 'Terlambat',    'count' => $terlambat],
            ['key' => 'dikembalikan', 'label' => 'Dikembalikan', 'count' => $dikembalikan],
        ];
        $activeTab = request('status', 'all');
    @endphp

    @foreach($tabs as $tab)
    <a href="{{ route('admin.peminjaman.index', ['status' => $tab['key']]) }}"
       style="
        display:inline-flex; align-items:center; gap:8px;
        padding:9px 18px; border-radius:10px;
        font-size:13px; font-weight:600; text-decoration:none;
        border:1.5px solid {{ $activeTab === $tab['key'] ? 'var(--brown)' : 'var(--cream-darker)' }};
        background:{{ $activeTab === $tab['key'] ? 'var(--brown)' : 'var(--white)' }};
        color:{{ $activeTab === $tab['key'] ? 'white' : 'var(--text-mid)' }};
        transition:all .2s;
       ">
        {{ $tab['label'] }}
        <span style="
            background:{{ $activeTab === $tab['key'] ? 'rgba(255,255,255,.25)' : 'var(--cream-dark)' }};
            color:{{ $activeTab === $tab['key'] ? 'white' : 'var(--text-soft)' }};
            padding:1px 8px; border-radius:20px; font-size:11px;
        ">{{ $tab['count'] }}</span>
    </a>
    @endforeach

    <div style="margin-left:auto; display:flex; gap:8px;">
        <div class="search-wrap" style="width:240px;">
            <i class="fas fa-magnifying-glass"></i>
            <input type="text" class="form-control" placeholder="Cari peminjaman…"
                   onkeyup="filterPeminjaman(this.value)">
        </div>
    </div>
</div>

{{-- ─── SUMMARY CARDS ─── --}}
<div style="display:grid; grid-template-columns:repeat(4,1fr); gap:16px; margin-bottom:24px;">
    @php
        $pCards = [
            ['label' => 'Total Aktif',          'val' => $aktif,      'icon' => 'fa-hand-holding-heart',   'color' => 'var(--gold)',  'sub' => 'sedang dipinjam'],
            ['label' => 'Jatuh Tempo Hari Ini', 'val' => $jatuhTempo, 'icon' => 'fa-calendar-day',         'color' => 'var(--brown)', 'sub' => 'harus dikembalikan'],
            ['label' => 'Perlu Tindakan',        'val' => $terlambat,  'icon' => 'fa-triangle-exclamation', 'color' => '#8A4A3C',      'sub' => 'terlambat / review'],
            ['label' => 'Dikembalikan',          'val' => $returned,   'icon' => 'fa-circle-check',         'color' => '#5C8A5C',      'sub' => 'bulan ini'],
        ];
    @endphp
    @foreach($pCards as $i => $pc)
    <div style="
        background:var(--white); border-radius:var(--radius-sm);
        padding:18px 20px; border:1px solid var(--cream-darker);
        box-shadow:var(--shadow-sm);
        border-left:4px solid {{ $pc['color'] }};
    " class="fade-up delay-{{ $i }}">
        <div style="display:flex; align-items:flex-start; justify-content:space-between;">
            <div>
                <div style="font-size:12px; color:var(--text-muted); margin-bottom:6px;">{{ $pc['label'] }}</div>
                <div style="font-family:'Playfair Display',serif; font-size:28px; font-weight:700; color:var(--brown-deep); line-height:1;">
                    {{ $pc['val'] }}
                </div>
                <div style="font-size:11px; color:var(--text-muted); margin-top:4px;">{{ $pc['sub'] }}</div>
            </div>
            <div style="
                width:40px; height:40px; border-radius:11px;
                background:{{ $pc['color'] }}18;
                display:flex; align-items:center; justify-content:center;
                color:{{ $pc['color'] }}; font-size:16px;
            "><i class="fas {{ $pc['icon'] }}"></i></div>
        </div>
    </div>
    @endforeach
</div>

{{-- ─── TABEL PEMINJAMAN ─── --}}
<div class="card fade-up delay-2">
    <div class="card-header">
        <div class="card-title">Daftar Peminjaman</div>
    </div>

    <div class="table-wrap">
        <table id="peminjamanTable">
            <thead>
                <tr>
                    <th style="width:44px;">#</th>
                    <th>Anggota</th>
                    <th>Buku</th>
                    <th>Tgl Pinjam</th>
                    <th>Tgl Kembali</th>
                    <th>Denda</th>
                    <th>Status</th>
                    <th style="text-align:right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peminjaman as $i => $p)
                <tr>
                    {{-- Nomor --}}
                    <td style="color:var(--text-muted); font-size:12px;">
                        {{ ($peminjaman->currentPage() - 1) * $peminjaman->perPage() + $i + 1 }}
                    </td>

                    {{-- Anggota --}}
                    <td>
                        <div style="display:flex; align-items:center; gap:10px;">
                            <div style="
                                width:34px; height:34px; border-radius:50%;
                                background:linear-gradient(135deg, var(--brown-light), var(--brown-dark));
                                display:flex; align-items:center; justify-content:center;
                                font-size:13px; color:white; font-weight:600; flex-shrink:0;
                            ">{{ substr($p->user->name ?? 'U', 0, 1) }}</div>
                            <div>
                                <div style="font-weight:500; font-size:13px;">{{ $p->user->name ?? '-' }}</div>
                                <div style="font-size:11px; color:var(--text-muted);">{{ $p->user->email ?? '' }}</div>
                            </div>
                        </div>
                    </td>

                    {{-- Buku --}}
                    <td>
                        <div style="font-weight:500; font-size:13px; color:var(--text-dark);">{{ $p->buku->judul ?? '-' }}</div>
                        <div style="font-size:11px; color:var(--text-muted);">{{ $p->buku->penulis ?? '' }}</div>
                    </td>

                    {{-- Tgl Pinjam --}}
                    <td style="font-size:13px; color:var(--text-mid);">
                        {{ $p->tanggal_pinjam ? $p->tanggal_pinjam->format('d M Y') : '-' }}
                    </td>

                    {{-- Tgl Kembali --}}
                    <td>
                        @php
                            $hariTerlambat = 0;
                            if ($p->tanggal_kembali && !in_array($p->status, ['dikembalikan','terlambat','ditolak'])) {
                                $hariTerlambat = (int) $p->tanggal_kembali->diffInDays(now(), false);
                            }
                        @endphp
                        <div style="font-size:13px; {{ $hariTerlambat > 0 ? 'color:#8A4A3C; font-weight:600;' : 'color:var(--text-mid);' }}">
                            {{ $p->tanggal_kembali ? $p->tanggal_kembali->format('d M Y') : '-' }}
                        </div>
                        @if($hariTerlambat > 0)
                            <div style="font-size:11px; color:#8A4A3C;">+{{ $hariTerlambat }} hari</div>
                        @endif
                    </td>

                    {{-- Denda --}}
                    <td>
                        @if($p->denda > 0)
                            <span style="font-weight:600; color:#8A4A3C;">
                                Rp {{ number_format($p->denda, 0, ',', '.') }}
                            </span>
                            @if($p->denda_dibayar)
                                <div style="font-size:10px; color:#16A34A;">✅ Lunas</div>
                            @else
                                <div style="font-size:10px; color:#DC2626;">⚠ Belum bayar</div>
                            @endif
                        @else
                            <span style="color:var(--text-muted);">—</span>
                        @endif
                    </td>

                    {{-- Status --}}
                    <td>
                        @php
                            $statusBadge = match($p->status) {
                                'menunggu'           => ['badge-blue',  'Menunggu'],
                                'dipinjam'           => ['badge-green', 'Dipinjam'],
                                'pengajuan_kembali'  => ['badge-brown', 'Pengajuan Kembali'],
                                'terlambat_review'   => ['badge-red',   'Review Terlambat'],
                                'menunggu_bayar'     => ['badge-red',   'Bayar Denda'],
                                'dikembalikan'       => ['badge-brown', 'Dikembalikan'],
                                'terlambat'          => ['badge-red',   'Selesai (Terlambat)'],
                                'ditolak'            => ['badge-blue',  'Ditolak'],
                                default              => ['badge-blue',  ucfirst($p->status)],
                            };
                        @endphp
                        <span class="badge {{ $statusBadge[0] }}">{{ $statusBadge[1] }}</span>
                    </td>

                    {{-- Aksi --}}
                    <td>
                        <div style="display:flex; justify-content:flex-end; gap:6px; flex-wrap:wrap;">

                            {{-- [menunggu] → Approve / Tolak --}}
                            @if($p->status === 'menunggu')
                                <form action="{{ route('admin.peminjaman.approve', $p->id) }}" method="POST"
                                      onsubmit="return confirm('Setujui peminjaman ini?')" style="display:inline;">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn btn-primary btn-sm" title="Approve">
                                        <i class="fas fa-check"></i> Setuju
                                    </button>
                                </form>
                                <form action="{{ route('admin.peminjaman.tolak', $p->id) }}" method="POST"
                                      onsubmit="return confirm('Tolak peminjaman ini?')" style="display:inline;">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Tolak">
                                        <i class="fas fa-times"></i> Tolak
                                    </button>
                                </form>
                            @endif

                            {{-- [pengajuan_kembali] → Konfirmasi Pengembalian --}}
                            @if($p->status === 'pengajuan_kembali')
                                <form action="{{ route('admin.peminjaman.konfirmasiKembali', $p->id) }}" method="POST"
                                      onsubmit="return confirm('Konfirmasi pengembalian buku ini?')" style="display:inline;">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn btn-gold btn-sm" title="Konfirmasi Kembali">
                                        <i class="fas fa-rotate-left"></i> Konfirmasi
                                    </button>
                                </form>
                            @endif

                            {{-- [terlambat_review] → Form Review Keterlambatan --}}
                            @if($p->status === 'terlambat_review')
                                <button type="button" class="btn btn-outline btn-sm"
                                        onclick="openReviewModal({{ $p->id }}, '{{ addslashes($p->buku->judul ?? '-') }}', {{ $p->jumlahHariTerlambat() }})"
                                        title="Review Keterlambatan">
                                    <i class="fas fa-gavel"></i> Review
                                </button>
                            @endif

                            {{-- [menunggu_bayar] → Konfirmasi Bayar Denda --}}
                            @if($p->status === 'menunggu_bayar')
                                <form action="{{ route('admin.peminjaman.konfirmasiBayar', $p->id) }}" method="POST"
                                      onsubmit="return confirm('Konfirmasi pembayaran denda sudah diterima?')" style="display:inline;">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn btn-outline btn-sm" title="Konfirmasi Bayar">
                                        <i class="fas fa-money-bill"></i> Bayar
                                    </button>
                                </form>
                            @endif

                            {{-- Status selesai → tidak ada aksi --}}
                            @if(in_array($p->status, ['dikembalikan', 'terlambat', 'ditolak', 'dipinjam']))
                                <span style="color:var(--text-muted); font-size:12px;">—</span>
                            @endif

                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center; padding:60px; color:var(--text-muted);">
                        <div style="font-size:40px; margin-bottom:12px; opacity:.3;">📋</div>
                        <div style="font-family:'Playfair Display',serif; font-size:16px; color:var(--text-soft);">
                            Belum ada peminjaman
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($peminjaman->hasPages())
    <div style="padding:16px 24px; border-top:1px solid var(--cream-dark); display:flex; align-items:center; justify-content:space-between;">
        <div style="font-size:13px; color:var(--text-muted);">
            Halaman {{ $peminjaman->currentPage() }} dari {{ $peminjaman->lastPage() }}
            &nbsp;·&nbsp; Total {{ $peminjaman->total() }} data
        </div>
        {{ $peminjaman->appends(request()->query())->links() }}
    </div>
    @endif
</div>

{{-- ─── MODAL REVIEW TERLAMBAT ─── --}}
<div id="reviewModal" style="
    display:none; position:fixed; inset:0; z-index:9999;
    background:rgba(0,0,0,.45); align-items:center; justify-content:center;
">
    <div style="
        background:#fff; border-radius:16px; padding:28px 32px;
        width:100%; max-width:440px; box-shadow:0 20px 60px rgba(0,0,0,.2);
        position:relative;
    ">
        <button onclick="closeReviewModal()" style="
            position:absolute; top:14px; right:16px;
            background:none; border:none; font-size:20px; cursor:pointer; color:#999;
        ">✕</button>

        <div style="font-family:'Playfair Display',serif; font-size:18px; color:#2C1810; margin-bottom:6px;">
            Review Keterlambatan
        </div>
        <div id="reviewModalSub" style="font-size:13px; color:#8B6B55; margin-bottom:22px;"></div>

        <form id="reviewModalForm" method="POST" onsubmit="return validateReview()">
            @csrf @method('PATCH')

            <div style="margin-bottom:16px;">
                <label style="font-size:13px; font-weight:600; color:#2C1810; display:block; margin-bottom:8px;">
                    Keputusan
                </label>
                <div style="display:flex; gap:10px;">
                    <label style="flex:1; border:1.5px solid #e2d8d0; border-radius:10px; padding:12px; cursor:pointer; display:flex; align-items:center; gap:8px; font-size:13px;">
                        <input type="radio" name="keputusan" value="denda" onchange="toggleDendaInput(true)" required>
                        💸 Beri Denda
                    </label>
                    <label style="flex:1; border:1.5px solid #e2d8d0; border-radius:10px; padding:12px; cursor:pointer; display:flex; align-items:center; gap:8px; font-size:13px;">
                        <input type="radio" name="keputusan" value="tidak" onchange="toggleDendaInput(false)" required>
                        ✅ Tanpa Denda
                    </label>
                </div>
            </div>

            <div id="dendaInputWrap" style="display:none; margin-bottom:16px;">
                <label style="font-size:13px; font-weight:600; color:#2C1810; display:block; margin-bottom:6px;">
                    Nominal Denda (Rp)
                </label>
                <input type="number" name="denda" id="dendaInput" min="0" placeholder="Contoh: 5000"
                       class="form-control" style="width:100%;">
                <div style="font-size:11px; color:#8B6B55; margin-top:4px;" id="dendaSuggestion"></div>
            </div>

            <button type="submit" class="btn btn-primary" style="width:100%;">
                <i class="fas fa-check"></i> Simpan Keputusan
            </button>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
// ── Filter tabel lokal ──────────────────────────────────────────────────────
function filterPeminjaman(val) {
    const rows = document.querySelectorAll('#peminjamanTable tbody tr');
    rows.forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(val.toLowerCase()) ? '' : 'none';
    });
}

// ── Modal Review Keterlambatan ──────────────────────────────────────────────
let currentPeminjamanId = null;

function openReviewModal(id, judul, hariTerlambat) {
    currentPeminjamanId = id;
    document.getElementById('reviewModalForm').action = `/admin/peminjaman/${id}/review-terlambat`;
    document.getElementById('reviewModalSub').textContent =
        `Buku: ${judul} · Terlambat ${hariTerlambat} hari`;
    document.getElementById('dendaSuggestion').textContent =
        `Saran denda: Rp ${(hariTerlambat * 1000).toLocaleString('id-ID')} (Rp 1.000/hari)`;
    document.getElementById('reviewModal').style.display = 'flex';
}

function closeReviewModal() {
    document.getElementById('reviewModal').style.display = 'none';
    document.getElementById('reviewModalForm').reset();
    toggleDendaInput(false);
}

function toggleDendaInput(show) {
    document.getElementById('dendaInputWrap').style.display = show ? 'block' : 'none';
    document.getElementById('dendaInput').required = show;
}

function validateReview() {
    const keputusan = document.querySelector('input[name="keputusan"]:checked');
    if (!keputusan) { alert('Pilih keputusan terlebih dahulu.'); return false; }
    if (keputusan.value === 'denda') {
        const denda = document.getElementById('dendaInput').value;
        if (!denda || parseInt(denda) < 0) { alert('Masukkan nominal denda yang valid.'); return false; }
    }
    return true;
}

// Tutup modal jika klik overlay
document.getElementById('reviewModal').addEventListener('click', function(e) {
    if (e.target === this) closeReviewModal();
});
</script>
@endpush