@extends('layouts.admin')

@section('content')
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

    .header-siapde-paten h4 {
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
        border-bottom: 2px solid var(--sidebar-accent);
    }

    .table-paten th:first-child,
    .table-paten td:first-child {
        padding-left: 20px !important;
    }

    .table-paten th:last-child,
    .table-paten td:last-child {
        padding-right: 20px !important;
    }

    .fit-column {
        width: 1%;
        white-space: nowrap;
    }

    .nama-styling {
        font-weight: 700;
        font-size: 13.5px;
        color: var(--sidebar-primary);
        text-transform: uppercase;
        white-space: normal;
        line-height: 1.4;
        display: block;
    }

    .jenis-styling {
        font-weight: 700;
        font-size: 13px;
        color: var(--sidebar-accent);
        white-space: normal;
        line-height: 1.4;
    }

    .nik-styling {
        color: var(--sidebar-accent);
        font-weight: 700;
        font-family: 'Consolas', monospace;
        font-size: 14px;
        letter-spacing: 0.5px;
    }

    .btn-square-custom {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: white;
        border: none;
        transition: 0.2s;
        text-decoration: none;
    }

    .btn-square-custom:hover {
        transform: scale(1.1);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        color: white;
    }

    .filter-item {
        height: 38px !important;
        box-sizing: border-box;
        border: 1px solid #d1d3e2;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        color: var(--sidebar-primary);
        font-family: 'Poppins', sans-serif;
        padding: 0 12px;
        outline: none;
    }
</style>

<div class="siapde-container-full">
    <div class="header-siapde-paten">
        <h4>DAFTAR PENGAJUAN SURAT LAYANAN</h4>
    </div>

    {{-- FILTER & ACTION BAR --}}
    <div style="background: #f8f9fc; padding: 20px; border-bottom: 1px solid #eaecf4; margin-bottom: 20px;">
        <div style="display: flex; justify-content: space-between; align-items: flex-end; gap: 20px; flex-wrap: wrap;">

            <form action="{{ route('surat.index') }}" method="GET" style="display: flex; gap: 12px; flex: 1; align-items: flex-end; flex-wrap: wrap;">
                <div>
                    <label style="display: block; font-size: 10px; font-weight: 800; color: var(--sidebar-primary); text-transform: uppercase; margin-bottom: 6px; letter-spacing: 0.5px;">Tgl Mulai</label>
                    <input type="date" name="tgl_mulai" value="{{ request('tgl_mulai') }}" class="filter-item" style="width: 160px;">
                </div>
                <div>
                    <label style="display: block; font-size: 10px; font-weight: 800; color: var(--sidebar-primary); text-transform: uppercase; margin-bottom: 6px; letter-spacing: 0.5px;">Tgl Selesai</label>
                    <input type="date" name="tgl_selesai" value="{{ request('tgl_selesai') }}" class="filter-item" style="width: 160px;">
                </div>
                <div style="min-width: 260px; flex: 1;">
                    <label style="display: block; font-size: 10px; font-weight: 800; color: var(--sidebar-primary); text-transform: uppercase; margin-bottom: 6px; letter-spacing: 0.5px;">Jenis Surat</label>
                    <select name="jenis_surat" class="filter-item" style="width: 100%; background: white;">
                        <option value="">-- Semua Jenis Surat --</option>
                        @foreach($daftar_surat as $key => $value)
                        <option value="{{ $key }}" {{ request('jenis_surat') == $key ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>

                <div style="display: flex; gap: 6px;">
                    <button type="submit" style="background: var(--sidebar-primary); color: white; border: none; padding: 0 22px; border-radius: 8px; font-weight: 800; font-size: 11px; letter-spacing: 0.5px; cursor: pointer; height: 38px;">
                        <i class="fas fa-filter mr-1"></i> FILTER
                    </button>
                    <a href="{{ route('surat.index') }}" style="background: #eaecf4; color: #5a5c69; padding: 0 22px; border-radius: 8px; font-weight: 800; font-size: 11px; letter-spacing: 0.5px; text-decoration: none; height: 38px; display: inline-flex; align-items: center;">
                        RESET
                    </a>
                </div>
            </form>

            <a href="{{ route('surat.create') }}" style="background: var(--sidebar-accent); color: white; padding: 0 25px; border-radius: 50px; font-weight: 800; font-size: 11px; letter-spacing: 0.5px; text-decoration: none; box-shadow: 0 4px 12px rgba(46,134,193,0.25); height: 38px; display: inline-flex; align-items: center; transition: 0.2s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                <i class="fas fa-plus-circle" style="margin-right: 8px; font-size: 13px;"></i> TAMBAH SURAT
            </a>
        </div>
    </div>

    {{-- TABEL --}}
    <div style="padding: 0 0 40px 0;">
        <div style="background: white; border-top: 1px solid #eaecf4; border-bottom: 1px solid #eaecf4; overflow: hidden;">
            <table class="table-paten">
                <thead>
                    <tr>
                        <th class="fit-column" style="text-align: center;">NO</th>
                        <th class="fit-column" style="text-align: center;">NIK</th>
                        <th style="text-align: left;">NAMA PENDUDUK</th>
                        <th style="text-align: left;">JENIS SURAT</th>
                        <th class="fit-column" style="text-align: center;">TGL AJU</th>
                        <th class="fit-column" style="text-align: center;">STATUS</th>
                        <th class="fit-column" style="text-align: center;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($surats as $index => $s)
                    <tr onmouseover="this.style.backgroundColor='#f8f9fc'" onmouseout="this.style.backgroundColor='transparent'">
                        <td class="fit-column" align="center" style="font-weight: 700; color: #b7b9cc; font-size: 13px;">{{ $index + 1 }}</td>
                        <td class="fit-column" align="center"><span class="nik-styling">{{ $s->penduduk->nik ?? '-' }}</span></td>
                        <td style="text-align: left;"><span class="nama-styling">{{ $s->penduduk->nama ?? 'DATA TIDAK DITEMUKAN' }}</span></td>
                        <td style="text-align: left;"><span class="jenis-styling">{{ $s->jenis_surat }}</span></td>
                        <td class="fit-column" align="center">
                            <div style="font-weight: 700; color: #5a5c69; font-size: 13px;">
                                {{ \Carbon\Carbon::parse($s->tanggal_pengajuan ?? $s->created_at)->format('d/m/Y') }}
                            </div>
                        </td>
                        <td class="fit-column" align="center">
                            <span style="padding: 6px 14px; border-radius: 6px; font-size: 10px; font-weight: 800; display: inline-block; {{ strtolower($s->status) == 'disetujui' ? 'background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0;' : (strtolower($s->status) == 'selesai' ? 'background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd;' : (strtolower($s->status) == 'ditolak' ? 'background: #fee2e2; color: #991b1b; border: 1px solid #fecaca;' : 'background: #fff3cd; color: #856404; border: 1px solid #ffeeba;')) }}">
                                {{ strtoupper($s->status) }}
                            </span>
                        </td>
                        <td class="fit-column" align="center">
                            <div style="display: flex; gap: 6px; justify-content: center;">
                                @if(strtolower($s->status) == 'disetujui')
                                <a href="{{ route('surat.cetak', $s->id_surat) }}" target="_blank" class="btn-square-custom" style="background: var(--sidebar-accent);" title="Cetak Surat" onclick="setTimeout(function(){ location.reload(); }, 1200);"><i class="fas fa-print"></i></a>
                                @endif

                                @if(strtolower($s->status) == 'diajukan' || strtolower($s->status) == 'disetujui')
                                <a href="{{ route('surat.edit', $s->id_surat) }}" class="btn-square-custom" style="background: #f6c23e;" title="Edit"><i class="fas fa-edit"></i></a>
                                @endif

                                @if(strtolower($s->status) == 'selesai')
                                <span class="btn-square-custom" style="background: #e2e8f0; color: #94a3b8; cursor: not-allowed;" title="Data Surat Dikunci Permanen"><i class="fas fa-lock"></i></span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" align="center" style="padding: 120px 0; color: #b7b9cc;">
                            <div style="position: relative; display: inline-block; margin-bottom: 20px;">
                                <i class="fas fa-folder-open fa-4x" style="color: #dddfeb; opacity: 0.7;"></i>
                            </div>
                            <h5 style="font-weight: 800; color: #5a5c69; margin: 0 0 5px 0; font-size: 15px;">Belum Ada Pengajuan Ditemukan</h5>
                            <p style="font-size: 12.5px; color: #b7b9cc; margin: 0; font-weight: 600;">Silakan sesuaikan rentang tanggal atau jenis surat pada filter.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection