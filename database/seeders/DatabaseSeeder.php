<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Menghapus user admin lama jika ada (opsional agar tidak duplikat)
        User::where('username', 'admin')->delete();

        // Membuat User Admin Baru dengan Password Terenkripsi
        User::create([
            'username' => 'admin',
            'password' => Hash::make('admin123'), // <--- Ini kuncinya!
            'role'     => 'admin',
        ]);
    }
}
