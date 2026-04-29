@extends('layouts.admin')
@section('title', 'Tambah Buku')
@section('page-title', 'Tambah Buku')
@section('page-sub', 'Tambahkan buku baru ke koleksi perpustakaan')
@section('content')
<div style="display:grid; grid-template-columns: 1fr 300px; gap:24px;" class="fade-up">

<!-- Main Form -->
<div class="card">
    <div class="card-header">
        <div class="card-title">Informasi Buku</div>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.buku.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">

                <div class="form-group" style="grid-column:1/-1;">
                    <label class="form-label">Judul Buku <span style="color:#8A4A3C;">*</span></label>
                    <input type="text" name="judul" class="form-control"
                           placeholder="Masukkan judul buku…"
                           value="{{ old('judul') }}" required>
                    @error('judul')
                        <div style="color:#8A4A3C; font-size:12px; margin-top:4px;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Penulis <span style="color:#8A4A3C;">*</span></label>
                    <input type="text" name="penulis" class="form-control"
                           placeholder="Nama penulis"
                           value="{{ old('penulis') }}" required>
                    @error('penulis')
                        <div style="color:#8A4A3C; font-size:12px; margin-top:4px;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Penerbit</label>
                    <input type="text" name="penerbit" class="form-control"
                           placeholder="Nama penerbit"
                           value="{{ old('penerbit') }}">
                </div>

                <div class="form-group">
                    <label class="form-label">ISBN</label>
                    <input type="text" name="isbn" class="form-control"
                           placeholder="978-xxx-xxx-xxx"
                           value="{{ old('isbn') }}">
                    @error('isbn')
                        <div style="color:#8A4A3C; font-size:12px; margin-top:4px;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Tahun Terbit</label>
                    <input type="number" name="tahun_terbit" class="form-control"
                           placeholder="{{ date('Y') }}"
                           min="1900" max="{{ date('Y') }}"
                           value="{{ old('tahun_terbit') }}">
                </div>

                <div class="form-group">
                    <label class="form-label">Kategori <span style="color:#8A4A3C;">*</span></label>
                    <select name="category_id" class="form-control" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->nama_kategori }} {{-- ✅ Fix --}}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div style="color:#8A4A3C; font-size:12px; margin-top:4px;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Stok <span style="color:#8A4A3C;">*</span></label>
                    <input type="number" name="stok" class="form-control"
                           placeholder="0" min="0"
                           value="{{ old('stok', 1) }}" required>
                    @error('stok')
                        <div style="color:#8A4A3C; font-size:12px; margin-top:4px;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Bahasa</label>
                    <select name="bahasa" class="form-control">
                        <option value="Indonesia" {{ old('bahasa') == 'Indonesia' ? 'selected' : '' }}>Bahasa Indonesia</option>
                        <option value="Inggris"   {{ old('bahasa') == 'Inggris'   ? 'selected' : '' }}>Bahasa Inggris</option>
                        <option value="Lainnya"   {{ old('bahasa') == 'Lainnya'   ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>

                <div class="form-group" style="grid-column:1/-1;">
                    <label class="form-label">Deskripsi / Sinopsis</label>
                    <textarea name="deskripsi" class="form-control" rows="4"
                              placeholder="Tulis sinopsis singkat buku…"
                              style="resize:vertical;">{{ old('deskripsi') }}</textarea>
                </div>

            </div>

            <div style="display:flex; gap:10px; justify-content:flex-end; padding-top:8px; border-top:1px solid var(--cream-dark); margin-top:8px;">
                <a href="{{ route('admin.buku.index') }}" class="btn btn-outline">
                    <i class="fas fa-arrow-left"></i> Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Buku
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
                <i class="fas fa-image"></i>
            </div>
            <label style="cursor:pointer;">
                <input type="file" name="cover" accept="image/*" style="display:none;"
                       onchange="previewCover(this)">
                <span class="btn btn-outline btn-sm" style="display:inline-flex;">
                    <i class="fas fa-upload"></i> Upload Cover
                </span>
            </label>
            <div style="font-size:11px; color:var(--text-muted); margin-top:8px;">JPG, PNG maks 2MB</div>
        </div>
    </div>

    <!-- Tips -->
    <div style="
        background:linear-gradient(135deg, rgba(201,147,58,.08), rgba(139,94,60,.05));
        border:1px solid rgba(201,147,58,.2);
        border-radius:var(--radius-sm);
        padding:18px;
    ">
        <div style="display:flex; align-items:center; gap:8px; margin-bottom:12px;">
            <i class="fas fa-lightbulb" style="color:var(--gold); font-size:15px;"></i>
            <span style="font-size:13px; font-weight:600; color:var(--brown-dark);">Tips Pengisian</span>
        </div>
        <ul style="list-style:none; font-size:12px; color:var(--text-soft); line-height:2.2;">
            <li>📌 ISBN harus unik dan valid</li>
            <li>📌 Stok = jumlah buku fisik tersedia</li>
            <li>📌 Pastikan kategori sudah dibuat dulu</li>
            <li>📌 Deskripsi memudahkan pencarian member</li>
            <li>📌 Cover optimal: rasio 3:4 (misal 300×400px)</li>
        </ul>
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
</script>
@endpush