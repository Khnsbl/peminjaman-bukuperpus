@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-sub', 'Selamat datang kembali, ' . (auth()->user()->name ?? 'Admin') . '!')

@section('content')

<!-- ═══ STAT CARDS ═══ -->
<div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap:20px; margin-bottom:28px;">

    <div class="stat-card brown fade-up">
        <div class="stat-icon"><i class="fas fa-book-open"></i></div>
        <div class="stat-value">{{ $totalBuku ?? '1,248' }}</div>
        <div class="stat-label">Total Buku</div>
        <div class="stat-trend up"><i class="fas fa-arrow-trend-up"></i> +12 bulan ini</div>
    </div>

    <div class="stat-card gold fade-up delay-1">
        <div class="stat-icon"><i class="fas fa-hand-holding-heart"></i></div>
        <div class="stat-value">{{ $aktifPeminjaman ?? '87' }}</div>
        <div class="stat-label">Peminjaman Aktif</div>
        <div class="stat-trend up"><i class="fas fa-arrow-trend-up"></i> +5 minggu ini</div>
    </div>

    <div class="stat-card green fade-up delay-2">
        <div class="stat-icon"><i class="fas fa-users"></i></div>
        <div class="stat-value">{{ $totalMember ?? '342' }}</div>
        <div class="stat-label">Total Member</div>
        <div class="stat-trend up"><i class="fas fa-arrow-trend-up"></i> +18 baru</div>
    </div>

    <div class="stat-card red fade-up delay-3">
        <div class="stat-icon"><i class="fas fa-triangle-exclamation"></i></div>
        <div class="stat-value">{{ $bukuTerlambat ?? '14' }}</div>
        <div class="stat-label">Terlambat Kembali</div>
        <div class="stat-trend down"><i class="fas fa-arrow-trend-down"></i> perlu tindakan</div>
    </div>

</div>

<!-- ═══ ROW 2: Chart + Activity ═══ -->
<div style="display:grid; grid-template-columns: 1fr 340px; gap:20px; margin-bottom:28px;">

    <!-- Activity Chart Card -->
    <div class="card fade-up delay-1">
        <div class="card-header">
            <div>
                <div class="card-title">Aktivitas Peminjaman</div>
                <div style="font-size:12px; color:var(--text-muted); margin-top:2px;">6 bulan terakhir</div>
            </div>
            <div style="display:flex; gap:8px;">
                <button class="btn btn-outline btn-sm">Minggu</button>
                <button class="btn btn-primary btn-sm">Bulan</button>
            </div>
        </div>
        <div class="card-body" style="padding-bottom:8px;">
            <div style="display:flex; align-items:flex-end; gap:10px; height:160px; padding:12px 0;">
                @php
                    $bars = [
                        ['label'=>'Nov', 'h'=>55, 'val'=>44],
                        ['label'=>'Des', 'h'=>72, 'val'=>58],
                        ['label'=>'Jan', 'h'=>48, 'val'=>39],
                        ['label'=>'Feb', 'h'=>88, 'val'=>71],
                        ['label'=>'Mar', 'h'=>65, 'val'=>53],
                        ['label'=>'Apr', 'h'=>100,'val'=>87],
                    ];
                @endphp
                @foreach($bars as $i => $bar)
                <div style="flex:1; display:flex; flex-direction:column; align-items:center; gap:6px; height:100%; justify-content:flex-end;">
                    <div style="font-size:11px; color:var(--text-soft); font-weight:600;">{{ $bar['val'] }}</div>
                    <div style="
                        width:100%;
                        height: {{ $bar['h'] }}%;
                        background: {{ $i === 5 ? 'linear-gradient(180deg, var(--gold), var(--brown))' : 'linear-gradient(180deg, var(--cream-darker), var(--cream-dark))' }};
                        border-radius:8px 8px 4px 4px;
                        transition: all .3s;
                        position:relative;
                        cursor:pointer;
                    " onmouseover="this.style.opacity='.8'" onmouseout="this.style.opacity='1'"></div>
                    <div style="font-size:11px; color:var(--text-muted); font-weight:500;">{{ $bar['label'] }}</div>
                </div>
                @endforeach
            </div>

            <!-- Legend -->
            <div style="display:flex; gap:20px; padding:12px 0 4px; border-top:1px solid var(--cream-dark);">
                <div style="display:flex; align-items:center; gap:6px; font-size:12px; color:var(--text-soft);">
                    <div style="width:10px; height:10px; background:linear-gradient(var(--gold),var(--brown)); border-radius:3px;"></div>
                    Bulan ini
                </div>
                <div style="display:flex; align-items:center; gap:6px; font-size:12px; color:var(--text-soft);">
                    <div style="width:10px; height:10px; background:var(--cream-darker); border-radius:3px;"></div>
                    Bulan lalu
                </div>
            </div>
        </div>
    </div>

    <!-- Kategori Populer -->
    <div class="card fade-up delay-2">
        <div class="card-header">
            <div class="card-title">Kategori Populer</div>
        </div>
        <div class="card-body" style="padding-top:16px;">
            @php
                $kategori = [
                    ['name'=>'Fiksi',       'pct'=>78, 'count'=>342],
                    ['name'=>'Sains',        'pct'=>61, 'count'=>267],
                    ['name'=>'Sejarah',      'pct'=>45, 'count'=>198],
                    ['name'=>'Teknologi',    'pct'=>37, 'count'=>163],
                    ['name'=>'Biografi',     'pct'=>22, 'count'=>98],
                ];
            @endphp
            @foreach($kategori as $k)
            <div style="margin-bottom:18px;">
                <div style="display:flex; justify-content:space-between; margin-bottom:6px;">
                    <span style="font-size:13px; font-weight:500; color:var(--text-dark);">{{ $k['name'] }}</span>
                    <span style="font-size:12px; color:var(--text-muted);">{{ $k['count'] }} buku</span>
                </div>
                <div style="height:7px; background:var(--cream-dark); border-radius:10px; overflow:hidden;">
                    <div style="
                        height:100%;
                        width:{{ $k['pct'] }}%;
                        background:linear-gradient(90deg, var(--brown), var(--gold));
                        border-radius:10px;
                        transition: width .8s ease;
                    "></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

</div>

<!-- ═══ ROW 3: Recent Peminjaman + Quick Actions ═══ -->
<div style="display:grid; grid-template-columns: 1fr 300px; gap:20px;">

    <!-- Recent Peminjaman Table -->
    <div class="card fade-up delay-2">
        <div class="card-header">
            <div class="card-title">Peminjaman Terbaru</div>
            <a href="{{ route('admin.peminjaman.index') }}" class="btn btn-outline btn-sm">
                Lihat Semua <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Anggota</th>
                        <th>Buku</th>
                        <th>Tgl Pinjam</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $recent = [
                            ['user'=>'Budi Santoso',   'buku'=>'Laskar Pelangi',        'tgl'=>'24 Apr 2025', 'status'=>'aktif'],
                            ['user'=>'Siti Rahayu',    'buku'=>'Bumi Manusia',           'tgl'=>'23 Apr 2025', 'status'=>'aktif'],
                            ['user'=>'Ahmad Fauzi',    'buku'=>'Negeri 5 Menara',        'tgl'=>'22 Apr 2025', 'status'=>'terlambat'],
                            ['user'=>'Dewi Permata',   'buku'=>'Sapiens',                'tgl'=>'21 Apr 2025', 'status'=>'dikembalikan'],
                            ['user'=>'Rizky Pratama',  'buku'=>'The Psychology of Money','tgl'=>'20 Apr 2025', 'status'=>'aktif'],
                        ];
                        $statusMap = [
                            'aktif'        => ['class'=>'badge-green', 'label'=>'Aktif'],
                            'terlambat'    => ['class'=>'badge-red',   'label'=>'Terlambat'],
                            'dikembalikan' => ['class'=>'badge-brown', 'label'=>'Dikembalikan'],
                        ];
                    @endphp
                    @foreach($recent as $r)
                    <tr>
                        <td>
                            <div style="display:flex; align-items:center; gap:10px;">
                                <div style="
                                    width:32px; height:32px; border-radius:50%;
                                    background:linear-gradient(135deg, var(--brown-light), var(--brown-dark));
                                    display:flex; align-items:center; justify-content:center;
                                    font-size:12px; color:white; font-weight:600; flex-shrink:0;
                                ">{{ substr($r['user'],0,1) }}</div>
                                <span style="font-weight:500; font-size:13px;">{{ $r['user'] }}</span>
                            </div>
                        </td>
                        <td style="color:var(--text-mid); font-size:13px;">{{ $r['buku'] }}</td>
                        <td style="color:var(--text-muted); font-size:12px;">{{ $r['tgl'] }}</td>
                        <td>
                            <span class="badge {{ $statusMap[$r['status']]['class'] }}">
                                {{ $statusMap[$r['status']]['label'] }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Quick Actions + Mini Stats -->
    <div style="display:flex; flex-direction:column; gap:16px;">

        <!-- Quick Actions -->
        <div class="card fade-up delay-3">
            <div class="card-header" style="padding-bottom:12px;">
                <div class="card-title">Aksi Cepat</div>
            </div>
            <div class="card-body" style="padding-top:16px; display:flex; flex-direction:column; gap:10px;">
                <a href="{{ route('admin.buku.create') }}" class="btn btn-primary" style="justify-content:center;">
                    <i class="fas fa-plus"></i> Tambah Buku Baru
                </a>
                <a href="{{ route('admin.peminjaman.index') }}" class="btn btn-gold" style="justify-content:center;">
                    <i class="fas fa-hand-holding-heart"></i> Catat Peminjaman
                </a>
                <a href="{{ route('admin.users.create') }}" class="btn btn-outline" style="justify-content:center;">
                    <i class="fas fa-user-plus"></i> Tambah Member
                </a>
            </div>
        </div>

        <!-- Ringkasan Harian -->
        <div class="card fade-up delay-4">
            <div class="card-header" style="padding-bottom:12px;">
                <div class="card-title">Hari Ini</div>
                <span style="font-size:11px; color:var(--text-muted);">{{ now()->format('d M Y') }}</span>
            </div>
            <div class="card-body" style="padding-top:16px;">
                @php
                    $ringkasan = [
                        ['icon'=>'fa-book-open',           'label'=>'Buku dipinjam',    'val'=>'8', 'color'=>'var(--brown)'],
                        ['icon'=>'fa-rotate-left',         'label'=>'Buku dikembalikan','val'=>'5', 'color'=>'var(--gold)'],
                        ['icon'=>'fa-user-plus',           'label'=>'Member baru',      'val'=>'2', 'color'=>'#5C8A5C'],
                        ['icon'=>'fa-triangle-exclamation','label'=>'Denda diterima',   'val'=>'3', 'color'=>'#8A4A3C'],
                    ];
                @endphp
                @foreach($ringkasan as $item)
                <div style="
                    display:flex; align-items:center; gap:12px;
                    padding:10px 0;
                    border-bottom:1px solid var(--cream-dark);
                ">
                    <div style="
                        width:34px; height:34px; border-radius:10px;
                        background:{{ $item['color'] }}18;
                        display:flex; align-items:center; justify-content:center;
                        color:{{ $item['color'] }}; font-size:14px;
                        flex-shrink:0;
                    "><i class="fas {{ $item['icon'] }}"></i></div>
                    <span style="font-size:13px; color:var(--text-mid); flex:1;">{{ $item['label'] }}</span>
                    <span style="font-family:'Playfair Display',serif; font-size:17px; font-weight:700; color:var(--brown-deep);">{{ $item['val'] }}</span>
                </div>
                @endforeach
            </div>
        </div>

    </div>
</div>

@endsection