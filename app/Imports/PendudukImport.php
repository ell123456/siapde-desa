<?php

namespace App\Imports;

use App\Models\Penduduk;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow; // KITA GUNAKAN LAGI UTK DETEKSI STRUKTUR JUDUL
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class PendudukImport implements ToModel, WithHeadingRow, WithCustomCsvSettings
{
    /**
     * Kunci setelan CSV agar stabil membaca tanda koma dan tanda kutip dua pembungkus data
     */
    public function getCsvSettings(): array
    {
        return [
            'delimiter'        => ',',
            'enclosure'        => '"',
            'input_encoding'   => 'UTF-8'
        ];
    }

    public function model(array $row)
    {
        // Bersihkan nama judul kolom Excel lo dari spasi atau karakter aneh (anti huruf besar/kecil)
        $cleanRow = [];
        foreach ($row as $key => $value) {
            $cleanKey = str_replace(['_', ' ', '/', ',', '"', "'"], '', strtolower(trim($key)));
            $cleanRow[$cleanKey] = $value;
        }

        // 1. Cek jika NIK kosong atau rusak, langsung skip baris ini
        if (empty($cleanRow['nik'])) {
            return null;
        }

        // 2. JINAKKAN FORMAT NIK (Mencegah NIK berubah jadi format matematika E+15)
        $nikBersih = trim($cleanRow['nik']);
        if (is_numeric($nikBersih) && (strpos(strtolower($nikBersih), 'e') !== false || floatval($nikBersih) > 9999999999)) {
            $nikBersih = sprintf("%.0f", floatval($nikBersih));
        }

        // --- AMAN & ANTI-GANDA: CEK REALTIME JIKA NIK WARGA SUDAH ADA DI DATABASE ---
        $wargaLama = Penduduk::where('nik', $nikBersih)->first();

        // 3. PECAH DATA "TEMPAT, TANGGAL LAHIR" (Key setelah dirapatkan: tempattanggallahir)
        $tempatLahir = '-';
        $tanggalLahir = date('Y-m-d');
        $kolomTtl = $cleanRow['tempattanggallahir'] ?? null;

        if (!empty($kolomTtl)) {
            if (str_contains($kolomTtl, ',')) {
                $pecah = explode(',', $kolomTtl);
                $tempatLahir = trim($pecah[0] ?? '-');
                $tanggalLahir = trim($pecah[1] ?? date('Y-m-d'));
            } else {
                $tempatLahir = trim($kolomTtl);
            }
        }

        // 4. JINAKKAN JENIS KELAMIN: Ubah otomatis 'Laki-laki' jadi 'L', 'Perempuan' jadi 'P'
        $jkMentah = strtoupper(trim($cleanRow['jeniskelamin'] ?? 'L'));
        $jkFinal = (str_starts_with($jkMentah, 'L') || str_contains($jkMentah, 'PRIA')) ? 'L' : 'P';

        // 5. AMBIL STATUS KAWIN SECARA FLEKSIBEL
        $statusPerkawinan = $cleanRow['statuskawin'] ?? $cleanRow['statusperkawinan'] ?? 'Belum Kawin';

        // Siapkan array data penduduk siap saji
        $dataPenduduk = [
            'nik'               => $nikBersih,
            'nama'              => trim($cleanRow['namalengkap'] ?? $cleanRow['nama'] ?? 'Tanpa Nama'),
            'tempat_lahir'      => $tempatLahir,
            'tgl_lahir'         => $tanggalLahir,
            'jenis_kelamin'     => $jkFinal,
            'agama'             => trim($cleanRow['agama'] ?? 'Islam'),
            'status_perkawinan' => $statusPerkawinan,
            'pekerjaan'         => trim($cleanRow['pekerjaan'] ?? 'Belum/Tidak Bekerja'),
            'alamat'            => trim($cleanRow['alamatdusun'] ?? $cleanRow['alamat'] ?? 'Desa Sukamaju'),
            'id_user'           => auth()->id() ?? 1,
        ];

        // LOGIKA KUNCI: 
        if ($wargaLama) {
            // Kalau NIK-nya udah terdaftar, update/timpa data lamanya biar gak bikin baris ganda
            $wargaLama->update($dataPenduduk);
            return null; // Return null agar engine Excel skip bikin row baru
        }

        // Kalau beneran data NIK baru, halalkan proses pembuatan data barunya
        return new Penduduk($dataPenduduk);
    }
}
