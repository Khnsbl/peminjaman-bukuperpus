@extends('layouts.admin')

@section('title', 'Pengguna')
@section('page-title', 'Kelola Pengguna')
@section('page-sub', 'Daftar member dan administrator sistem')

@section('content')

<!-- Header Bar -->
<div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:24px;" class="fade-up">
    <div style="display:flex; gap:10px; flex:1; max-width:420px;">
        <div class="search-wrap" style="flex:1;">
            <i class="fas fa-magnifying-glass"></i>
            <input type="text" class="form-control" placeholder="Cari nama, email…" onkeyup="filterUser(this.value)">
        </div>
        <select class="form-control" style="width:auto; min-width:130px;">
            <option>Semua Role</option>
            <option>Admin</option>
            <option>Member</option>
        </select>
    </div>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
        <i class="fas fa-user-plus"></i> Tambah Pengguna
    </a>
</div>

<!-- Stats Row -->
<div style="display:grid; grid-template-columns:repeat(3, 1fr); gap:16px; margin-bottom:24px;">
    @php
        $uStats = [
            ['label'=>'Total Pengguna', 'val'=>$totalUsers  ?? '0', 'icon'=>'fa-users',       'color'=>'var(--brown)'],
            ['label'=>'Member Aktif',   'val'=>$activeUsers ?? '0', 'icon'=>'fa-user-check',  'color'=>'#5C8A5C'],
            ['label'=>'Administrator',  'val'=>$admins      ?? '0', 'icon'=>'fa-user-shield', 'color'=>'var(--gold)'],
        ];
    @endphp
    @foreach($uStats as $s)
    <div style="
        background:var(--white); border-radius:var(--radius-sm);
        padding:18px 20px; border:1px solid var(--cream-darker);
        box-shadow:var(--shadow-sm);
        display:flex; align-items:center; gap:14px;
    " class="fade-up">
        <div style="
            width:44px; height:44px; border-radius:12px;
            background:{{ $s['color'] }}18;
            display:flex; align-items:center; justify-content:center;
            color:{{ $s['color'] }}; font-size:18px;
        "><i class="fas {{ $s['icon'] }}"></i></div>
        <div>
            <div style="font-family:'Playfair Display',serif; font-size:24px; font-weight:700; color:var(--brown-deep);">{{ $s['val'] }}</div>
            <div style="font-size:12px; color:var(--text-muted);">{{ $s['label'] }}</div>
        </div>
    </div>
    @endforeach
</div>

<!-- Users Table -->
<div class="card fade-up delay-1">
    <div class="card-header">
        <div class="card-title">Daftar Pengguna</div>
        <button class="btn btn-outline btn-sm"><i class="fas fa-download"></i> Export</button>
    </div>

    <div class="table-wrap">
        <table id="userTable">
            <thead>
                <tr>
                    <th style="width:44px;">#</th>
                    <th>Pengguna</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Peminjaman</th>
                    <th>Bergabung</th>
                    <th>Status</th>
                    <th style="text-align:right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $i => $user)
                <tr>
                    <td style="color:var(--text-muted); font-size:12px;">
                        {{ ($users->currentPage() - 1) * $users->perPage() + $i + 1 }}
                    </td>
                    <td>
                        <div style="display:flex; align-items:center; gap:12px;">
                            <div style="
                                width:38px; height:38px; border-radius:50%;
                                background:linear-gradient(135deg, var(--brown-light), var(--brown-dark));
                                display:flex; align-items:center; justify-content:center;
                                font-family:'Playfair Display',serif; font-size:14px;
                                color:white; font-weight:600; flex-shrink:0;
                            ">{{ substr($user->name, 0, 1) }}</div>
                            <div>
                                <div style="font-weight:600; font-size:14px;">{{ $user->name }}</div>
                                <div style="font-size:11px; color:var(--text-muted);">No. Anggota: {{ $user->no_anggota ?? 'LIB-' . str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</div>
                            </div>
                        </div>
                    </td>
                    <td style="font-size:13px; color:var(--text-mid);">{{ $user->email }}</td>
                    <td>
                        <span class="badge {{ $user->role === 'admin' ? 'badge-gold' : 'badge-blue' }}">
                            <i class="fas {{ $user->role === 'admin' ? 'fa-user-shield' : 'fa-user' }}" style="font-size:9px;"></i>
                            {{ ucfirst($user->role ?? 'member') }}
                        </span>
                    </td>
                    <td>
                        <span style="font-weight:600; color:var(--brown-deep);">{{ $user->peminjaman_count ?? 0 }}</span>
                        <span style="font-size:11px; color:var(--text-muted);"> buku</span>
                    </td>
                    <td style="font-size:12px; color:var(--text-muted);">{{ $user->created_at->format('d M Y') }}</td>
                    <td>
                        @if($user->is_active ?? true)
                            <span class="badge badge-green"><i class="fas fa-circle" style="font-size:6px;"></i> Aktif</span>
                        @else
                            <span class="badge badge-red"><i class="fas fa-circle" style="font-size:6px;"></i> Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex; justify-content:flex-end; gap:6px;">
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-outline btn-sm" title="Edit">
                                <i class="fas fa-pen"></i>
                            </a>
                            @if($user->id !== auth()->id())
                            <button onclick="confirmDeleteUser({{ $user->id }})" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i>
                            </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center; padding:60px; color:var(--text-muted);">
                        <div style="font-size:40px; margin-bottom:12px; opacity:.3;">👥</div>
                        <div style="font-family:'Playfair Display',serif; font-size:16px; color:var(--text-soft);">Belum ada pengguna</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($users->hasPages())
    <div style="padding:16px 24px; border-top:1px solid var(--cream-dark); display:flex; align-items:center; justify-content:space-between;">
        <div style="font-size:13px; color:var(--text-muted);">
            Halaman {{ $users->currentPage() }} dari {{ $users->lastPage() }}
            &nbsp;·&nbsp; Total {{ $users->total() }} pengguna
        </div>
        <ul class="pagination">
            <li class="page-item {{ $users->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $users->previousPageUrl() ?? '#' }}">
                    <i class="fas fa-chevron-left" style="font-size:11px;"></i>
                </a>
            </li>
            @foreach($users->getUrlRange(1, $users->lastPage()) as $page => $url)
            <li class="page-item {{ $page == $users->currentPage() ? 'active' : '' }}">
                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
            </li>
            @endforeach
            <li class="page-item {{ !$users->hasMorePages() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $users->nextPageUrl() ?? '#' }}">
                    <i class="fas fa-chevron-right" style="font-size:11px;"></i>
                </a>
            </li>
        </ul>
    </div>
    @endif
</div>

<!-- Delete Modal -->
<div class="modal-overlay" id="deleteUserModal">
    <div class="modal-box" style="max-width:400px;">
        <div class="modal-header">
            <div class="modal-title">Hapus Pengguna</div>
            <button class="modal-close" onclick="closeUserModal()"><i class="fas fa-xmark"></i></button>
        </div>
        <div class="modal-body" style="text-align:center; padding:32px 24px;">
            <div style="font-size:48px; margin-bottom:16px;">⚠️</div>
            <div style="font-size:15px; font-weight:500; color:var(--text-dark); margin-bottom:8px;">Hapus pengguna ini?</div>
            <div style="font-size:13px; color:var(--text-muted);">Seluruh data peminjaman terkait akan ikut terhapus.</div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-outline" onclick="closeUserModal()">Batal</button>
            <form id="deleteUserForm" method="POST" style="display:inline;">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger" style="background:rgba(138,74,60,.8); color:white;">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function confirmDeleteUser(id) {
    document.getElementById('deleteUserForm').action = `/admin/users/${id}`;
    document.getElementById('deleteUserModal').classList.add('open');
}
function closeUserModal() {
    document.getElementById('deleteUserModal').classList.remove('open');
}
function filterUser(val) {
    const rows = document.querySelectorAll('#userTable tbody tr');
    rows.forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(val.toLowerCase()) ? '' : 'none';
    });
}
</script>
@endpush