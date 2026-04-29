@extends('layouts.admin')

@section('title', 'Kategori')
@section('page-title', 'Kelola Kategori')
@section('page-sub', 'Organisasi kategori koleksi buku')

@section('content')

<div style="display:grid; grid-template-columns: 360px 1fr; gap:24px;" class="fade-up">

    <!-- Add / Edit Form -->
    <div>
        <div class="card" style="position:sticky; top:90px;">
            <div class="card-header">
                <div class="card-title" id="formTitle">Tambah Kategori</div>
            </div>
            <div class="card-body">
                <form id="kategoriForm" action="{{ route('admin.kategoris.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="POST">
                    <input type="hidden" name="id" id="editId">

                    <div class="form-group">
                        <label class="form-label">Nama Kategori <span style="color:#8A4A3C;">*</span></label>
                        <input type="text" name="nama_kategori" id="fieldNama" class="form-control"
                               placeholder="contoh: Fiksi, Sains, Sejarah…" required>
                        @error('nama_kategori') <div style="color:#8A4A3C; font-size:12px; margin-top:4px;">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" id="fieldDeskripsi" class="form-control" rows="3"
                                  placeholder="Deskripsi singkat kategori ini…" style="resize:none;"></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Warna Label</label>
                        <div style="display:flex; gap:8px; flex-wrap:wrap;">
                            @php
                                $colors = ['#8B5E3C','#C9933A','#5C8A5C','#3C5C8A','#8A3C5C','#5C3C8A'];
                            @endphp
                            @foreach($colors as $color)
                            <label style="cursor:pointer;">
                                <input type="radio" name="warna" value="{{ $color }}" style="display:none;">
                                <div style="
                                    width:28px; height:28px; border-radius:50%;
                                    background:{{ $color }};
                                    border:3px solid transparent;
                                    transition:border .2s;
                                " onclick="this.parentElement.querySelector('input').checked=true; document.querySelectorAll('.color-dot').forEach(d=>d.style.border='3px solid transparent'); this.style.border='3px solid var(--cream-darker)';"></div>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <div style="display:flex; gap:8px;">
                        <button type="button" onclick="resetForm()" class="btn btn-outline" style="flex:1;">Reset</button>
                        <button type="submit" class="btn btn-primary" style="flex:2;">
                            <i class="fas fa-plus" id="submitIcon"></i>
                            <span id="submitText">Tambah Kategori</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Categories List -->
    <div>
        <!-- Search -->
        <div class="search-wrap" style="margin-bottom:16px;">
            <i class="fas fa-magnifying-glass"></i>
            <input type="text" class="form-control" placeholder="Cari kategori…" onkeyup="filterKat(this.value)">
        </div>

        <div id="kategoriGrid" style="display:flex; flex-direction:column; gap:12px;">
            @forelse($categories ?? [] as $cat)
            <div class="card" style="transition:all .25s;" onmouseover="this.style.boxShadow='var(--shadow-md)'" onmouseout="this.style.boxShadow='var(--shadow-sm)'">
                <div style="padding:18px 20px; display:flex; align-items:center; gap:16px;">
                    <!-- Color dot -->
                    <div style="
                        width:44px; height:44px; border-radius:12px;
                        background:{{ $cat->warna ?? 'var(--brown)' }}18;
                        display:flex; align-items:center; justify-content:center;
                        font-size:20px; flex-shrink:0;
                    ">
                        <i class="fas fa-tag" style="color:{{ $cat->warna ?? 'var(--brown)' }};"></i>
                    </div>
                    <div style="flex:1;">
                        <div style="font-weight:600; font-size:15px; color:var(--brown-deep);">{{ $cat->nama_kategori }}</div>
                        <div style="font-size:12px; color:var(--text-muted); margin-top:2px;">{{ $cat->deskripsi ?? 'Tidak ada deskripsi' }}</div>
                    </div>
                    <div style="text-align:right; margin-right:4px;">
                        <div style="font-family:'Playfair Display',serif; font-size:22px; font-weight:700; color:var(--brown-deep);">{{ $cat->books_count ?? 0 }}</div>
                        <div style="font-size:11px; color:var(--text-muted);">buku</div>
                    </div>
                    <div style="display:flex; flex-direction:column; gap:6px;">
                        <button onclick="editKategori({{ $cat->id }}, '{{ addslashes($cat->nama_kategori) }}', '{{ addslashes($cat->deskripsi ?? '') }}')"
                                class="btn btn-outline btn-sm" style="width:80px;">
                            <i class="fas fa-pen"></i> Edit
                        </button>
                        <form action="{{ route('admin.kategoris.destroy', $cat->id) }}" method="POST"
                              onsubmit="return confirm('Hapus kategori ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" style="width:80px;">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div style="text-align:center; padding:60px; color:var(--text-muted);">
                <div style="font-size:40px; margin-bottom:12px; opacity:.3;">🏷️</div>
                <div style="font-family:'Playfair Display',serif; font-size:16px; color:var(--text-soft);">Belum ada kategori</div>
                <div style="font-size:13px; margin-top:4px;">Tambahkan kategori pertama di form sebelah kiri</div>
            </div>
            @endforelse
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
function editKategori(id, nama, deskripsi) {
    document.getElementById('formTitle').textContent = 'Edit Kategori';
    document.getElementById('formMethod').value = 'PUT';
    document.getElementById('editId').value = id;
    document.getElementById('fieldNama').value = nama;
    document.getElementById('fieldDeskripsi').value = deskripsi;
    document.getElementById('submitIcon').className = 'fas fa-floppy-disk';
    document.getElementById('submitText').textContent = 'Simpan Perubahan';
    document.getElementById('kategoriForm').action = `/admin/kategoris/${id}`;
    document.getElementById('fieldNama').focus();
    window.scrollTo({top: 0, behavior: 'smooth'});
}

function resetForm() {
    document.getElementById('formTitle').textContent = 'Tambah Kategori';
    document.getElementById('formMethod').value = 'POST';
    document.getElementById('editId').value = '';
    document.getElementById('fieldNama').value = '';
    document.getElementById('fieldDeskripsi').value = '';
    document.getElementById('submitIcon').className = 'fas fa-plus';
    document.getElementById('submitText').textContent = 'Tambah Kategori';
    document.getElementById('kategoriForm').action = '{{ route("admin.kategoris.store") }}';
}

function filterKat(val) {
    document.querySelectorAll('#kategoriGrid .card').forEach(card => {
        card.style.display = card.textContent.toLowerCase().includes(val.toLowerCase()) ? '' : 'none';
    });
}
</script>
@endpush