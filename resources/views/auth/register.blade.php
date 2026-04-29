<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - PustakaKu</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --green-dark: #1A2E27;
            --green-main: #2C4A3E;
            --green-soft: #5B8C7A;
            --green-pale: #E8F0ED;
            --green-light: #C5D5D0;
            --cream: #FAFAF7;
            --border: #E8E5DC;
            --text-muted: #6B7280;
            --text-subtle: #9CA3AF;
            --white: #FFFFFF;
            --red: #DC2626;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--cream);
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        /* ─── LEFT PANEL ─── */
        .left-panel {
            background: var(--green-main);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 3rem;
            position: relative;
            overflow: hidden;
        }

        .left-panel::before {
            content: '';
            position: absolute;
            width: 320px; height: 320px;
            border-radius: 50%;
            background: rgba(255,255,255,0.04);
            bottom: -80px; left: -80px;
        }

        .left-panel::after {
            content: '';
            position: absolute;
            width: 180px; height: 180px;
            border-radius: 50%;
            background: rgba(255,255,255,0.04);
            top: 60px; right: -40px;
        }

        .panel-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            position: relative;
            z-index: 1;
        }

        .logo-icon {
            width: 38px; height: 38px;
            background: rgba(255,255,255,0.15);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-text {
            font-family: 'Playfair Display', serif;
            font-size: 22px;
            font-weight: 700;
            color: var(--white);
        }

        .logo-text span { color: #9FCFC1; }

        .panel-middle { position: relative; z-index: 1; }

        .panel-tagline {
            font-family: 'Playfair Display', serif;
            font-size: 42px;
            font-weight: 900;
            color: var(--white);
            line-height: 1.15;
            margin-bottom: 1.2rem;
            letter-spacing: -0.5px;
        }

        .panel-tagline em { font-style: italic; color: #9FCFC1; }

        .panel-desc {
            font-size: 15px;
            color: rgba(255,255,255,0.6);
            line-height: 1.7;
            max-width: 340px;
            margin-bottom: 2rem;
        }

        .benefit-list { display: flex; flex-direction: column; gap: 14px; }

        .benefit-item { display: flex; align-items: center; gap: 12px; }

        .benefit-icon {
            width: 34px; height: 34px;
            border-radius: 8px;
            background: rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .benefit-text { font-size: 14px; color: rgba(255,255,255,0.8); }

        .panel-bottom {
            font-size: 12px;
            color: rgba(255,255,255,0.3);
            position: relative;
            z-index: 1;
        }

        /* ─── RIGHT PANEL ─── */
        .right-panel {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem 2rem;
            overflow-y: auto;
        }

        .form-container { width: 100%; max-width: 420px; }

        .form-header { margin-bottom: 2rem; }

        .form-title {
            font-family: 'Playfair Display', serif;
            font-size: 32px;
            font-weight: 700;
            color: var(--green-dark);
            margin-bottom: 0.4rem;
            letter-spacing: -0.3px;
        }

        .form-subtitle { font-size: 14px; color: var(--text-muted); }

        .form-subtitle a {
            color: var(--green-soft);
            text-decoration: none;
            font-weight: 500;
        }

        .form-subtitle a:hover { text-decoration: underline; }

        /* Error alert */
        .alert-error {
            background: #FEF2F2;
            border: 1px solid #FECACA;
            border-radius: 10px;
            padding: 12px 16px;
            margin-bottom: 1.5rem;
        }

        .alert-error ul { list-style: none; display: flex; flex-direction: column; gap: 4px; }

        .alert-error li {
            font-size: 13px;
            color: var(--red);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .alert-error li::before {
            content: '';
            width: 4px; height: 4px;
            border-radius: 50%;
            background: var(--red);
            flex-shrink: 0;
        }

        /* Form fields */
        .form-group { margin-bottom: 1.1rem; }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: var(--green-dark);
            margin-bottom: 6px;
        }

        .form-input {
            width: 100%;
            padding: 11px 14px;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            color: var(--green-dark);
            background: var(--white);
            transition: all 0.2s;
            outline: none;
            appearance: none;
        }

        .form-input:focus {
            border-color: var(--green-soft);
            box-shadow: 0 0 0 3px rgba(91,140,122,0.12);
        }

        .form-input.is-error { border-color: var(--red); }
        .form-input.is-error:focus { box-shadow: 0 0 0 3px rgba(220,38,38,0.1); }

        .field-error { font-size: 12px; color: var(--red); margin-top: 4px; }

        /* Password wrapper */
        .input-wrapper { position: relative; }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: var(--text-subtle);
            padding: 4px;
            display: flex;
            align-items: center;
            transition: color 0.2s;
        }

        .toggle-password:hover { color: var(--green-soft); }
        .input-wrapper .form-input { padding-right: 42px; }

        /* Password strength */
        .strength-bar { display: flex; gap: 4px; margin-top: 6px; }

        .strength-segment {
            height: 3px;
            flex: 1;
            border-radius: 2px;
            background: var(--border);
            transition: background 0.3s;
        }

        .strength-label { font-size: 11px; color: var(--text-subtle); margin-top: 4px; }

        /* Section label */
        .section-divider {
            font-size: 11px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: var(--text-subtle);
            margin: 1.4rem 0 1rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        /* Submit */
        .btn-submit {
            width: 100%;
            padding: 13px;
            background: var(--green-main);
            color: var(--white);
            border: none;
            border-radius: 10px;
            font-family: 'DM Sans', sans-serif;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 1.5rem;
        }

        .btn-submit:hover { background: var(--green-dark); transform: translateY(-1px); }
        .btn-submit:active { transform: translateY(0); }

        .terms-note {
            text-align: center;
            font-size: 12px;
            color: var(--text-subtle);
            margin-top: 1rem;
            line-height: 1.6;
        }

        .login-cta {
            text-align: center;
            font-size: 14px;
            color: var(--text-muted);
            margin-top: 1.5rem;
        }

        .login-cta a {
            color: var(--green-main);
            font-weight: 500;
            text-decoration: none;
        }

        .login-cta a:hover { text-decoration: underline; }

        /* ─── RESPONSIVE ─── */
        @media (max-width: 768px) {
            body { grid-template-columns: 1fr; }
            .left-panel { display: none; }
            .right-panel { padding: 2rem 1.5rem; }
            .form-row { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

{{-- ─── LEFT PANEL ─── --}}
<div class="left-panel">
    <a href="{{ url('/') }}" class="panel-logo">
        <div class="logo-icon">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                <rect x="3" y="2" width="5" height="16" rx="1" fill="white" opacity="0.9"/>
                <rect x="9" y="2" width="5" height="16" rx="1" fill="white" opacity="0.7"/>
                <rect x="15" y="4" width="3" height="12" rx="1" fill="white" opacity="0.5"/>
            </svg>
        </div>
        <span class="logo-text">Pustaka<span>Ku</span></span>
    </a>

    <div class="panel-middle">
        <h2 class="panel-tagline">
            Bergabung<br>& Mulai<br>
            <em>Membaca!</em>
        </h2>
        <p class="panel-desc">
            Daftar sekarang dan dapatkan akses ke ribuan koleksi buku pilihan secara gratis.
        </p>
        <div class="benefit-list">
            <div class="benefit-item">
                <div class="benefit-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#9FCFC1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 19.5A2.5 2.5 0 016.5 17H20"/><path d="M6.5 2H20V22H6.5A2.5 2.5 0 014 19.5V4.5A2.5 2.5 0 016.5 2Z"/>
                    </svg>
                </div>
                <span class="benefit-text">Akses 5.200+ koleksi buku</span>
            </div>
            <div class="benefit-item">
                <div class="benefit-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#9FCFC1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="9"/><polyline points="12 7 12 12 15 15"/>
                    </svg>
                </div>
                <span class="benefit-text">Notifikasi tenggat otomatis</span>
            </div>
            <div class="benefit-item">
                <div class="benefit-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#9FCFC1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
                    </svg>
                </div>
                <span class="benefit-text">Pantau riwayat peminjaman</span>
            </div>
            <div class="benefit-item">
                <div class="benefit-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#9FCFC1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21V19a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/>
                    </svg>
                </div>
                <span class="benefit-text">Profil anggota lengkap</span>
            </div>
        </div>
    </div>

    <p class="panel-bottom">&copy; {{ date('Y') }} PustakaKu. Semua hak dilindungi.</p>
</div>

{{-- ─── RIGHT PANEL (FORM) ─── --}}
<div class="right-panel">
    <div class="form-container">
        <div class="form-header">
            <h1 class="form-title">Buat Akun</h1>
            <p class="form-subtitle">
                Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
            </p>
        </div>

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            {{-- ── DATA PRIBADI ── --}}
            <div class="section-divider">Data Pribadi</div>

            {{-- Nama Lengkap --}}
            <div class="form-group">
                <label for="name" class="form-label">Nama Lengkap</label>
                <input
                    id="name"
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    class="form-input {{ $errors->has('name') ? 'is-error' : '' }}"
                    placeholder="Nama lengkap Anda"
                    required autofocus autocomplete="name"
                />
                @error('name')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>

            {{-- NISN --}}
            <div class="form-group">
                <label for="nisn" class="form-label">NISN</label>
                <input
                    id="nisn"
                    type="text"
                    name="nisn"
                    value="{{ old('nisn') }}"
                    class="form-input {{ $errors->has('nisn') ? 'is-error' : '' }}"
                    placeholder="Nomor Induk Siswa Nasional"
                    required maxlength="20"
                />
                @error('nisn')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Kelas & Jurusan (side by side) --}}
            <div class="form-row">
                <div class="form-group">
                    <label for="kelas" class="form-label">Kelas</label>
                    <select
                        id="kelas"
                        name="kelas"
                        class="form-input {{ $errors->has('kelas') ? 'is-error' : '' }}"
                        required
                    >
                        <option value="" disabled {{ old('kelas') ? '' : 'selected' }}>Pilih kelas</option>
                        <option value="X"   {{ old('kelas') == 'X'   ? 'selected' : '' }}>X</option>
                        <option value="XI"  {{ old('kelas') == 'XI'  ? 'selected' : '' }}>XI</option>
                        <option value="XII" {{ old('kelas') == 'XII' ? 'selected' : '' }}>XII</option>
                    </select>
                    @error('kelas')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="jurusan" class="form-label">Jurusan</label>
                    <select
                        id="jurusan"
                        name="jurusan"
                        class="form-input {{ $errors->has('jurusan') ? 'is-error' : '' }}"
                        required
                    >
                        <option value="" disabled {{ old('jurusan') ? '' : 'selected' }}>Pilih jurusan</option>
                        <option value="RPL"   {{ old('jurusan') == 'RPL'   ? 'selected' : '' }}>RPL</option>
                        <option value="TKJ"   {{ old('jurusan') == 'TKJ'   ? 'selected' : '' }}>TKJ</option>
                        <option value="MM"    {{ old('jurusan') == 'MM'    ? 'selected' : '' }}>MM</option>
                        <option value="AKL"   {{ old('jurusan') == 'AKL'   ? 'selected' : '' }}>AKL</option>
                        <option value="OTKP"  {{ old('jurusan') == 'OTKP'  ? 'selected' : '' }}>OTKP</option>
                        <option value="BDP"   {{ old('jurusan') == 'BDP'   ? 'selected' : '' }}>BDP</option>
                    </select>
                    @error('jurusan')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- ── DATA AKUN ── --}}
            <div class="section-divider">Data Akun</div>

            {{-- Email --}}
            <div class="form-group">
                <label for="email" class="form-label">Alamat Email</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="form-input {{ $errors->has('email') ? 'is-error' : '' }}"
                    placeholder="contoh@email.com"
                    required autocomplete="username"
                />
                @error('email')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <div class="input-wrapper">
                    <input
                        id="password"
                        type="password"
                        name="password"
                        class="form-input {{ $errors->has('password') ? 'is-error' : '' }}"
                        placeholder="Minimal 8 karakter"
                        required autocomplete="new-password"
                        oninput="checkStrength(this.value)"
                    />
                    <button type="button" class="toggle-password" onclick="togglePass('password','eye1')" aria-label="Tampilkan password">
                        <svg id="eye1" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>
                </div>
                <div class="strength-bar">
                    <div class="strength-segment" id="s1"></div>
                    <div class="strength-segment" id="s2"></div>
                    <div class="strength-segment" id="s3"></div>
                    <div class="strength-segment" id="s4"></div>
                </div>
                <p class="strength-label" id="strength-text"></p>
                @error('password')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Confirm Password --}}
            <div class="form-group">
                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                <div class="input-wrapper">
                    <input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        class="form-input"
                        placeholder="Ulangi password Anda"
                        required autocomplete="new-password"
                    />
                    <button type="button" class="toggle-password" onclick="togglePass('password_confirmation','eye2')" aria-label="Tampilkan konfirmasi password">
                        <svg id="eye2" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn-submit">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/>
                    <line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/>
                </svg>
                Buat Akun Sekarang
            </button>
        </form>

        <p class="terms-note">
            Dengan mendaftar, Anda menyetujui syarat dan ketentuan layanan PustakaKu.
        </p>

        <p class="login-cta">
            Sudah punya akun? <a href="{{ route('login') }}">Masuk sekarang →</a>
        </p>
    </div>
</div>

<script>
    function togglePass(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon  = document.getElementById(iconId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/>';
        } else {
            input.type = 'password';
            icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
        }
    }

    function checkStrength(val) {
        const segs   = ['s1','s2','s3','s4'].map(id => document.getElementById(id));
        const label  = document.getElementById('strength-text');
        const clrs   = ['', '#EF4444', '#F59E0B', '#3B82F6', '#10B981'];
        const labels = ['', 'Lemah', 'Cukup', 'Baik', 'Kuat'];
        let score = 0;
        if (val.length >= 8)           score++;
        if (/[A-Z]/.test(val))         score++;
        if (/[0-9]/.test(val))         score++;
        if (/[^A-Za-z0-9]/.test(val))  score++;
        segs.forEach((s, i) => s.style.background = i < score ? clrs[score] : 'var(--border)');
        label.textContent = val.length ? labels[score] : '';
        label.style.color = clrs[score];
    }
</script>
</body>
</html>