@extends('layouts.user')

@section('title', 'Daftar Buku')
@section('page-title', 'Daftar Buku')
@section('page-sub', 'Temukan buku favoritmu dari koleksi perpustakaan')

@section('content')

<!-- ═══ SEARCH & FILTER ═══ -->
<form method="GET" action="{{ route('user.buku.index') }}" class="fade-up">
    <div style="
        background:var(--white);
        border:1px solid var(--cream-darker);
        border-radius:var(--radius);
        padding:20px 24px;
        margin-bottom:24px;
        box-shadow:var(--shadow-sm);
        display:flex; gap:12px; flex-wrap:wrap; align-items:center;
    ">
        <!-- Search input -->
        <div class="search-wrap" style="flex:1; min-width:220px;">
            <i class="fas fa-magnifying-glass"></i>
            <input type="text" name="search" value="{{ request('search') }}"
                   class="form-control" placeholder="Cari judul, penulis, penerbit…">
        </div>

        <!-- Kategori -->
        <select name="kategori" class="form-control" style="width:auto; min-width:180px;">
            <option value="">Semua Kategori</option>
            @foreach($kategoris as $kat)
                <option value="{{ $kat->id }}" {{ request('kategori') == $kat->id ? 'selected' : '' }}>
                    {{ $kat->nama_kategori }}
                </option>
            @endforeach
        </select>

        <button type="submit" class="btn btn-primary">
            <i class="fas fa-magnifying-glass"></i> Cari
        </button>

        @if(request('search') || request('kategori'))
            <a href="{{ route('user.buku.index') }}" class="btn btn-outline">
                <i class="fas fa-rotate-left"></i> Reset
            </a>
        @endif
    </div>
</form>

<!-- ═══ HASIL / GRID ═══ -->
@if($bukus->count() > 0)

    <!-- Info hasil -->
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:16px;" class="fade-up">
        <div style="font-size:13px; color:var(--text-muted);">
            Menampilkan <strong style="color:var(--brown-deep);">{{ $bukus->total() }}</strong> buku
            @if(request('search'))
                untuk "<strong style="color:var(--brown);">{{ request('search') }}</strong>"
            @endif
        </div>
        <!-- View toggle (opsional, saat ini grid) -->
        <div style="display:flex; gap:6px;">
            <div style="
                width:32px; height:32px; border-radius:8px;
                background:var(--brown); color:white;
                display:flex; align-items:center; justify-content:center;
                font-size:13px; cursor:pointer;
            "><i class="fas fa-grip"></i></div>
        </div>
    </div>

    <!-- Grid Buku -->
    <div style="
        display:grid;
        grid-template-columns:repeat(auto-fill, minmax(200px, 1fr));
        gap:20px;
    " class="fade-up delay-1">

        @foreach($bukus as $buku)
        <a href="{{ route('user.buku.show', $buku) }}" style="text-decoration:none; display:block;">
            <div style="
                background:var(--white);
                border:1px solid var(--cream-darker);
                border-radius:var(--radius);
                overflow:hidden;
                transition:box-shadow .25s, transform .25s;
                height:100%;
            "
            onmouseover="this.style.boxShadow='var(--shadow-md)'; this.style.transform='translateY(-4px)'"
            onmouseout="this.style.boxShadow='var(--shadow-sm)'; this.style.transform='none'">

                <!-- Cover -->
                <div style="position:relative; overflow:hidden;">
                    @if($buku->cover)
                        <img src="{{ asset('storage/' . $buku->cover) }}"
                             style="width:100%; height:200px; object-fit:cover; display:block;">
                    @else
                        <div style="
                            width:100%; height:200px;
                            background:linear-gradient(160deg, var(--brown-light), var(--brown-dark));
                            display:flex; align-items:center; justify-content:center;
                            flex-direction:column; gap:8px;
                        ">
                            <i class="fas fa-book-open" style="font-size:40px; color:rgba(255,255,255,.4);"></i>
                            <span style="
                                font-family:'Playfair Display',serif;
                                font-size:11px; color:rgba(255,255,255,.5);
                                text-align:center; padding:0 12px;
                                line-height:1.4;
                            ">{{ Str::limit($buku->judul, 30) }}</span>
                        </div>
                    @endif

                    <!-- Stok badge overlay -->
                    <div style="
                        position:absolute; top:10px; right:10px;
                        background:{{ $buku->stok <= 0 ? 'rgba(138,74,60,.9)' : ($buku->stok <= 3 ? 'rgba(201,147,58,.9)' : 'rgba(61,37,16,.7)') }};
                        color:white;
                        font-size:10px; font-weight:700;
                        padding:3px 8px; border-radius:20px;
                        backdrop-filter:blur(4px);
                    ">
                        {{ $buku->stok <= 0 ? 'Habis' : 'Stok: ' . $buku->stok }}
                    </div>
                </div>

                <!-- Info -->
                <div style="padding:14px;">
                    <div style="
                        font-weight:600; font-size:13px; color:var(--text-dark);
                        line-height:1.4; margin-bottom:5px;
                        display:-webkit-box; -webkit-line-clamp:2;
                        -webkit-box-orient:vertical; overflow:hidden;
                        font-family:'Playfair Display',serif;
                    ">{{ $buku->judul }}</div>

                    <div style="
                        font-size:12px; color:var(--text-soft);
                        margin-bottom:10px;
                        white-space:nowrap; overflow:hidden; text-overflow:ellipsis;
                    ">{{ $buku->penulis }}</div>

                    <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:4px;">
                        <span class="badge badge-brown" style="font-size:10px; padding:3px 8px;">
                            {{ $buku->kategori->nama_kategori ?? '-' }}
                        </span>
                        @if($buku->stok > 0)
                            <span style="font-size:10px; color:#4A7A4A; font-weight:600; display:flex; align-items:center; gap:3px;">
                                <i class="fas fa-circle" style="font-size:5px;"></i> Tersedia
                            </span>
                        @else
                            <span style="font-size:10px; color:#8A4A3C; font-weight:600; display:flex; align-items:center; gap:3px;">
                                <i class="fas fa-circle" style="font-size:5px;"></i> Tidak tersedia
                            </span>
                        @endif
                    </div>
                </div>

            </div>
        </a>
        @endforeach

    </div>

    <!-- Pagination -->
    @if($bukus->hasPages())
    <div style="margin-top:28px; display:flex; justify-content:center;">
        <ul class="pagination">
            {{-- Previous --}}
            <li class="page-item {{ $bukus->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $bukus->previousPageUrl() }}">
                    <i class="fas fa-chevron-left" style="font-size:11px;"></i>
                </a>
            </li>

            @foreach($bukus->getUrlRange(max(1, $bukus->currentPage()-2), min($bukus->lastPage(), $bukus->currentPage()+2)) as $page => $url)
            <li class="page-item {{ $page == $bukus->currentPage() ? 'active' : '' }}">
                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
            </li>
            @endforeach

            {{-- Next --}}
            <li class="page-item {{ !$bukus->hasMorePages() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $bukus->nextPageUrl() }}">
                    <i class="fas fa-chevron-right" style="font-size:11px;"></i>
                </a>
            </li>
        </ul>
    </div>
    @endif

@else
    <!-- Empty State -->
    <div class="card fade-up">
        <div class="card-body" style="text-align:center; padding:80px 32px;">
            <div style="
                width:80px; height:80px; border-radius:24px;
                background:var(--cream-dark);
                display:flex; align-items:center; justify-content:center;
                font-size:36px; margin:0 auto 20px;
            ">📭</div>
            <div style="
                font-family:'Playfair Display',serif;
                font-size:20px; font-weight:600;
                color:var(--brown-deep); margin-bottom:8px;
            ">Buku tidak ditemukan</div>
            <div style="font-size:13px; color:var(--text-muted); max-width:300px; margin:0 auto;">
                @if(request('search') || request('kategori'))
                    Coba ubah kata kunci atau pilih kategori yang berbeda.
                @else
                    Koleksi buku belum tersedia saat ini.
                @endif
            </div>
            @if(request('search') || request('kategori'))
                <a href="{{ route('user.buku.index') }}" class="btn btn-primary" style="margin-top:20px; display:inline-flex;">
                    <i class="fas fa-rotate-left"></i> Lihat Semua Buku
                </a>
            @endif
        </div>
    </div>
@endif

@endsection