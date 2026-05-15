@extends('layouts.admin')

@section('content')
{{-- WAJIB LOAD FONT POPPINS --}}
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet">

<style>
    /* TARIK PAKSA NABRAK SIDEBAR & LAYAR */
    .siapde-container-full {
        font-family: 'Poppins', sans-serif !important;
        background-color: white;
        margin: 0 !important;
        padding: 0 !important;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        box-sizing: border-box;
    }

    /* KUNCI: HEADER SEJAJAR LOGO SIDEBAR (85px) */
    .header-siapde-paten {
        height: 85px;
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        width: 100%;
        display: flex;
        align-items: center;
        padding: 0 15px;
        box-sizing: border-box;
        color: white;
        border-bottom: 3px solid var(--neon-cyan);
    }

    .header-siapde-paten h4 {
        margin: 0 !important;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 18px;
        line-height: 1;
    }

    /* TABEL PADAT & RAPAT SIDEBAR */
    .table-paten {
        table-layout: auto;
        width: 100%;
        border-collapse: collapse;
        background: white;
    }

    .table-paten th,
    .table-paten td {
        vertical-align: middle;
        padding: 16px 12px;
        border-bottom: 1px solid #f1f3f9;
    }

    .table-paten th {
        color: #4e73df;
        font-size: 11.5px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #4e73df;
    }

    .fit-column {
        width: 1%;
        white-space: nowrap;
    }

    /* STYLE DATA */
    .nama-styling {
        font-weight: 700;
        font-size: 13.5px;
        color: #1e3a8a;
        text-transform: uppercase;
        white-space: normal;
        line-height: 1.4;
        display: block;
    }

    .jenis-styling {
        font-weight: 700;
        font-size: 13px;
        color: #4e73df;
    }

    .nik-styling {
        color: #4e73df;
        font-weight: 700;
        font-family: 'Consolas', monospace;
        font-size: 14px;
        letter-spacing: 0.5px;
    }

    /* Style untuk Nomor Surat Resmi */
    .no-surat-styling {
        color: #4e73df;
        font-weight: 700;
        font-size: 12.5px;
        background: #f0f4fe;
        padding: 4px 10px;
        border-radius: 6px;
        display: inline-block;
        border: 1px solid #d9e2fc;
    }

    /* Style Dropdown Saring Sebaris */
    .saring-select-kustom {
        height: 32px;
        padding: 0 10px;
        font-size: 11px;
        font-weight: 800;
        color: #4e73df;
        border: 1px solid #d1d3e2;
        border-radius: 6px;
        background: white;
        outline: none;
        cursor: pointer;
    }
</style>

<div class="siapde-container-full">

    @php
    $bulanIndo = [
    '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
    '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
    '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
    ];
    @endphp

    <div class="header-siapde-paten">
        <h4>ARSIP RIWAYAT SELURUH SURAT</h4>
    </div>

    {{-- ACTION BAR SEBARIS --}}
    <div style="background: #f8f9fc; padding: 15px; border-bottom: 1px solid #eaecf4; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
        <div style="display: flex; align-items: center; gap: 15px;">
            
            {{-- DROPDOWN FILTER KUSTOM (Urutan & Nama Disamakan 100% dengan Form Create) --}}
            <select id="saringJenisSurat" class="saring-select-kustom">
                <option value="">-- SEMUA JENIS SURAT --</option>
                <option value="Surat Pengantar SKCK">Surat Pengantar SKCK</option>
                <option value="Surat Keterangan Domisili">Surat Keterangan Domisili</option>
                <option value="Surat Pengantar KTP">Surat Pengantar KTP</option>
                <option value="Surat Keterangan Usaha">Surat Keterangan Usaha (SKU)</option>
                <option value="Surat Keterangan Tidak Mampu">Surat Keterangan Tidak Mampu (SKTM)</option>
                <option value="Surat Keterangan Kelahiran">Surat Keterangan Kelahiran</option>
                <option value="Surat Keterangan Kematian">Surat Keterangan Kematian</option>
                <option value="Surat Keterangan Ahli Waris">Surat Keterangan Ahli Waris</option>
            </select>
            
            <div style="color: #858796; font-size: 12.5px; font-weight: 700;">
                <i class="fas fa-info-circle text-primary"></i> Menampilkan dokumen administrasi yang telah selesai diproses.
            </div>
        </div>
        <div style="background: white; color: #4e73df; padding: 8px 18px; border-radius: 50px; border: 1px solid #d1d3e2; font-weight: 800; font-size: 11.5px; display: flex; align-items: center; gap: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
            <i class="fas fa-file-invoice"></i> TOTAL: {{ $surats->count() }} DOKUMEN
        </div>
    </div>

    {{-- TABLE AREA PRESISI --}}
    <div class="table-responsive" style="padding: 0 15px 40px 0;">
        <div style="background: white; border-radius: 0 12px 12px 0; border: 1px solid #eaecf4; border-left: none; overflow: hidden;">
            <table class="table-paten">
                <thead>
                    <tr style="background: #f8f9fc;">
                        <th class="fit-column" style="text-align: center;">NO</th>
                        <th class="fit-column" style="text-align: center;">NOMOR SURAT</th>
                        <th class="fit-column" style="text-align: center;">NIK</th>
                        <th style="text-align: left;">NAMA PENDUDUK</th>
                        <th style="text-align: left;">JENIS SURAT</th>
                        <th class="fit-column" style="text-align: center;">STATUS</th>
                        <th class="fit-column" style="text-align: left;">TGL PROSES</th>
                        <th class="fit-column" style="text-align: center;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($surats as $key => $item)
                    <tr class="baris-arsip-data" data-jenis="{{ $item->jenis_surat }}" onmouseover="this.style.backgroundColor='#f8f9fc'" onmouseout="this.style.backgroundColor='transparent'">

                        <td class="fit-column" align="center" style="font-weight: 700; color: #b7b9cc; font-size: 13px;">{{ $key + 1 }}</td>

                        <td class="fit-column" align="center">
                            <span class="no-surat-styling">140 / {{ str_pad($item->id_surat, 3, '0', STR_PAD_LEFT) }} / {{ date('Y') }}</span>
                        </td>

                        <td class="fit-column" align="center">
                            <span class="nik-styling">{{ $item->penduduk->nik ?? '-' }}</span>
                        </td>

                        <td style="text-align: left;">
                            <span class="nama-styling">{{ $item->penduduk->nama ?? 'N/A' }}</span>
                        </td>

                        <td style="text-align: left;">
                            <span class="jenis-styling">{{ $item->jenis_surat }}</span>
                        </td>

                        <td class="fit-column" align="center">
                            <span style="padding: 6px 14px; border-radius: 6px; font-size: 10px; font-weight: 800; display: inline-block; {{ $item->status == 'disetujui' ? 'background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0;' : 'background: #fee2e2; color: #991b1b; border: 1px solid #fecaca;' }}">
                                {{ strtoupper($item->status) }}
                            </span>
                        </td>

                        <td class="fit-column" style="text-align: left;">
                            @php
                            $tgl = \Carbon\Carbon::parse($item->updated_at);
                            $tglIndoItem = $tgl->format('d') . ' ' . ($bulanIndo[$tgl->format('m')] ?? '') . ' ' . $tgl->format('Y');
                            @endphp
                            <div style="font-weight: 700; color: #5a5c69; font-size: 13px;">{{ $tglIndoItem }}</div>
                            <small style="color: #b7b9cc; font-size: 11px; font-weight: 600;"><i class="far fa-clock"></i> {{ $tgl->format('H:i') }} WIB</small>
                        </td>

                        <td class="fit-column" align="center">
                            <div style="display: flex; gap: 5px; justify-content: center;">
                                @if($item->status == 'disetujui')
                                <a href="{{ route('surat.cetak', $item->id_surat) }}" style="background: #4e73df; color: white; width: 34px; height: 34px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; transition: 0.2s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'" title="Cetak Surat">
                                    <i class="fas fa-file-pdf" style="font-size: 14px;"></i>
                                </a>
                                @else
                                <span style="color: #eaecf4; font-weight: bold; font-size: 16px;">-</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" align="center" style="padding: 120px; color: #b7b9cc; font-weight: 600; font-size: 14px;">
                            <i class="fas fa-folder-open fa-3x mb-3" style="opacity: 0.2; display: block;"></i>
                            Belum ada arsip riwayat surat ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectSaring = document.getElementById('saringJenisSurat');
        const semuaBaris = document.querySelectorAll('.baris-arsip-data');

        selectSaring.addEventListener('change', function() {
            const filterValue = this.value;
            semuaBaris.forEach(row => {
                const jenisSurat = row.getAttribute('data-jenis');
                
                // Trik pencarian text parsial agar teks "(SKU)" atau "(SKTM)" di database lo tetap lolos sensor
                if (filterValue === "" || jenisSurat.includes(filterValue) || filterValue.includes(jenisSurat)) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        });
    });
</script>
@endsection