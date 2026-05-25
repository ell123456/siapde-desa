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
        font-weight: 800;
        font-size: 13.5px;
        color: var(--sidebar-primary);
        text-transform: uppercase;
        white-space: normal;
        line-height: 1.4;
        display: block;
    }

    .nik-styling {
        color: var(--sidebar-accent);
        font-weight: 700;
        font-family: 'Consolas', monospace;
        font-size: 14px;
        letter-spacing: 0.5px;
    }

    .btn-verify-modern {
        padding: 8px 18px;
        border-radius: 50px;
        color: white;
        font-weight: 800;
        font-size: 10.5px;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
        transition: 0.2s;
        text-decoration: none;
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.05);
    }

    .btn-verify-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.15);
        color: white;
    }
</style>

<div class="siapde-container-full">
    <div class="header-siapde-paten">
        <h4>VERIFIKASI & PERSETUJUAN SURAT</h4>
    </div>

    {{-- INFO BAR --}}
    <div style="background: #f8f9fc; padding: 15px 20px; border-bottom: 1px solid #eaecf4; display: flex; justify-content: space-between; align-items: center; box-sizing: border-box;">
        <div style="color: #858796; font-size: 13px; font-weight: 700;">
            <i class="fas fa-exclamation-circle" style="color: #f6c23e;"></i> Segera tinjau permohonan warga agar layanan tetap cepat.
        </div>
        <div style="background: white; color: var(--sidebar-primary); padding: 8px 20px; border-radius: 50px; border: 1px solid #d1d3e2; font-weight: 800; font-size: 11.5px;">
            TOTAL: {{ $surats->count() }} ANTREAN
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
                        <th class="fit-column" style="text-align: center;">TGL MASUK</th>
                        <th class="fit-column" style="text-align: center;">KEPUTUSAN</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($surats as $key => $item)
                    <tr onmouseover="this.style.backgroundColor='#f8f9fc'" onmouseout="this.style.backgroundColor='transparent'">
                        <td class="fit-column" align="center" style="font-weight: 700; color: #b7b9cc; font-size: 13px;">{{ $key + 1 }}</td>
                        <td class="fit-column" align="center"><span class="nik-styling">{{ $item->penduduk->nik ?? '-' }}</span></td>
                        <td style="text-align: left;">
                            <span class="nama-styling">{{ $item->penduduk->nama ?? 'DATA TIDAK DITEMUKAN' }}</span>
                        </td>
                        <td style="text-align: left;">
                            <div style="font-weight: 700; color: var(--sidebar-accent); font-size: 13px; line-height: 1.4;">{{ $item->jenis_surat }}</div>
                        </td>
                        <td class="fit-column" align="center">
                            <div style="font-weight: 700; color: #5a5c69; font-size: 13px;">
                                {{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}
                            </div>
                        </td>
                        <td class="fit-column" align="center">
                            <div style="display: flex; gap: 8px; justify-content: center;">
                                <form action="{{ route('surat.setujui', $item->id_surat) }}" method="POST" onsubmit="return confirm('Setujui permohonan ini?')">
                                    @csrf
                                    <button type="submit" class="btn-verify-modern" style="background: #1cc88a;">
                                        <i class="fas fa-check-circle"></i> SETUJU
                                    </button>
                                </form>
                                <form action="{{ route('surat.tolak', $item->id_surat) }}" method="POST" onsubmit="return confirm('Tolak permohonan ini?')">
                                    @csrf
                                    <button type="submit" class="btn-verify-modern" style="background: #e74a3b;">
                                        <i class="fas fa-times-circle"></i> TOLAK
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" align="center" style="padding: 120px 0; color: #b7b9cc;">
                            <div style="margin-bottom: 20px;">
                                <i class="fas fa-check-double fa-4x" style="color: #dddfeb; opacity: 0.8;"></i>
                            </div>
                            <h5 style="font-weight: 800; color: #5a5c69; margin: 0 0 5px 0; font-size: 15px;">Semua Pekerjaan Selesai!</h5>
                            <p style="font-size: 12.5px; color: #b7b9cc; margin: 0; font-weight: 600;">Tidak ada antrean permohonan surat masuk untuk saat ini.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection