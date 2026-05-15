<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Menampilkan daftar semua pengguna
     * Pastikan folder view-nya adalah: resources/views/admin/users/index.blade.php
     */
    public function index()
    {
        $users = User::all();
        // PERBAIKAN: Ganti 'user' menjadi 'users' (jamak) sesuai nama folder
        return view('admin.users.index', compact('users'));
    }

    /**
     * Menampilkan form untuk tambah user baru
     */
    public function create()
    {
        // PERBAIKAN: Ganti 'user' menjadi 'users'
        return view('admin.users.create');
    }

    /**
     * Menyimpan user baru ke database
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|string|min:6',
            'role' => 'required',
            'status' => 'required',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => $request->status,
        ]);

        return redirect()->route('user.index')->with('success', 'User baru berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk edit data user
     */
    public function edit($id)
    {
        // Mencari user berdasarkan primary key (id_user)
        $user = User::findOrFail($id);
        // PERBAIKAN: Ganti 'user' menjadi 'users'
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Menyimpan perubahan data user ke database
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            // Pastikan unique check mengabaikan ID user yang sedang diupdate
            'username' => 'required|string|max:255|unique:users,username,' . $id . ',id_user',
            'role' => 'required',
            'status' => 'required',
        ]);

        $user->name = $request->name;
        $user->username = $request->username;
        $user->role = $request->role;
        $user->status = $request->status;

        // Jika input password diisi, baru kita enkripsi dan ganti
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('user.index')->with('success', 'Data Pengguna berhasil diperbarui!');
    }

    /**
     * Menghapus user
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Proteksi: Admin tidak bisa menghapus akunnya sendiri yang sedang login
        if (auth()->user()->id_user == $id) {
            return back()->with('error', 'Anda tidak bisa menghapus akun sendiri!');
        }

        $user->delete();
        return redirect()->route('user.index')->with('success', 'User berhasil dihapus!');
    }
}
