@extends('layouts.user')

@section('content')
<div class="p-6 max-w-2xl mx-auto space-y-6">

    <a href="{{ route('user.profile.show') }}"
       class="text-sm text-blue-500 hover:underline inline-block">
        ← Kembali ke Profil
    </a>

    <!-- Form Edit Profil -->
    <div class="bg-white rounded-lg shadow p-6">
        <h6 class="font-semibold text-gray-800 mb-4">✏️ Edit Profil</h6>

        <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="space-y-4">

                <!-- Foto Profil -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Foto Profil</label>
                    @if($user->foto)
                        <div class="mb-2">
                            <img src="{{ Storage::url($user->foto) }}"
                                 class="w-16 h-16 rounded-full object-cover border">
                            <div class="text-xs text-gray-400 mt-1">Upload baru untuk mengganti.</div>
                        </div>
                    @endif
                    <input type="file" name="foto" accept="image/*"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 @error('foto') border-red-400 @enderror">
                    <div class="text-xs text-gray-400 mt-1">Format: JPG, PNG, WEBP. Maks 2MB.</div>
                    @error('foto')
                        <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Nama -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 @error('name') border-red-400 @enderror"
                           required>
                    @error('name')
                        <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 @error('email') border-red-400 @enderror"
                           required>
                    @error('email')
                        <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Kelas -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                    <input type="text" name="kelas" value="{{ old('kelas', $user->kelas) }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
                           placeholder="Contoh: XII">
                </div>

                <!-- Jurusan -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jurusan</label>
                    <input type="text" name="jurusan" value="{{ old('jurusan', $user->jurusan) }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
                           placeholder="Contoh: RPL">
                </div>

            </div>

            <div class="flex gap-3 mt-5">
                <button type="submit"
                        class="bg-blue-600 text-white text-sm px-6 py-2 rounded-lg hover:bg-blue-700">
                    Simpan Perubahan
                </button>
                <a href="{{ route('user.profile.show') }}"
                   class="bg-gray-100 text-gray-600 text-sm px-6 py-2 rounded-lg hover:bg-gray-200">
                    Batal
                </a>
            </div>
        </form>
    </div>

    <!-- Form Ganti Password -->
    <div class="bg-white rounded-lg shadow p-6">
        <h6 class="font-semibold text-gray-800 mb-4">🔒 Ganti Password</h6>

        <form action="{{ route('user.profile.password') }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password Lama</label>
                    <input type="password" name="password_lama"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 @error('password_lama') border-red-400 @enderror"
                           required>
                    @error('password_lama')
                        <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                    <input type="password" name="password"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 @error('password') border-red-400 @enderror"
                           required>
                    @error('password')
                        <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
                           required>
                </div>
            </div>

            <div class="mt-5">
                <button type="submit"
                        class="bg-red-600 text-white text-sm px-6 py-2 rounded-lg hover:bg-red-700">
                    Ubah Password
                </button>
            </div>
        </form>
    </div>

</div>
@endsection