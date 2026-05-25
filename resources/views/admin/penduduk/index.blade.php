@extends('layouts.admin')

@section('content')
{{-- WAJIB LOAD FONT POPPINS --}}
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet">

<style>
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

    .header-siapde-paten {
        height: 85px;
        background: var(--sidebar-primary);
        border-bottom: 3px solid var(--sidebar-accent);
        width: 100%;
        display: flex;
        align-items: center;
        padding: 0 20px;
        box-sizing: border-box;
        color: white;
    }

    .header-siapde-paten h2 {
        margin: 0 !important;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 18px;
        line-height: 1;
    }

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
        color: var(--sidebar-primary);
        font-size: 11.5px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        background: #f8f9fc;
    }

    .table-paten th:first-child,
    .table-paten td:first-child {
        padding-left: 20px !important;
    }

    .table-paten th:last-child,
    .table-paten td:last-child {
        padding-right: 20px !important;
    }

    .text-wrap-custom {
        white-space: normal;
        line-height: 1.4;
        display: block;
    }

    .nama-styling {
        font-weight: 700;
        font-size: 13px;
        color: var(--sidebar-primary);
        text-transform: uppercase;
    }

    .nik-styling {
        color: var(--sidebar-accent);
        font-weight: 700;
        font-family: 'Consolas', monospace;
        font-size: 14px;
        letter-spacing: 0.5px;
        white-space: nowrap;
    }

    .search-input {
        height: 38px;
        border: 1px solid #d1d3e2;
        border-radius: 50px;
        padding: 0 15px 0 38px;
        font-size: 12px;
        font-weight: 600;
        width: 250px;
        outline: none;
        color: var(--sidebar-primary);
    }

    .btn-modern-pill {
        height: 38px;
        display: inline-flex;
        align-items: center;
        padding: 0 20px;
        border-radius: 50px;
        font-weight: 800;
        font-size: 11px;
        letter-spacing: 0.5px;
        text-decoration: none;
        border: none;
        color: white;
        cursor: pointer;
        transition: 0.2s;
        white-space: nowrap;
    }

    .btn-modern-pill:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        color: white;
        text-decoration: none;
    }

    .btn-action {
        width: 34px;
        height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: white;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        text-decoration: none;
        transition: 0.2s;
    }

    .btn-action:hover {
        transform: scale(1.1);
        color: white;
    }

    .badge-jk {
        padding: 6px 12px;
        border-radius: 30px;
        font-size: 9.5px;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        gap: 5px;
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

    .bg-warning-custom {
        background-color: #f6c23e;
        box-shadow: 0 2px 5px rgba(246, 194, 62, 0.2);
    }

    .bg-danger-custom {
        background-color: #e74a3b;
        box-shadow: 0 2px 5px rgba(231, 74, 59, 0.2);
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

    {{-- HEADER --}}
    <div class="header-siapde-paten">
        <h2>DATABASE KEPENDUDUKAN SELURUH WARGA</h2>
    </div>

    {{-- ACTION BAR --}}
    <div style="background: #f8f9fc; padding: 20px; border-bottom: 1px solid #eaecf4; display: flex; justify-content: flex-start; align-items: center; flex-wrap: wrap; gap: 12px; box-sizing: border-box;">

        <form action="{{ route('penduduk.index') }}" method="GET" style="display: flex; align-items: center; gap: 6px; margin: 0;">
            <div style="position: relative; display: flex; align-items: center;">
                <i class="fas fa-search" style="position: absolute; left: 15px; color: #b7b9cc; font-size: 13px;"></i>
                <input type="text" name="search" class="search-input" placeholder="Cari NIK atau Nama..." value="{{ request('search') }}">
            </div>
            <button type="submit" class="btn-modern-pill" style="background: var(--sidebar-accent);">CARI</button>
            @if(request('search'))
            <a href="{{ route('penduduk.index') }}" class="btn-modern-pill" style="background: #e74a3b;" title="Reset">
                <i class="fas fa-times"></i>
            </a>
            @endif
        </form>

        <div style="width: 1px; height: 25px; background: #e3e6f0; margin: 0 4px;"></div>

        <div style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
            <form action="{{ route('penduduk.import') }}" method="POST" enctype="multipart/form-data" id="formImportAjaib" style="display: none;">
                @csrf
                <input type="file" name="file" id="fileImportAjaib" accept=".xlsx, .xls, .csv" onchange="document.getElementById('formImportAjaib').submit();">
            </form>

            <button type="button" class="btn-modern-pill" style="background: #1cc88a;" onclick="document.getElementById('fileImportAjaib').click();">
                <i class="fas fa-upload" style="margin-right: 6px;"></i> IMPORT
            </button>

            <a href="{{ route('penduduk.export') }}" class="btn-modern-pill" style="background: #059669;">
                <i class="fas fa-file-excel" style="margin-right: 6px;"></i> EXPORT
            </a>

            <a href="{{ route('penduduk.create') }}" class="btn-modern-pill" style="background: var(--sidebar-primary);">
                <i class="fas fa-plus-circle" style="margin-right: 6px;"></i> TAMBAH DATA
            </a>
        </div>

        <div style="margin-left: auto; background: white; color: var(--sidebar-primary); padding: 8px 18px; border-radius: 50px; border: 1px solid #d1d3e2; font-weight: 800; font-size: 11.5px; white-space: nowrap;">
            TOTAL: {{ $penduduk->count() }} JIWA
        </div>
    </div>

    {{-- TABEL --}}
    <div style="padding: 0 0 40px 0;">
        <div class="table-responsive" style="background: white; border-top: 1px solid #eaecf4; border-bottom: 1px solid #eaecf4; overflow-x: auto;">
            <table class="table-paten">
                <thead>
                    <tr style="background: #f8f9fc;">
                        <th style="min-width: 50px; text-align: center; border-bottom: 2px solid var(--sidebar-accent);">NO</th>
                        <th style="min-width: 150px; text-align: center; border-bottom: 2px solid var(--sidebar-accent);">NIK</th>
                        <th style="min-width: 200px; text-align: left; border-bottom: 2px solid var(--sidebar-accent);">NAMA LENGKAP</th>
                        <th style="min-width: 180px; text-align: left; border-bottom: 2px solid var(--sidebar-accent);">TEMPAT, TANGGAL LAHIR</th>
                        <th style="min-width: 140px; text-align: center; border-bottom: 2px solid var(--sidebar-accent);">JENIS KELAMIN</th>
                        <th style="min-width: 100px; text-align: left; border-bottom: 2px solid var(--sidebar-accent);">AGAMA</th>
                        <th style="min-width: 120px; text-align: left; border-bottom: 2px solid var(--sidebar-accent);">STATUS KAWIN</th>
                        <th style="min-width: 140px; text-align: left; border-bottom: 2px solid var(--sidebar-accent);">PEKERJAAN</th>
                        <th style="min-width: 220px; text-align: left; border-bottom: 2px solid var(--sidebar-accent);">ALAMAT / DUSUN</th>
                        <th style="min-width: 100px; text-align: center; border-bottom: 2px solid var(--sidebar-accent);">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($penduduk as $index => $p)
                    <tr onmouseover="this.style.backgroundColor='#f8f9fc'" onmouseout="this.style.backgroundColor='transparent'">
                        <td align="center" style="font-weight: 700; color: #b7b9cc; font-size: 13px;">{{ $index + 1 }}</td>
                        <td align="center"><span class="nik-styling">{{ $p->nik }}</span></td>
                        <td style="text-align: left;"><span class="text-wrap-custom nama-styling">{{ $p->nama }}</span></td>
                        <td style="text-align: left;">
                            @php
                            $formattedTgl = '-';
                            if (!empty($p->tgl_lahir)) {
                            try {
                            $tgl = \Illuminate\Support\Carbon::parse($p->tgl_lahir);
                            $formattedTgl = $tgl->format('d') . ' ' . ($bulanIndo[$tgl->format('m')] ?? '') . ' ' . $tgl->format('Y');
                            } catch (\Exception $e) {
                            $formattedTgl = $p->tgl_lahir;
                            }
                            }
                            @endphp
                            <div class="text-wrap-custom" style="font-weight: 700; color: #5a5c69; font-size: 13px;">{{ strtoupper($p->tempat_lahir ?? '-') }}</div>
                            <small style="color: #b7b9cc; font-weight: 600; display: block; margin-top: 2px;">{{ $formattedTgl }}</small>
                        </td>
                        <td align="center">
                            @php $isLaki = (strtoupper(substr(trim($p->jenis_kelamin), 0, 1)) === 'L'); @endphp
                            <span class="badge-jk {{ $isLaki ? 'bg-l' : 'bg-p' }}">
                                <i class="fas {{ $isLaki ? 'fa-mars' : 'fa-venus' }}"></i>
                                {{ $isLaki ? 'LAKI-LAKI' : 'PEREMPUAN' }}
                            </span>
                        </td>
                        <td style="font-weight: 600; font-size: 13px; color: #5a5c69; text-transform: uppercase;">{{ $p->agama ?? '-' }}</td>
                        <td style="font-weight: 600; font-size: 13px; color: #5a5c69; text-transform: uppercase;">{{ $p->status_kawin ?? $p->status_perkawinan ?? '-' }}</td>
                        <td style="font-weight: 600; font-size: 13px; color: #5a5c69; text-transform: uppercase;"><span class="text-wrap-custom">{{ $p->pekerjaan ?? '-' }}</span></td>
                        <td style="font-size: 13px; line-height: 1.4; color: #858796; font-weight: 600;"><span class="text-wrap-custom">{{ $p->alamat ?? $p->dusun ?? '-' }}</span></td>
                        <td align="center">
                            <div style="display: flex; gap: 6px; justify-content: center;">
                                <a href="{{ route('penduduk.edit', $p->id_penduduk) }}" class="btn-action bg-warning-custom" title="Edit Data"><i class="fas fa-edit" style="font-size: 12px;"></i></a>
                                <form action="{{ route('penduduk.destroy', $p->id_penduduk) }}" method="POST" onsubmit="return confirm('Hapus data penduduk ini?')" style="display: inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-action bg-danger-custom" title="Hapus"><i class="fas fa-trash" style="font-size: 12px;"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" align="center" style="padding: 120px 0; color: #b7b9cc;">
                            <div style="position: relative; display: inline-block; margin-bottom: 20px;">
                                <i class="fas fa-users-slash fa-4x" style="color: #dddfeb; opacity: 0.7;"></i>
                            </div>
                            <h5 style="font-weight: 800; color: #5a5c69; margin: 0 0 5px 0; font-size: 15px;">Data Penduduk Tidak Ditemukan</h5>
                            <p style="font-size: 12.5px; color: #b7b9cc; margin: 0; font-weight: 600;">{{ request('search') ? 'Kata kunci tidak cocok dengan NIK atau Nama warga mana pun.' : 'Database kependudukan desa saat ini masih kosong.' }}</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection