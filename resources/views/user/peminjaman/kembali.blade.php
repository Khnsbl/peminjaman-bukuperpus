@extends('layouts.user')

@section('content')
<div class="p-6 max-w-lg mx-auto">
    <a href="{{ route('user.peminjaman.index') }}"
       class="text-sm text-blue-500 hover:underline mb-4 inline-block">
        ← Kembali
    </a>

    <div class="bg-white rounded-lg shadow p-6">
        <h5 class="text-lg font-semibold text-gray-800 mb-4">📬 Form Pengembalian Buku</h5>

        <!-- Info Buku -->
        <div class="flex gap-4 mb-5 p-4 bg-gray-50 rounded-lg">
            @if($peminjaman->buku->cover)
                <img src="{{ Storage::url($peminjaman->buku->cover) }}" class="w-14 h-20 object-cover rounded">
            @else
                <div class="w-14 h-20 bg-gray-200 rounded flex items-center justify-center text-2xl">📖</div>
            @endif
            <div>
                <div class="font-semibold text-gray-800">{{ $peminjaman->buku->judul }}</div>
                <div class="text-sm text-gray-500">{{ $peminjaman->buku->penulis }}</div>
                <div class="text-xs text-gray-400 mt-1">
                    Batas kembali: <span class="{{ $terlambat ? 'text-red-600 font-semibold' : 'text-gray-600' }}">
                        {{ $peminjaman->tanggal_kembali->format('d M Y') }}
                    </span>
                </div>
            </div>
        </div>

        @if($terlambat)
            <div class="bg-red-50 border border-red-200 rounded-lg p-3 mb-4 text-sm text-red-700">
                ⚠️ Kamu sudah melewati batas pengembalian. Harap isi alasan keterlambatan.
                Admin akan menentukan apakah ada denda atau tidak.
            </div>
        @endif

        <form action="{{ route('user.peminjaman.ajukanKembali', $peminjaman) }}" method="POST">
            @csrf

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Dikembalikan</label>
                    <input type="date" name="tanggal_dikembalikan"
                           value="{{ old('tanggal_dikembalikan', date('Y-m-d')) }}"
                           max="{{ date('Y-m-d') }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 @error('tanggal_dikembalikan') border-red-400 @enderror"
                           required>
                    @error('tanggal_dikembalikan')
                        <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>

                @if($terlambat)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Alasan Keterlambatan <span class="text-red-500">*</span>
                    </label>
                    <textarea name="alasan_terlambat" rows="4"
                              class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 @error('alasan_terlambat') border-red-400 @enderror"
                              placeholder="Jelaskan alasan keterlambatan pengembalian buku...">{{ old('alasan_terlambat') }}</textarea>
                    @error('alasan_terlambat')
                        <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>
                @endif
            </div>

            <div class="flex gap-3 mt-6">
                <button type="submit"
                        class="bg-blue-600 text-white text-sm px-6 py-2 rounded-lg hover:bg-blue-700">
                    Kirim Pengajuan
                </button>
                <a href="{{ route('user.peminjaman.index') }}"
                   class="bg-gray-100 text-gray-600 text-sm px-6 py-2 rounded-lg hover:bg-gray-200">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection