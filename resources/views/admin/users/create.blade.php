@extends('layouts.admin')

@section('title', 'Tambah Pengguna')
@section('page-title', 'Tambah Pengguna')
@section('page-sub', 'Buat akun user baru untuk sistem perpustakaan')

@section('content')

<div style="display:grid; grid-template-columns: 1fr 300px; gap:24px;" class="fade-up">

    <!-- Main Form -->
    <div class="card">
        <div class="card-header">
            <div class="card-title">Informasi Pengguna</div>
            <div style="display:flex; align-items:center; gap:6px; font-size:12px; color:var(--text-muted);">
                <a href="{{ route('admin.users.index') }}" style="color:var(--text-muted); text-decoration:none;">Kelola Pengguna</a>
                <i class="fas fa-chevron-right" style="font-size:9px;"></i>
                <span style="color:var(--brown); font-weight:500;">Tambah</span>
            </div>
        </div>
        <div class="card-body">

            @if(session('success'))
                <div style="
                    padding:12px 16px; margin-bottom:16px;
                    background:rgba(92,138,92,.1); border:1px solid rgba(92,138,92,.3);
                    border-radius:var(--radius-sm); color:#5C8A5C; font-size:13px;
                ">
                    <i class="fas fa-circle-check" style="margin-right:6px;"></i>
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">

                    <!-- Nama -->
                    <div class="form-group" style="grid-column:1/-1;">
                        <label class="form-label">Nama Lengkap <span style="color:#8A4A3C;">*</span></label>
                        <input type="text" name="name" class="form-control"
                               placeholder="Masukkan nama lengkap…"
                               value="{{ old('name') }}" required>
                        @error('name')
                            <div style="color:#8A4A3C; font-size:12px; margin-top:4px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- NISN -->
                    <div class="form-group">
                        <label class="form-label">NISN <span style="color:#8A4A3C;">*</span></label>
                        <input type="text" name="nisn" class="form-control"
                               placeholder="Nomor Induk Siswa Nasional"
                               value="{{ old('nisn') }}" required>
                        @error('nisn')
                            <div style="color:#8A4A3C; font-size:12px; margin-top:4px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label class="form-label">Email <span style="color:#8A4A3C;">*</span></label>
                        <input type="email" name="email" class="form-control"
                               placeholder="contoh@email.com"
                               value="{{ old('email') }}" required>
                        @error('email')
                            <div style="color:#8A4A3C; font-size:12px; margin-top:4px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Kelas -->
                    <div class="form-group">
                        <label class="form-label">Kelas <span style="color:#8A4A3C;">*</span></label>
                        <input type="text" name="kelas" class="form-control"
                               placeholder="Contoh: XII"
                               value="{{ old('kelas') }}" required>
                        @error('kelas')
                            <div style="color:#8A4A3C; font-size:12px; margin-top:4px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Jurusan -->
                    <div class="form-group">
                        <label class="form-label">Jurusan <span style="color:#8A4A3C;">*</span></label>
                        <input type="text" name="jurusan" class="form-control"
                               placeholder="Contoh: Rekayasa Perangkat Lunak"
                               value="{{ old('jurusan') }}" required>
                        @error('jurusan')
                            <div style="color:#8A4A3C; font-size:12px; margin-top:4px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label class="form-label">Password <span style="color:#8A4A3C;">*</span></label>
                        <input type="password" name="password" class="form-control"
                               placeholder="Minimal 8 karakter" required>
                        @error('password')
                            <div style="color:#8A4A3C; font-size:12px; margin-top:4px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Konfirmasi Password -->
                    <div class="form-group">
                        <label class="form-label">Konfirmasi Password <span style="color:#8A4A3C;">*</span></label>
                        <input type="password" name="password_confirmation" class="form-control"
                               placeholder="Ulangi password" required>
                    </div>

                </div>

                <div style="display:flex; gap:10px; justify-content:flex-end; padding-top:16px; border-top:1px solid var(--cream-dark); margin-top:8px;">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline">
                        <i class="fas fa-arrow-left"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-user-plus"></i> Buat Akun
                    </button>
                </div>

            </form>
        </div>
    </div>

    <!-- Side Panel -->
    <div style="display:flex; flex-direction:column; gap:16px;">

        <!-- Info -->
        <div class="card">
            <div class="card-header" style="padding-bottom:12px;">
                <div class="card-title">Info Akun</div>
            </div>
            <div class="card-body">
                <div style="display:flex; flex-direction:column; gap:12px;">
                    <div style="display:flex; align-items:center; gap:12px;">
                        <div style="
                            width:40px; height:40px; border-radius:50%;
                            background:linear-gradient(135deg, var(--brown-light), var(--brown-dark));
                            display:flex; align-items:center; justify-content:center;
                            color:white; font-size:16px; flex-shrink:0;
                        "><i class="fas fa-user"></i></div>
                        <div>
                            <div style="font-size:13px; font-weight:600; color:var(--text-dark);">Role: Member</div>
                            <div style="font-size:11px; color:var(--text-muted);">Akun akan dibuat sebagai user biasa</div>
                        </div>
                    </div>
                    <div style="height:1px; background:var(--cream-dark);"></div>
                    <div style="font-size:12px; color:var(--text-soft); line-height:1.8;">
                        <div><i class="fas fa-circle-check" style="color:#5C8A5C; margin-right:6px;"></i>Dapat meminjam buku</div>
                        <div><i class="fas fa-circle-check" style="color:#5C8A5C; margin-right:6px;"></i>Dapat melihat koleksi</div>
                        <div><i class="fas fa-circle-xmark" style="color:#8A4A3C; margin-right:6px;"></i>Tidak bisa akses admin</div>
                    </div>
                </div>
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
                <li>📌 NISN harus unik per siswa</li>
                <li>📌 Email digunakan untuk login</li>
                <li>📌 Password minimal 8 karakter</li>
                <li>📌 Kelas contoh: X, XI, XII</li>
                <li>📌 Jurusan sesuai program studi</li>
            </ul>
        </div>

    </div>

</div>

@endsection