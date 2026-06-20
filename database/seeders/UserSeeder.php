<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            'name'       => 'Administrator',
            'username'   => 'admin',
            'password'   => bcrypt('admin123'),
            'role'       => 'admin',
            'status'     => 'aktif',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insert([
            'name'       => 'Kepala Desa',
            'username'   => 'kepdes',
            'password'   => bcrypt('kepdes123'),
            'role'       => 'kepdes',
            'status'     => 'aktif',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
