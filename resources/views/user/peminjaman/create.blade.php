@extends('layouts.user')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=DM+Sans:wght@300;400;500&display=swap');

    .pinjam-wrapper {
        font-family: 'DM Sans', sans-serif;
        min-height: 100vh;
        background: #f5f0eb;
        padding: 2rem 1rem;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.8rem;
        color: #8b6f47;
        text-decoration: none;
        margin-bottom: 1.5rem;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        font-weight: 500;
        transition: gap 0.2s;
    }
    .back-link:hover { gap: 10px; color: #5c3d1e; }

    .card {
        max-width: 520px;
        margin: 0 auto;
        background: #fff;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 8px 40px rgba(92,61,30,0.10);
    }

    /* Hero banner buku */
    .card-hero {
        position: relative;
        background: linear-gradient(135deg, #3b1f0a 0%, #7a4520 60%, #c47b3a 100%);
        padding: 2rem 2rem 1.5rem;
        display: flex;
        gap: 1.25rem;
        align-items: flex-end;
    }
    .card-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        opacity: 0.5;
        pointer-events: none;
    }

    .book-cover {
        position: relative;
        flex-shrink: 0;
        width: 90px;
        height: 130px;
        border-radius: 6px;
        overflow: hidden;
        box-shadow: -4px 4px 20px rgba(0,0,0,0.4), 4px 0 0 #c47b3a inset;
        transform: rotate(-2deg) translateY(10px);
        transition: transform 0.3s;
    }
    .book-cover:hover { transform: rotate(0deg) translateY(5px); }
    .book-cover img { width: 100%; height: 100%; object-fit: cover; }
    .book-cover-placeholder {
        width: 100%;
        height: 100%;
        background: linear-gradient(160deg, #5c3d1e, #8b6f47);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
    }

    .book-meta {
        color: #fff;
        padding-bottom: 12px;
    }
    .book-meta .label {
        font-size: 0.65rem;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: rgba(255,255,255,0.55);
        margin-bottom: 4px;
    }
    .book-meta .judul {
        font-family: 'Playfair Display', serif;
        font-size: 1.2rem;
        font-weight: 700;
        line-height: 1.2;
        margin-bottom: 4px;
    }
    .book-meta .penulis {
        font-size: 0.8rem;
        color: rgba(255,255,255,0.75);
        font-weight: 300;
    }
    .stok-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        margin-top: 8px;
        background: rgba(255,255,255,0.15);
        backdrop-filter: blur(6px);
        border: 1px solid rgba(255,255,255,0.2);
        border-radius: 20px;
        padding: 3px 10px;
        font-size: 0.72rem;
        color: #fff;
    }
    .stok-dot {
        width: 6px; height: 6px;
        background: #4ade80;
        border-radius: 50%;
        animation: pulse 1.5s infinite;
    }
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.4; }
    }

    /* Body form */
    .card-body {
        padding: 1.75rem 2rem 2rem;
    }
    .form-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.1rem;
        color: #3b1f0a;
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .form-title::after {
        content: '';
        flex: 1;
        height: 1px;
        background: linear-gradient(to right, #e0d4c3, transparent);
    }

    .form-group {
        margin-bottom: 1.1rem;
    }
    .form-group label {
        display: block;
        font-size: 0.75rem;
        font-weight: 500;
        color: #6b4c2a;
        margin-bottom: 6px;
        letter-spacing: 0.06em;
        text-transform: uppercase;
    }
    .form-group input[type="date"] {
        width: 100%;
        border: 1.5px solid #e0d4c3;
        border-radius: 10px;
        padding: 10px 14px;
        font-size: 0.9rem;
        font-family: 'DM Sans', sans-serif;
        color: #3b1f0a;
        background: #faf7f4;
        transition: border-color 0.2s, box-shadow 0.2s;
        outline: none;
        box-sizing: border-box;
    }
    .form-group input[type="date"]:focus {
        border-color: #8b6f47;
        box-shadow: 0 0 0 3px rgba(139,111,71,0.12);
        background: #fff;
    }
    .form-group input.is-invalid {
        border-color: #e57373;
    }
    .error-msg {
        font-size: 0.72rem;
        color: #c0392b;
        margin-top: 4px;
    }

    .denda-notice {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        background: linear-gradient(135deg, #fffbeb, #fef3c7);
        border: 1px solid #fcd34d;
        border-radius: 12px;
        padding: 12px 14px;
        margin: 1.25rem 0;
    }
    .denda-notice .icon { font-size: 1rem; flex-shrink: 0; margin-top: 1px; }
    .denda-notice p {
        font-size: 0.78rem;
        color: #78350f;
        margin: 0;
        line-height: 1.5;
    }
    .denda-notice strong { color: #92400e; }

    .action-row {
        display: flex;
        gap: 10px;
        margin-top: 1.5rem;
    }
    .btn-submit {
        flex: 1;
        background: linear-gradient(135deg, #5c3d1e, #8b6f47);
        color: #fff;
        border: none;
        border-radius: 12px;
        padding: 12px 20px;
        font-family: 'DM Sans', sans-serif;
        font-size: 0.88rem;
        font-weight: 500;
        cursor: pointer;
        letter-spacing: 0.03em;
        transition: all 0.2s;
        box-shadow: 0 4px 14px rgba(92,61,30,0.3);
    }
    .btn-submit:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(92,61,30,0.4);
    }
    .btn-submit:active { transform: translateY(0); }

    .btn-cancel {
        background: #f5f0eb;
        color: #8b6f47;
        border: 1.5px solid #e0d4c3;
        border-radius: 12px;
        padding: 12px 20px;
        font-family: 'DM Sans', sans-serif;
        font-size: 0.88rem;
        font-weight: 500;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }
    .btn-cancel:hover {
        background: #ebe4db;
        color: #5c3d1e;
    }
</style>

<div class="pinjam-wrapper">
    <div style="max-width:520px; margin:0 auto;">
        <a href="{{ route('user.buku.show', $buku) }}" class="back-link">
            ← Kembali ke Detail Buku
        </a>

        <div class="card">
            <!-- Hero -->
            <div class="card-hero">
                <div class="book-cover">
                    @if($buku->cover)
                        <img src="{{ Storage::url($buku->cover) }}" alt="{{ $buku->judul }}">
                    @else
                        <div class="book-cover-placeholder">📖</div>
                    @endif
                </div>
                <div class="book-meta">
                    <div class="label">Buku yang dipinjam</div>
                    <div class="judul">{{ $buku->judul }}</div>
                    <div class="penulis">{{ $buku->penulis }}</div>
                    <div class="stok-badge">
                        <span class="stok-dot"></span>
                        {{ $buku->stok }} stok tersedia
                    </div>
                </div>
            </div>

            <!-- Form -->
            <div class="card-body">
                <div class="form-title">
                    📋 Isi Form Peminjaman
                </div>

                <form action="{{ route('user.peminjaman.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="buku_id" value="{{ $buku->id }}">

                    <div class="form-group">
                        <label>Tanggal Pinjam</label>
                        <input type="date" name="tanggal_pinjam"
                               value="{{ old('tanggal_pinjam', date('Y-m-d')) }}"
                               min="{{ date('Y-m-d') }}"
                               class="{{ $errors->has('tanggal_pinjam') ? 'is-invalid' : '' }}">
                        @error('tanggal_pinjam')
                            <div class="error-msg">⚠ {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Tanggal Kembali</label>
                        <input type="date" name="tanggal_kembali"
                               value="{{ old('tanggal_kembali') }}"
                               min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                               class="{{ $errors->has('tanggal_kembali') ? 'is-invalid' : '' }}">
                        @error('tanggal_kembali')
                            <div class="error-msg">⚠ {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="denda-notice">
                        <span class="icon">⚠️</span>
                        <p>Keterlambatan pengembalian dikenakan denda <strong>Rp1.000 per hari</strong>. Pastikan mengembalikan buku tepat waktu.</p>
                    </div>

                    <div class="action-row">
                        <button type="submit" class="btn-submit">
                            ✓ &nbsp;Ajukan Peminjaman
                        </button>
                        <a href="{{ route('user.buku.index') }}" class="btn-cancel">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection