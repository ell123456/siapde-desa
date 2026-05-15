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
        /* Padding kiri kecil (15px) biar lurus sama teks di tabel yang rapat sidebar */
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

    /* TABEL FIX 1 LAYAR (ANTI SCROLL) & RAPAT SIDEBAR */
    .table-paten {
        table-layout: fixed;
        width: 100%;
        border-collapse: collapse;
        background: white;
    }

    .table-paten th,
    .table-paten td {
        vertical-align: middle;
        padding: 15px 12px;
        border-bottom: 1px solid #f1f3f9;
        overflow: hidden;
    }

    .table-paten th {
        color: #4e73df;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* STYLING DATA */
    .nama-styling {
        font-weight: 700;
        font-size: 13px;
        color: #1e3a8a;
        text-transform: uppercase;
        white-space: normal;
        line-height: 1.4;
        display: block;
    }

    .jenis-styling {
        font-weight: 600;
        color: #4e73df;
        font-size: 12.5px;
        white-space: normal;
        line-height: 1.4;
    }

    .nik-styling {
        color: #4e73df;
        font-weight: 700;
        font-family: 'Consolas', monospace;
        font-size: 13.5px;
    }

    .btn-square-custom {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: white;
        border: none;
        transition: 0.2s;
        text-decoration: none;
    }

    .filter-item {
        height: 38px !important;
        box-sizing: border-box;
        border: 1px solid #d1d3e2;
        border-radius: 8px;
        font-size: 12px;
        font-family: 'Poppins', sans-serif;
        padding: 0 12px;
    }
</style>

<div class="siapde-container-full">
    {{-- HEADER BARU: SEJAJAR LOGO --}}
    <div class="header-siapde-paten">
        <h4>DAFTAR PENGAJUAN SURAT LAYANAN</h4>
    </div>

    {{-- FILTER & ACTION BAR - RAPAT SIDEBAR (Padding-left: 15px) --}}
    <div style="background: #f8f9fc; padding: 20px 15px; border-bottom: 1px solid #eaecf4; margin-bottom: 20px;">
        <div style="display: flex; justify-content: space-between; align-items: flex-end; gap: 20px;">
            <form action="{{ route('surat.index') }}" method="GET" style="display: flex; gap: 12px; flex: 1; align-items: flex-end;">
                <div style="flex: 1;">
                    <label style="display: block; font-size: 10px; font-weight: 800; color: #4e73df; text-transform: uppercase; margin-bottom: 6px;">Tgl Mulai</label>
                    <input type="date" name="tgl_mulai" value="{{ request('tgl_mulai') }}" class="filter-item" style="width: 100%;">
                </div>
                <div style="flex: 1;">
                    <label style="display: block; font-size: 10px; font-weight: 800; color: #4e73df; text-transform: uppercase; margin-bottom: 6px;">Tgl Selesai</label>
                    <input type="date" name="tgl_selesai" value="{{ request('tgl_selesai') }}" class="filter-item" style="width: 100%;">
                </div>
                <div style="flex: 1.5;">
                    <label style="display: block; font-size: 10px; font-weight: 800; color: #4e73df; text-transform: uppercase; margin-bottom: 6px;">Jenis Surat</label>
                    <select name="jenis_surat" class="filter-item" style="width: 100%; background: white;">
                        <option value="">-- Semua Jenis --</option>
                        @foreach($daftar_surat as $key => $value)
                        <option value="{{ $value }}" {{ request('jenis_surat') == $value ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" style="background: #4e73df; color: white; border: none; padding: 0 20px; border-radius: 8px; font-weight: 700; font-size: 11px; cursor: pointer; height: 38px;">FILTER</button>
                <a href="{{ route('surat.index') }}" style="background: #eaecf4; color: #5a5c69; padding: 0 20px; border-radius: 8px; font-weight: 700; font-size: 11px; text-decoration: none; height: 38px; display: inline-flex; align-items: center;">RESET</a>
            </form>
            <a href="{{ route('surat.create') }}" style="background: #1cc88a; color: white; padding: 0 25px; border-radius: 50px; font-weight: 700; font-size: 11px; text-decoration: none; box-shadow: 0 4px 10px rgba(28, 200, 138, 0.2); height: 38px; display: inline-flex; align-items: center;">
                <i class="fas fa-plus-circle" style="margin-right: 6px;"></i> TAMBAH SURAT
            </a>
        </div>
    </div>

    {{-- TABEL AREA - RAPAT SIDEBAR (Padding-left: 0, Padding-right: 15px) --}}
    <div style="padding: 0 15px 40px 0;">
        <div style="background: white; border-radius: 0 12px 12px 0; border: 1px solid #eaecf4; border-left: none; overflow: hidden;">
            <table class="table-paten">
                <thead>
                    <tr style="background: #f8f9fc;">
                        <th style="width: 5%; text-align: center; border-bottom: 2px solid #4e73df;">NO</th>
                        <th style="width: 15%; text-align: center; border-bottom: 2px solid #4e73df;">NIK</th>
                        <th style="width: 27%; text-align: left; border-bottom: 2px solid #4e73df;">NAMA PENDUDUK</th>
                        <th style="width: 23%; text-align: left; border-bottom: 2px solid #4e73df;">JENIS SURAT</th>
                        <th style="width: 10%; text-align: center; border-bottom: 2px solid #4e73df;">TGL AJU</th>
                        <th style="width: 10%; text-align: center; border-bottom: 2px solid #4e73df;">STATUS</th>
                        <th style="width: 10%; text-align: center; border-bottom: 2px solid #4e73df;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($surats as $index => $s)
                    <tr onmouseover="this.style.backgroundColor='#f8f9fc'" onmouseout="this.style.backgroundColor='transparent'">
                        <td align="center" style="font-weight: 700; color: #b7b9cc; font-size: 12px;">{{ $index + 1 }}</td>
                        <td align="center"><span class="nik-styling">{{ $s->penduduk->nik ?? '-' }}</span></td>
                        <td style="text-align: left;"><span class="nama-styling">{{ $s->penduduk->nama }}</span></td>
                        <td style="text-align: left;"><span class="jenis-styling">{{ $s->jenis_surat }}</span></td>
                        <td align="center">
                            <div style="font-weight: 600; color: #5a5c69; font-size: 12.5px;">{{ \Carbon\Carbon::parse($s->tanggal_pengajuan)->format('d/m/Y') }}</div>
                        </td>
                        <td align="center">
                            <span style="padding: 6px 12px; border-radius: 6px; font-size: 9.5px; font-weight: 800; display: inline-block; {{ $s->status == 'disetujui' ? 'background: #d1fae5; color: #065f46;' : ($s->status == 'ditolak' ? 'background: #fee2e2; color: #991b1b;' : 'background: #fff3cd; color: #856404;') }}">
                                {{ strtoupper($s->status) }}
                            </span>
                        </td>
                        <td align="center">
                            <div style="display: flex; gap: 5px; justify-content: center;">
                                <a href="{{ route('surat.cetak', $s->id_surat) }}" class="btn-square-custom" style="background: #36b9cc;" title="Cetak"><i class="fas fa-print"></i></a>
                                <a href="{{ route('surat.edit', $s->id_surat) }}" class="btn-square-custom" style="background: #f6c23e;" title="Edit"><i class="fas fa-edit"></i></a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" align="center" style="padding: 100px; color: #b7b9cc; font-weight: 600;">Belum ada pengajuan ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection