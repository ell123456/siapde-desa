<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Nonaktifkan foreign key check dulu
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // User Admin
        User::create([
            'name'     => 'Administrator',
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
            'status'   => 'aktif',
        ]);

        // User Kepala Desa
        User::create([
            'name'     => 'Kepala Desa',
            'username' => 'kepdes',
            'password' => Hash::make('kepdes123'),
            'role'     => 'kepdes',
            'status'   => 'aktif',
        ]);
    }
}
