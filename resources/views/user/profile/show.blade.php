@extends('layouts.user')

@section('content')
<div class="p-6 max-w-2xl mx-auto">
    <h5 class="text-xl font-semibold text-gray-800 mb-4">👤 Profil Saya</h5>

    <div class="bg-white rounded-lg shadow p-6">

        <!-- Foto & Nama -->
        <div class="flex items-center gap-5 mb-6 pb-6 border-b">
            @if($user->foto)
                <img src="{{ Storage::url($user->foto) }}"
                     class="w-20 h-20 rounded-full object-cover border-2 border-gray-200">
            @else
                <div class="w-20 h-20 rounded-full bg-blue-100 flex items-center justify-center text-3xl font-bold text-blue-600">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
            @endif
            <div>
                <div class="text-lg font-semibold text-gray-800">{{ $user->name }}</div>
                <div class="text-sm text-gray-500">{{ $user->email }}</div>
                <span class="text-xs bg-blue-100 text-blue-600 px-2 py-0.5 rounded-full mt-1 inline-block">
                    {{ ucfirst($user->role) }}
                </span>
            </div>
        </div>

        <!-- Detail Info -->
        <div class="grid grid-cols-2 gap-4 text-sm mb-6">
            <div>
                <span class="text-gray-500">NISN</span>
                <div class="font-medium text-gray-800 mt-0.5">{{ $user->nisn ?? '-' }}</div>
            </div>
            <div>
                <span class="text-gray-500">Kelas</span>
                <div class="font-medium text-gray-800 mt-0.5">{{ $user->kelas ?? '-' }}</div>
            </div>
            <div>
                <span class="text-gray-500">Jurusan</span>
                <div class="font-medium text-gray-800 mt-0.5">{{ $user->jurusan ?? '-' }}</div>
            </div>
            <div>
                <span class="text-gray-500">Email</span>
                <div class="font-medium text-gray-800 mt-0.5">{{ $user->email }}</div>
            </div>
        </div>

        <div class="flex gap-3">
            <a href="{{ route('user.profile.edit') }}"
               class="bg-blue-600 text-white text-sm px-5 py-2 rounded-lg hover:bg-blue-700">
                ✏️ Edit Profil
            </a>
        </div>
    </div>
</div>
@endsection