@extends('layouts.admin')

@section('title', 'Kelola Buku')
@section('page-title', 'Kelola Buku')
@section('page-sub', 'Manajemen koleksi buku perpustakaan')

@section('content')

<div class="fade-up">

    <!-- Header Actions -->
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <div class="search-wrap" style="width:300px;">
            <i class="fas fa-magnifying-glass"></i>
            <input type="text" class="form-control" placeholder="Cari judul, penulis, ISBN…"
                   onkeyup="filterTable(this.value)">
        </div>
        <a href="{{ route('admin.buku.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Buku
        </a>
    </div>

    <!-- Table Card -->
    <div class="card fade-up">
        <div class="card-header">
            <div class="card-title">Daftar Buku</div>
            <span style="font-size:13px; color:var(--text-muted);">Total: {{ $bukus->total() }} buku</span>
        </div>
        <div class="table-wrap">
            <table id="bukuTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Buku</th>
                        <th>Kategori</th>
                        <th>ISBN</th>
                        <th>Stok</th>
                        <th>Tahun</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bukus as $i => $buku)
                    <tr>
                        <td style="color:var(--text-muted); font-size:13px;">{{ $bukus->firstItem() + $i }}</td>
                        <td>
                            <div style="display:flex; align-items:center; gap:12px;">
                                @if($buku->cover)
                                    <img src="{{ asset('storage/' . $buku->cover) }}"
                                         style="width:36px; height:48px; object-fit:cover; border-radius:4px; flex-shrink:0;">
                                @else
                                    <div style="
                                        width:36px; height:48px; border-radius:4px; flex-shrink:0;
                                        background:linear-gradient(160deg, var(--brown-light), var(--brown-dark));
                                        display:flex; align-items:center; justify-content:center;
                                        color:rgba(255,255,255,.5); font-size:14px;
                                    "><i class="fas fa-book"></i></div>
                                @endif
                                <div>
                                    <div style="font-weight:600; font-size:13px; color:var(--text-dark);">{{ $buku->judul }}</div>
                                    <div style="font-size:12px; color:var(--text-muted); margin-top:2px;">{{ $buku->penulis }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            {{-- ✅ Fix: nama → nama_kategori --}}
                            <span class="badge badge-brown">{{ $buku->kategori->nama_kategori ?? '-' }}</span>
                        </td>
                        <td style="font-size:13px; color:var(--text-soft);">{{ $buku->isbn ?? '-' }}</td>
                        <td>
                            <span class="badge {{ $buku->stok > 0 ? 'badge-green' : 'badge-red' }}">
                                {{ $buku->stok }} tersedia
                            </span>
                        </td>
                        <td style="font-size:13px; color:var(--text-soft);">{{ $buku->tahun_terbit ?? '-' }}</td>
                        <td>
                            <div style="display:flex; gap:6px;">
                                <a href="{{ route('admin.buku.edit', $buku->id) }}"
                                   class="btn btn-outline btn-sm" title="Edit">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <form action="{{ route('admin.buku.destroy', $buku->id) }}" method="POST"
                                      onsubmit="return confirm('Hapus buku ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align:center; padding:40px; color:var(--text-muted);">
                            <i class="fas fa-book-open" style="font-size:32px; margin-bottom:12px; display:block; opacity:.3;"></i>
                            Belum ada buku. <a href="{{ route('admin.buku.create') }}" style="color:var(--brown);">Tambah sekarang</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($bukus->hasPages())
        <div style="padding:16px 24px; border-top:1px solid var(--cream-dark); display:flex; justify-content:flex-end;">
            {{ $bukus->links() }}
        </div>
        @endif
    </div>

</div>

@endsection

@push('scripts')
<script>
function filterTable(val) {
    const rows = document.querySelectorAll('#bukuTable tbody tr');
    val = val.toLowerCase();
    rows.forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(val) ? '' : 'none';
    });
}
</script>
@endpush