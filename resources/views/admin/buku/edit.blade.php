@extends('layouts.admin')

@section('title', 'Edit Buku')
@section('page-title', 'Edit Buku')
@section('page-sub', 'Perbarui informasi buku')

@section('content')

<div style="display:grid; grid-template-columns: 1fr 300px; gap:24px;" class="fade-up">

    <!-- Main Form -->
    <div class="card">
        <div class="card-header">
            <div class="card-title">Edit Informasi Buku</div>
            <div style="display:flex; align-items:center; gap:6px; font-size:12px; color:var(--text-muted);">
                <a href="{{ route('admin.buku.index') }}" style="color:var(--text-muted); text-decoration:none;">Kelola Buku</a>
                <i class="fas fa-chevron-right" style="font-size:9px;"></i>
                <span style="color:var(--brown); font-weight:500;">Edit</span>
            </div>
        </div>
        <div class="card-body">
            <form id="editForm" action="{{ route('admin.buku.update', $buku->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">

                    <div class="form-group" style="grid-column:1/-1;">
                        <label class="form-label">Judul Buku <span style="color:#8A4A3C;">*</span></label>
                        <input type="text" name="judul" class="form-control"
                               placeholder="Masukkan judul buku…"
                               value="{{ old('judul', $buku->judul) }}" required>
                        @error('judul')
                            <div style="color:#8A4A3C; font-size:12px; margin-top:4px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Penulis <span style="color:#8A4A3C;">*</span></label>
                        <input type="text" name="penulis" class="form-control"
                               placeholder="Nama penulis"
                               value="{{ old('penulis', $buku->penulis) }}" required>
                        @error('penulis')
                            <div style="color:#8A4A3C; font-size:12px; margin-top:4px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Penerbit</label>
                        <input type="text" name="penerbit" class="form-control"
                               placeholder="Nama penerbit"
                               value="{{ old('penerbit', $buku->penerbit) }}">
                    </div>

                    <div class="form-group">
                        <label class="form-label">ISBN</label>
                        <input type="text" name="isbn" class="form-control"
                               placeholder="978-xxx-xxx-xxx"
                               value="{{ old('isbn', $buku->isbn) }}">
                        @error('isbn')
                            <div style="color:#8A4A3C; font-size:12px; margin-top:4px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Tahun Terbit</label>
                        <input type="number" name="tahun_terbit" class="form-control"
                               placeholder="{{ date('Y') }}"
                               min="1900" max="{{ date('Y') }}"
                               value="{{ old('tahun_terbit', $buku->tahun_terbit) }}">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Kategori <span style="color:#8A4A3C;">*</span></label>
                        <select name="category_id" class="form-control" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}"
                                    {{ old('category_id', $buku->category_id) == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->nama_kategori }} {{-- ✅ Fix: nama → nama_kategori --}}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div style="color:#8A4A3C; font-size:12px; margin-top:4px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Stok Tersedia <span style="color:#8A4A3C;">*</span></label>
                        <input type="number" name="stok" class="form-control"
                               placeholder="0" min="0"
                               value="{{ old('stok', $buku->stok) }}" required>
                        @error('stok')
                            <div style="color:#8A4A3C; font-size:12px; margin-top:4px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Bahasa</label>
                        <select name="bahasa" class="form-control">
                            <option value="Indonesia" {{ old('bahasa', $buku->bahasa) == 'Indonesia' ? 'selected' : '' }}>Bahasa Indonesia</option>
                            <option value="Inggris"   {{ old('bahasa', $buku->bahasa) == 'Inggris'   ? 'selected' : '' }}>Bahasa Inggris</option>
                            <option value="Lainnya"   {{ old('bahasa', $buku->bahasa) == 'Lainnya'   ? 'selected' : '' }}>Lainnya</option>
                        </select>
                    </div>

                    <div class="form-group" style="grid-column:1/-1;">
                        <label class="form-label">Deskripsi / Sinopsis</label>
                        <textarea name="deskripsi" class="form-control" rows="4"
                                  placeholder="Tulis sinopsis singkat buku…"
                                  style="resize:vertical;">{{ old('deskripsi', $buku->deskripsi) }}</textarea>
                    </div>

                </div>

                <!-- Timestamps info -->
                <div style="
                    display:flex; gap:24px;
                    padding:12px 16px; margin-top:4px;
                    background:var(--cream); border-radius:var(--radius-sm);
                    font-size:12px; color:var(--text-muted);
                ">
                    <span><i class="fas fa-clock" style="margin-right:5px;"></i> Dibuat: {{ $buku->created_at->format('d M Y, H:i') }}</span>
                    <span><i class="fas fa-pen-to-square" style="margin-right:5px;"></i> Diperbarui: {{ $buku->updated_at->format('d M Y, H:i') }}</span>
                </div>

                <div style="display:flex; gap:10px; justify-content:flex-end; padding-top:16px; border-top:1px solid var(--cream-dark); margin-top:16px;">
                    <a href="{{ route('admin.buku.index') }}" class="btn btn-outline">
                        <i class="fas fa-arrow-left"></i> Batal
                    </a>
                    <a href="{{ route('admin.buku.show', $buku->id) }}" class="btn btn-outline">
                        <i class="fas fa-eye"></i> Lihat Detail
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-floppy-disk"></i> Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>
    </div>

    <!-- Side Panel -->
    <div style="display:flex; flex-direction:column; gap:16px;">

        <!-- Cover Upload -->
        <div class="card">
            <div class="card-header" style="padding-bottom:12px;">
                <div class="card-title">Cover Buku</div>
            </div>
            <div class="card-body" style="text-align:center;">
                <div id="coverPreview" style="
                    width:120px; height:160px; border-radius:8px;
                    background:linear-gradient(160deg, var(--brown-light), var(--brown-dark));
                    margin:0 auto 16px;
                    display:flex; align-items:center; justify-content:center;
                    font-size:32px; color:rgba(255,255,255,.4);
                    box-shadow:4px 4px 16px rgba(61,37,16,.2);
                    overflow:hidden;
                ">
                    @if($buku->cover)
                        <img src="{{ asset('storage/' . $buku->cover) }}"
                             style="width:100%; height:100%; object-fit:cover;">
                    @else
                        <i class="fas fa-image"></i>
                    @endif
                </div>

                <label style="cursor:pointer;">
                    <input type="file" name="cover" accept="image/*" style="display:none;"
                           form="editForm" onchange="previewCover(this)">
                    <span class="btn btn-outline btn-sm" style="display:inline-flex;">
                        <i class="fas fa-upload"></i>
                        {{ $buku->cover ? 'Ganti Cover' : 'Upload Cover' }}
                    </span>
                </label>

                @if($buku->cover)
                <div style="margin-top:8px;">
                    <label style="cursor:pointer;">
                        <input type="checkbox" name="hapus_cover" value="1" style="display:none;"
                               form="editForm" onchange="toggleHapusCover(this)">
                        <span id="hapusCoverBtn" class="btn btn-danger btn-sm" style="display:inline-flex;">
                            <i class="fas fa-trash"></i> Hapus Cover
                        </span>
                    </label>
                </div>
                @endif

                <div style="font-size:11px; color:var(--text-muted); margin-top:8px;">JPG, PNG maks 2MB</div>
            </div>
        </div>

        <!-- Danger Zone -->
        <div style="
            background:rgba(138,74,60,.05);
            border:1px solid rgba(138,74,60,.2);
            border-radius:var(--radius-sm);
            padding:18px;
        ">
            <div style="display:flex; align-items:center; gap:8px; margin-bottom:12px;">
                <i class="fas fa-triangle-exclamation" style="color:#8A4A3C; font-size:14px;"></i>
                <span style="font-size:13px; font-weight:600; color:#8A4A3C;">Zona Berbahaya</span>
            </div>
            <p style="font-size:12px; color:var(--text-soft); margin-bottom:12px; line-height:1.6;">
                Menghapus buku akan menghilangkan semua data terkait secara permanen.
            </p>
            <button onclick="document.getElementById('deleteBookModal').classList.add('open')"
                    class="btn btn-danger btn-sm" style="width:100%; justify-content:center;">
                <i class="fas fa-trash"></i> Hapus Buku Ini
            </button>
        </div>

    </div>

</div>

<!-- Delete Confirm Modal -->
<div class="modal-overlay" id="deleteBookModal">
    <div class="modal-box" style="max-width:400px;">
        <div class="modal-header">
            <div class="modal-title">Hapus Buku</div>
            <button class="modal-close"
                    onclick="document.getElementById('deleteBookModal').classList.remove('open')">
                <i class="fas fa-xmark"></i>
            </button>
        </div>
        <div class="modal-body" style="text-align:center; padding:32px 24px;">
            <div style="font-size:48px; margin-bottom:16px;">🗑️</div>
            <div style="font-size:15px; font-weight:600; color:var(--text-dark); margin-bottom:8px;">
                Hapus "{{ $buku->judul }}"?
            </div>
            <div style="font-size:13px; color:var(--text-muted);">
                Data buku dan riwayat peminjaman terkait akan hilang selamanya.
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-outline"
                    onclick="document.getElementById('deleteBookModal').classList.remove('open')">
                Batal
            </button>
            <form action="{{ route('admin.buku.destroy', $buku->id) }}" method="POST" style="display:inline;">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger" style="background:rgba(138,74,60,.85); color:white;">
                    <i class="fas fa-trash"></i> Ya, Hapus
                </button>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function previewCover(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('coverPreview').innerHTML =
                `<img src="${e.target.result}" style="width:100%;height:100%;object-fit:cover;">`;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function toggleHapusCover(checkbox) {
    const btn = document.getElementById('hapusCoverBtn');
    if (checkbox.checked) {
        btn.style.background = 'rgba(138,74,60,.8)';
        btn.style.color = 'white';
        btn.innerHTML = '<i class="fas fa-check"></i> Cover akan dihapus';
    } else {
        btn.style.background = '';
        btn.style.color = '';
        btn.innerHTML = '<i class="fas fa-trash"></i> Hapus Cover';
    }
}
</script>
@endpush