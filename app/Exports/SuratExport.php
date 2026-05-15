<?php

namespace App\Exports;

use App\Models\Surat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SuratExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        // Ambil semua surat beserta relasi penduduk
        return Surat::with('penduduk')
            ->get()
            ->map(function ($surat) {
                return [
                    'Nama Penduduk' => $surat->penduduk->nama ?? '-',
                    'NIK' => $surat->penduduk->nik ?? '-',
                    'Tempat/Tanggal Lahir' => ($surat->penduduk->tempat_lahir ?? '-') . ', ' . ($surat->penduduk->tanggal_lahir ?? '-'),
                    'Alamat' => $surat->penduduk->alamat ?? '-',
                    'Jenis Surat' => $surat->jenis_surat,
                    'Tanggal Pengajuan' => $surat->tanggal_pengajuan,
                    'Status' => $surat->status ?? 'Menunggu',
                    'Keterangan' => $surat->keterangan ?? '-',
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Nama Penduduk',
            'NIK',
            'Tempat/Tanggal Lahir',
            'Alamat',
            'Jenis Surat',
            'Tanggal Pengajuan',
            'Status',
            'Keterangan'
        ];
    }
}
