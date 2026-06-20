<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Penduduk;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PendudukDummySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create('id_ID'); // Format data Indonesia

        // 1. Cek isi tabel users
        $user = DB::table('users')->first();
        $userId = null;

        if (!$user) {
            $this->command->warn('UserSeeder kamu ternyata kosong/tidak ngisi data. Membuat user otomatis...');

            // Kita bypass dan buat akun langsung dengan username: admin, password: admin
            try {
                $userId = DB::table('users')->insertGetId([
                    'username'   => 'admin',
                    'password'   => Hash::make('admin'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } catch (\Exception $e) {
                // Antispasi jika database kamu ketat wajib minta kolom name atau email
                try {
                    $userId = DB::table('users')->insertGetId([
                        'username'   => 'admin',
                        'name'       => 'Admin Desa',
                        'email'      => 'admin@desa.com',
                        'password'   => Hash::make('admin'),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                } catch (\Exception $e2) {
                    $this->command->error('Gagal total membuat user otomatis. Sila cek struktur tabel users kamu cuy.');
                    return;
                }
            }
            $this->command->info('SUKSES: Akun login otomatis dibuat -> Username: admin | Password: admin');
        } else {
            // Kalau user sudah ada, ambil ID-nya secara dinamis
            $userId = $user->id_user ?? $user->id ?? 1;
        }

        $this->command->info('Sedang menyuntikkan 400 data penduduk lengkap dummy...');

        $agamaArray = ['ISLAM', 'KRISTEN', 'KATOLIK', 'HINDU', 'BUDDHA', 'KHONGHUCU'];
        $statusKawinArray = ['BELUM KAWIN', 'KAWIN', 'CERAI HIDUP', 'CERAI MATI'];
        $pekerjaanArray = [
            'WIRASWASTA',
            'PETANI / PEKEBUN',
            'DOKTER',
            'MAHASISWA',
            'PELAJAR',
            'PNS',
            'KARYAWAN SWASTA',
            'BURUH HARIAN LEPAS',
            'TUKANG SOL SEPATU',
            'PENSIUNAN',
            'IBU RUMAH TANGGA',
            'PSIKIATER / PSIKOLOG'
        ];

        // Loop mutlak 400 data penduduk lengkap
        for ($i = 1; $i <= 400; $i++) {
            Penduduk::create([
                'nik'               => $faker->unique()->numerify('1201#############'), // 16 digit NIK
                'nama'              => strtoupper($faker->name), // Nama otomatis kapital
                'jenis_kelamin'     => $faker->randomElement(['L', 'P']), // L / P
                'tempat_lahir'      => strtoupper($faker->city), // Kota acak
                'tgl_lahir'         => $faker->date('Y-m-d', '-20 years'), // Tanggal lahir
                'agama'             => $faker->randomElement($agamaArray),
                'pekerjaan'         => $faker->randomElement($pekerjaanArray),
                'alamat'            => strtoupper($faker->streetAddress),
                'status_perkawinan' => $faker->randomElement($statusKawinArray),
                'id_user'           => $userId, // Berelasi dengan aman ke ID User hasil deteksi di atas
            ]);
        }

        $this->command->info('Sukses! 400 data penduduk lengkap berhasil ditambahkan. Tabel surat tetap kosong bersih 0.');
    }
}
