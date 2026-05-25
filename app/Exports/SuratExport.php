<?php

namespace App\Exports;

use App\Models\Penduduk;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PendudukExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * Ambil seluruh data penduduk dari database
     */
    public function collection()
    {
        return Penduduk::orderBy('nama', 'asc')->get();
    }

    /**
     * Set susunan Judul Kolom di baris pertama Excel lo
     */
    public function headings(): array
    {
        return [
            'NIK',
            'Nama Lengkap',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Jenis Kelamin',
            'Agama',
            'Status Perkawinan',
            'Pekerjaan',
            'Alamat Dusun'
        ];
    }

    /**
     * Atur pemetaan data kolom (Kunci utama anti-ilmiah disisipkan di sini)
     */
    public function map($penduduk): array
    {
        return [
            // KUNCI SAKTI: Tambah tanda petik satu didepan NIK agar Excel membacanya sebagai TEXT utuh murni
            "'" . $penduduk->nik,
            $penduduk->nama,
            $penduduk->tempat_lahir,
            $penduduk->tgl_lahir,
            $penduduk->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan',
            $penduduk->agama,
            $penduduk->status_perkawinan,
            $penduduk->pekerjaan,
            $penduduk->alamat,
        ];
    }
}
