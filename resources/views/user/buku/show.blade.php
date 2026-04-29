@extends('layouts.user')

@section('title', $buku->judul_buku)
@section('page-title', 'Detail Buku')
@section('page-sub', 'Informasi lengkap buku perpustakaan')

@section('content')

<!-- Breadcrumb -->
<div style="display:flex; align-items:center; gap:8px; margin-bottom:24px; font-size:13px;" class="fade-up">
    <a href="{{ route('user.buku.index') }}"
       style="color:var(--text-muted); text-decoration:none; display:flex; align-items:center; gap:5px; transition:color .2s;"
       onmouseover="this.style.color='var(--brown)'" onmouseout="this.style.color='var(--text-muted)'">
        <i class="fas fa-book" style="font-size:11px;"></i> Daftar Buku
    </a>
    <i class="fas fa-chevron-right" style="font-size:9px; color:var(--cream-darker);"></i>
    <span style="color:var(--brown); font-weight:500;">{{ Str::limit($buku->judul_buku, 40) }}</span>
</div>

<!-- ═══ MAIN CONTENT ═══ -->
<div style="display:grid; grid-template-columns:280px 1fr; gap:28px; align-items:start;" class="fade-up">

    <!-- ── KOLOM KIRI: Cover + Aksi ── -->
    <div style="display:flex; flex-direction:column; gap:16px; position:sticky; top:90px;">

        <!-- Cover Card -->
        <div class="card" style="overflow:visible;">
            <div style="padding:20px; text-align:center;">
                @if($buku->cover)
                    <img src="{{ Storage::url($buku->cover) }}"
                         style="
                            width:100%; max-width:200px;
                            border-radius:12px;
                            box-shadow:0 8px 32px rgba(61,37,16,.25);
                            display:block; margin:0 auto;
                         ">
                @else
                    <div style="
                        width:100%; max-width:200px; height:260px;
                        background:linear-gradient(160deg, var(--brown-light), var(--brown-dark));
                        border-radius:12px;
                        display:flex; flex-direction:column;
                        align-items:center; justify-content:center;
                        margin:0 auto;
                        box-shadow:0 8px 32px rgba(61,37,16,.25);
                        gap:12px;
                    ">
                        <i class="fas fa-book-open" style="font-size:48px; color:rgba(255,255,255,.4);"></i>
                        <span style="
                            font-family:'Playfair Display',serif; font-size:12px;
                            color:rgba(255,255,255,.5); text-align:center;
                            padding:0 16px; line-height:1.5;
                        ">{{ $buku->judul_buku }}</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Aksi Pinjam -->
        <div class="card">
            <div style="padding:18px; display:flex; flex-direction:column; gap:10px;">

                <!-- Status stok -->
                <div style="
                    text-align:center; padding:10px;
                    background:{{ $buku->stok > 0 ? 'rgba(92,138,92,.08)' : 'rgba(138,74,60,.08)' }};
                    border-radius:var(--radius-sm);
                    border:1px solid {{ $buku->stok > 0 ? 'rgba(92,138,92,.2)' : 'rgba(138,74,60,.2)' }};
                ">
                    <div style="
                        font-family:'Playfair Display',serif;
                        font-size:26px; font-weight:700;
                        color:{{ $buku->stok > 0 ? '#3A6B3A' : '#7A2A1A' }};
                        line-height:1;
                    ">{{ $buku->stok }}</div>
                    <div style="font-size:12px; color:var(--text-muted); margin-top:3px;">
                        buku tersedia
                    </div>
                </div>

                @if($buku->stok > 0)
                    <a href="{{ route('user.peminjaman.create', $buku) }}"
                       class="btn btn-primary" style="justify-content:center; padding:12px;">
                        <i class="fas fa-hand-holding-heart"></i> Pinjam Buku Ini
                    </a>
                @else
                    <div style="
                        text-align:center; padding:12px;
                        background:rgba(138,74,60,.08);
                        border-radius:var(--radius-sm);
                        color:#8A4A3C; font-size:13px; font-weight:500;
                        display:flex; align-items:center; justify-content:center; gap:8px;
                    ">
                        <i class="fas fa-circle-xmark"></i> Stok sedang habis
                    </div>
                @endif

                <a href="{{ route('user.buku.index') }}"
                   class="btn btn-outline" style="justify-content:center;">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

    </div>

    <!-- ── KOLOM KANAN: Detail Info ── -->
    <div style="display:flex; flex-direction:column; gap:20px;">

        <!-- Judul & Penulis -->
        <div class="card">
            <div style="padding:24px 28px;">
                <!-- Kategori badge -->
                <div style="margin-bottom:12px;">
                    <span class="badge badge-brown" style="font-size:12px; padding:5px 12px;">
                        <i class="fas fa-tag" style="font-size:10px;"></i>
                        {{ $buku->kategori->nama_kategori ?? '-' }}
                    </span>
                </div>

                <h1 style="
                    font-family:'Playfair Display',serif;
                    font-size:26px; font-weight:700;
                    color:var(--brown-deep); line-height:1.3;
                    margin-bottom:8px;
                ">{{ $buku->judul_buku }}</h1>

                <div style="font-size:15px; color:var(--text-soft);">
                    oleh <span style="font-weight:600; color:var(--brown);">{{ $buku->pengarang }}</span>
                </div>
            </div>
        </div>

        <!-- Detail Informasi -->
        <div class="card">
            <div class="card-header">
                <div class="card-title">Informasi Buku</div>
            </div>
            <div style="padding:8px 0;">
                @php
                    $details = [
                        ['icon'=>'fa-barcode',       'label'=>'Kode Buku',    'val'=>$buku->kode_buku],
                        ['icon'=>'fa-user-pen',       'label'=>'Pengarang',   'val'=>$buku->pengarang],
                        ['icon'=>'fa-building',       'label'=>'Penerbit',    'val'=>$buku->penerbit ?? '-'],
                        ['icon'=>'fa-calendar',       'label'=>'Tahun Terbit','val'=>$buku->tahun_terbit ?? '-'],
                        ['icon'=>'fa-language',       'label'=>'Bahasa',      'val'=>$buku->bahasa ?? 'Indonesia'],
                        ['icon'=>'fa-layer-group',    'label'=>'Stok Total',  'val'=>($buku->stok ?? 0) . ' eksemplar'],
                    ];
                @endphp

                @foreach($details as $i => $d)
                <div style="
                    display:flex; align-items:center; gap:16px;
                    padding:14px 24px;
                    {{ !$loop->last ? 'border-bottom:1px solid var(--cream-dark);' : '' }}
                    transition:background .15s;
                " onmouseover="this.style.background='var(--cream)'" onmouseout="this.style.background='transparent'">
                    <div style="
                        width:36px; height:36px; border-radius:10px;
                        background:var(--cream-dark);
                        display:flex; align-items:center; justify-content:center;
                        color:var(--brown-light); font-size:14px; flex-shrink:0;
                    "><i class="fas {{ $d['icon'] }}"></i></div>
                    <div style="flex:1;">
                        <div style="font-size:11px; color:var(--text-muted); font-weight:600; letter-spacing:.4px; text-transform:uppercase; margin-bottom:2px;">
                            {{ $d['label'] }}
                        </div>
                        <div style="font-size:14px; font-weight:500; color:var(--text-dark);">
                            {{ $d['val'] }}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Deskripsi -->
        @if($buku->deskripsi)
        <div class="card">
            <div class="card-header">
                <div class="card-title">Sinopsis</div>
            </div>
            <div style="padding:20px 24px;">
                <p style="
                    font-size:14px; color:var(--text-mid);
                    line-height:1.85; text-align:justify;
                ">{{ $buku->deskripsi }}</p>
            </div>
        </div>
        @endif

        <!-- Ketersediaan visual -->
        <div style="
            background:linear-gradient(135deg, rgba(201,147,58,.07), rgba(139,94,60,.04));
            border:1px solid rgba(201,147,58,.18);
            border-radius:var(--radius);
            padding:20px 24px;
            display:flex; align-items:center; gap:16px;
        ">
            <div style="
                width:48px; height:48px; border-radius:14px;
                background:rgba(201,147,58,.12);
                display:flex; align-items:center; justify-content:center;
                color:var(--gold); font-size:20px; flex-shrink:0;
            "><i class="fas fa-circle-info"></i></div>
            <div>
                <div style="font-size:13px; font-weight:600; color:var(--brown-dark); margin-bottom:3px;">
                    Syarat Peminjaman
                </div>
                <div style="font-size:12px; color:var(--text-soft); line-height:1.6;">
                    Maksimal 7 hari peminjaman · Denda Rp 1.000/hari keterlambatan · Kartu anggota aktif diperlukan
                </div>
            </div>
        </div>

    </div>

</div>

@endsection