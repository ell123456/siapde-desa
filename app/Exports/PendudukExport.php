<?php

namespace App\Exports;

use App\Models\Penduduk;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize; // KUNCI SAKTI A: BIAR KOLOM LEBAR OTOMATIS
use Maatwebsite\Excel\Concerns\WithStyles;     // KUNCI SAKTI B: BIAR BISA KASIH STYLE BOLD
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PendudukExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    // Variabel bantuan untuk membuat nomor urut 1, 2, 3... di Excel
    private $nomorUrut = 0;

    /**
     * Ambil seluruh data penduduk urut abjad A-Z
     */
    public function collection()
    {
        return Penduduk::orderBy('nama', 'asc')->get();
    }

    /**
     * Membuat Judul Kolom Baris Pertama (Pasti Muncul di Paling Atas)
     */
    public function headings(): array
    {
        return [
            'NO',
            'NIK',
            'NAMA LENGKAP',
            'TEMPAT LAHIR',
            'TANGGAL LAHIR',
            'JENIS KELAMIN',
            'AGAMA',
            'STATUS PERKAWINAN',
            'PEKERJAAN',
            'ALAMAT DUSUN'
        ];
    }

    /**
     * Memetakan data agar rapi dan urut sesuai kolom headings di atas
     */
    public function map($penduduk): array
    {
        $this->nomorUrut++;

        return [
            $this->nomorUrut, // Kolom A: Nomor urut cantik rapi
            "'" . $penduduk->nik, // Kolom B: NIK aman dikunci format TEXT (Anti E+15)
            $penduduk->nama,
            strtoupper($penduduk->tempat_lahir ?? '-'),
            $penduduk->tgl_lahir,
            $penduduk->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan',
            $penduduk->agama,
            $penduduk->status_perkawinan,
            $penduduk->pekerjaan ?? 'Belum/Tidak Bekerja',
            $penduduk->alamat,
        ];
    }

    /**
     * Otomatis membuat Baris Pertama (Judul Kolom) menjadi Cetak Tebal (Bold)
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Angka 1 artinya Baris Nomor 1 di Excel diatur Bold = True
            1 => ['font' => ['bold' => true]],
        ];
    }
}
