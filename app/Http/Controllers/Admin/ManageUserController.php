<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ManageUserController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'user')
            ->withCount('peminjaman')
            ->latest()
            ->paginate(10);

        $totalUsers = User::where('role', 'user')->count();
        $activeUsers = $totalUsers; // ✅ Tidak ada kolom is_active, anggap semua aktif
        $admins     = User::where('role', 'admin')->count();

        return view('admin.users.index', compact('users', 'totalUsers', 'activeUsers', 'admins'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'nisn'     => 'required|string|unique:users,nisn',
            'kelas'    => 'required|string|max:50',
            'jurusan'  => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        User::create([
            'name'     => $request->name,
            'nisn'     => $request->nisn,
            'kelas'    => $request->kelas,
            'jurusan'  => $request->jurusan,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'user',
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Akun user berhasil dibuat!');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'nisn'     => 'required|string|unique:users,nisn,' . $user->id,
            'kelas'    => 'required|string|max:50',
            'jurusan'  => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
        ]);

        $data = [
            'name'    => $request->name,
            'nisn'    => $request->nisn,
            'kelas'   => $request->kelas,
            'jurusan' => $request->jurusan,
            'email'   => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'Data user berhasil diupdate!');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Tidak bisa menghapus akun sendiri!');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dihapus!');
    }
}