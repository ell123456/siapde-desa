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
    }

    /* KUNCI: HEADER SEJAJAR LOGO SIDEBAR (85px) */
    .header-siapde-paten {
        height: 85px;
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        width: 100%;
        display: flex;
        align-items: center;
        /* Teks judul mepet kiri lurus sama NO di tabel */
        padding: 0 15px;
        box-sizing: border-box;
        color: white;
        border-bottom: 3px solid var(--neon-cyan);
    }

    .header-siapde-paten h2 {
        margin: 0 !important;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 18px;
        line-height: 1;
    }

    /* TABEL PADAT & RAPI - RAPAT KE SIDEBAR */
    .table-paten {
        table-layout: auto;
        width: 100%;
        border-collapse: collapse;
        background: white;
    }

    .table-paten th,
    .table-paten td {
        vertical-align: middle;
        padding: 12px 10px;
        border-bottom: 1px solid #f1f3f9;
    }

    .table-paten th {
        color: #4e73df;
        font-size: 10.5px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        white-space: nowrap;
    }

    /* STYLING DATA */
    .text-wrap-custom {
        white-space: normal;
        line-height: 1.4;
        display: block;
    }

    .nama-styling {
        font-weight: 700;
        font-size: 12.5px;
        color: #1e3a8a;
        text-transform: uppercase;
    }

    .nik-styling {
        color: #4e73df;
        font-weight: 700;
        font-family: 'Consolas', monospace;
        font-size: 13px;
        letter-spacing: 0.5px;
        white-space: nowrap;
    }

    .search-input {
        height: 38px;
        border: 1px solid #d1d3e2;
        border-radius: 50px;
        padding: 0 15px 0 35px;
        font-size: 12px;
        width: 280px;
        outline: none;
    }

    .btn-modern-pill {
        height: 38px;
        display: inline-flex;
        align-items: center;
        padding: 0 20px;
        border-radius: 50px;
        font-weight: 800;
        font-size: 11px;
        text-decoration: none;
        border: none;
        color: white;
        cursor: pointer;
    }

    .btn-action {
        width: 30px;
        height: 30px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: white;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        text-decoration: none;
    }

    .badge-jk {
        padding: 5px 10px;
        border-radius: 30px;
        font-size: 9px;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        white-space: nowrap;
    }

    .bg-l {
        background-color: #e3f2fd;
        color: #0d47a1;
        border: 1px solid #bbdefb;
    }

    .bg-p {
        background-color: #fce4ec;
        color: #880e4f;
        border: 1px solid #f8bbd0;
    }

    .bg-warning {
        background-color: #f6c23e;
    }

    .bg-danger {
        background-color: #e74a3b;
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

    {{-- HEADER PATEN --}}
    <div class="header-siapde-paten">
        <h2>DATABASE KEPENDUDUKAN SELURUH WARGA</h2>
    </div>

    {{-- ACTION BAR (SEARCH & BUTTONS) --}}
    <div style="background: #f8f9fc; padding: 15px; border-bottom: 1px solid #eaecf4; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">

        {{-- FORM SEARCH --}}
        <form action="{{ route('penduduk.index') }}" method="GET" style="display: flex; align-items: center; gap: 8px; margin: 0;">
            <div style="position: relative; display: flex; align-items: center;">
                <i class="fas fa-search" style="position: absolute; left: 12px; color: #b7b9cc; font-size: 13px;"></i>
                <input type="text" name="search" class="search-input" placeholder="Cari NIK atau Nama..." value="{{ request('search') }}">
            </div>
            <button type="submit" class="btn-modern-pill" style="background: #4e73df;">CARI</button>
            @if(request('search'))
            <a href="{{ route('penduduk.index') }}" class="btn-modern-pill" style="background: #e74a3b;" title="Reset Pencarian">
                <i class="fas fa-times"></i>
            </a>
            @endif
        </form>

        <div style="display: flex; gap: 10px;">
            {{-- FORM IMPORT --}}
            <form action="{{ route('penduduk.import') }}" method="POST" enctype="multipart/form-data" id="formImportAjaib" style="display: none;">
                @csrf
                <input type="file" name="file" id="fileImportAjaib" accept=".xlsx, .xls, .csv" onchange="document.getElementById('formImportAjaib').submit();">
            </form>

            <button type="button" class="btn-modern-pill" style="background: #1cc88a;" onclick="document.getElementById('fileImportAjaib').click();">
                <i class="fas fa-file-excel" style="margin-right: 6px;"></i> IMPORT EXCEL
            </button>

            {{-- TOMBOL TAMBAH --}}
            <a href="{{ route('penduduk.create') }}" class="btn-modern-pill" style="background: #4e73df;">
                <i class="fas fa-plus-circle" style="margin-right: 6px;"></i> TAMBAH DATA
            </a>
        </div>
    </div>

    {{-- TABLE AREA - JARAK KE SIDEBAR DIHAPUS (PAGING: 0 15px) --}}
    <div class="table-responsive" style="overflow-x: auto; padding: 0 15px 40px 0;">
        <div style="background: white; border-radius: 0 12px 12px 0; border: 1px solid #eaecf4; border-left: none; overflow: hidden;">
            <table class="table-paten">
                <thead>
                    <tr style="background: #f8f9fc;">
                        <th style="min-width: 40px; text-align: center; border-bottom: 2px solid #4e73df;">NO</th>
                        <th style="min-width: 140px; text-align: center; border-bottom: 2px solid #4e73df;">NIK</th>
                        <th style="min-width: 180px; text-align: left; border-bottom: 2px solid #4e73df;">NAMA LENGKAP</th>
                        <th style="min-width: 130px; text-align: left; border-bottom: 2px solid #4e73df;">TTL</th>
                        <th style="min-width: 110px; text-align: center; border-bottom: 2px solid #4e73df;">JENIS KELAMIN</th>
                        <th style="min-width: 90px; text-align: left; border-bottom: 2px solid #4e73df;">AGAMA</th>
                        <th style="min-width: 110px; text-align: left; border-bottom: 2px solid #4e73df;">STATUS KAWIN</th>
                        <th style="min-width: 110px; text-align: left; border-bottom: 2px solid #4e73df;">PEKERJAAN</th>
                        <th style="min-width: 200px; text-align: left; border-bottom: 2px solid #4e73df;">ALAMAT / DUSUN</th>
                        <th style="min-width: 90px; text-align: center; border-bottom: 2px solid #4e73df;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($penduduk as $index => $p)
                    <tr onmouseover="this.style.backgroundColor='#f8f9fc'" onmouseout="this.style.backgroundColor='transparent'">
                        <td align="center" style="font-weight: 700; color: #b7b9cc; font-size: 12px;">{{ $index + 1 }}</td>
                        <td align="center"><span class="nik-styling">{{ $p->nik }}</span></td>
                        <td style="text-align: left;"><span class="text-wrap-custom nama-styling">{{ $p->nama }}</span></td>
                        <td style="text-align: left;">
                            @php
                            $tgl = \Illuminate\Support\Carbon::parse($p->tgl_lahir);
                            $formattedTgl = $tgl->format('d') . ' ' . ($bulanIndo[$tgl->format('m')] ?? '') . ' ' . $tgl->format('Y');
                            @endphp
                            <div class="text-wrap-custom" style="font-weight: 700; color: #5a5c69; font-size: 11.5px;">{{ strtoupper($p->tempat_lahir) }}</div>
                            <small style="color: #b7b9cc; font-weight: 600; display: block;">{{ $formattedTgl }}</small>
                        </td>
                        <td align="center">
                            <span class="badge-jk {{ $p->jenis_kelamin == 'L' ? 'bg-l' : 'bg-p' }}">
                                <i class="fas {{ $p->jenis_kelamin == 'L' ? 'fa-mars' : 'fa-venus' }}"></i>
                                {{ $p->jenis_kelamin == 'L' ? 'LAKI-LAKI' : 'PEREMPUAN' }}
                            </span>
                        </td>
                        <td style="font-weight: 600; font-size: 11.5px; color: #5a5c69; text-transform: uppercase;">{{ $p->agama ?? '-' }}</td>
                        <td style="font-weight: 600; font-size: 11.5px; color: #5a5c69; text-transform: uppercase;">{{ $p->status_kawin ?? $p->status_perkawinan ?? '-' }}</td>
                        <td style="font-weight: 600; font-size: 11.5px; color: #5a5c69; text-transform: uppercase;"><span class="text-wrap-custom">{{ $p->pekerjaan ?? '-' }}</span></td>
                        <td style="font-size: 11.5px; line-height: 1.4; color: #858796;"><span class="text-wrap-custom">{{ $p->alamat ?? $p->dusun ?? '-' }}</span></td>
                        <td align="center">
                            <div style="display: flex; gap: 5px; justify-content: center;">
                                <a href="{{ route('penduduk.edit', $p->id_penduduk) }}" class="btn-action bg-warning" title="Edit">
                                    <i class="fas fa-edit" style="font-size: 11px;"></i>
                                </a>
                                <form action="{{ route('penduduk.destroy', $p->id_penduduk) }}" method="POST" onsubmit="return confirm('Hapus data?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-action bg-danger" title="Hapus">
                                        <i class="fas fa-trash" style="font-size: 11px;"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" align="center" style="padding: 100px; color: #b7b9cc; font-weight: 600;">Data tidak ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection