<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class PendudukSeeder extends Seeder
{
    public function run()
    {
        // 1. Cek User
        $user = DB::table('users')->first();

        if (!$user) {
            DB::table('users')->insert([
                'username'   => 'admin_desa',
                'password'   => Hash::make('password123'),
                'role'       => 'admin',
                'status'     => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $user = DB::table('users')->first();
        }

        $id_pasti_valid = $user->id_user;

        // 2. Eksekusi 50 data penduduk
        $faker = Faker::create('id_ID');

        for ($i = 1; $i <= 50; $i++) {
            DB::table('penduduk')->insert([
                'nik'               => $faker->nik(),
                'nama'              => substr($faker->name(), 0, 100),
                'tempat_lahir'      => substr($faker->city(), 0, 100),
                'tgl_lahir'         => $faker->date('Y-m-d', '2000-01-01'),
                'jenis_kelamin'     => $faker->randomElement(['L', 'P']),

                // TAMBAHKAN KOLOM INI AGAR TIDAK KOSONG
                'agama'             => $faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Khonghucu']),
                'pekerjaan'         => substr($faker->jobTitle(), 0, 100),
                'status_perkawinan' => $faker->randomElement(['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati']),

                'alamat'            => $faker->address(),
                'id_user'           => $id_pasti_valid,
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);
        }
    }
}
