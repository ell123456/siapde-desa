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

    /* TABEL PADAT & RAPAT SIDEBAR */
    .table-paten {
        table-layout: fixed;
        width: 100%;
        border-collapse: collapse;
        background: white;
    }

    .table-paten th,
    .table-paten td {
        vertical-align: middle;
        padding: 18px 12px;
        border-bottom: 1px solid #f1f3f9;
        overflow: hidden;
    }

    .table-paten th {
        color: #4e73df;
        font-size: 11.5px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #4e73df;
    }

    /* KUNCI URUTAN & WIDTH */
    .col-nik {
        width: 18%;
        text-align: center;
    }

    .col-nama {
        width: 24%;
        text-align: left;
    }

    .nama-styling {
        font-weight: 800;
        font-size: 13px;
        color: #1e3a8a;
        text-transform: uppercase;
        white-space: normal;
        line-height: 1.4;
        display: block;
    }

    .nik-styling {
        color: #4e73df;
        font-weight: 700;
        font-family: 'Consolas', monospace;
        font-size: 14px;
        letter-spacing: 0.5px;
    }

    .btn-verify-modern {
        padding: 8px 16px;
        border-radius: 50px;
        color: white;
        font-weight: 800;
        font-size: 10px;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
        transition: 0.3s;
        text-decoration: none;
    }
</style>

<div class="siapde-container-full">
    {{-- HEADER BARU: SEJAJAR LOGO --}}
    <div class="header-siapde-paten">
        <h4>VERIFIKASI & PERSETUJUAN SURAT</h4>
    </div>

    {{-- INFO BAR - RAPAT SIDEBAR --}}
    <div style="background: #f8f9fc; padding: 15px; border-bottom: 1px solid #eaecf4; display: flex; justify-content: space-between; align-items: center; box-sizing: border-box;">
        <div style="color: #858796; font-size: 13px; font-weight: 700;">
            <i class="fas fa-exclamation-circle text-warning"></i> Segera tinjau permohonan warga agar layanan tetap cepat.
        </div>
        <div style="background: white; color: #4e73df; padding: 8px 20px; border-radius: 50px; border: 1px solid #d1d3e2; font-weight: 800; font-size: 12px;">
            TOTAL: {{ $surats->count() }} ANTREAN
        </div>
    </div>

    {{-- TABEL AREA - JARAK SIDEBAR DIHAPUS --}}
    <div class="table-responsive" style="padding: 0 15px 40px 0;">
        <div style="background: white; border-radius: 0 12px 12px 0; border: 1px solid #eaecf4; border-left: none; overflow: hidden;">
            <table class="table-paten">
                <thead>
                    <tr style="background: #f8f9fc;">
                        <th style="width: 6%; text-align: center;">NO</th>
                        <th class="col-nik">NIK</th>
                        <th class="col-nama">NAMA PENDUDUK</th>
                        <th style="width: 20%; text-align: left;">JENIS SURAT</th>
                        <th style="width: 14%; text-align: center;">TGL MASUK</th>
                        <th style="width: 18%; text-align: center;">KEPUTUSAN</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($surats as $key => $item)
                    <tr onmouseover="this.style.backgroundColor='#f8f9fc'" onmouseout="this.style.backgroundColor='transparent'">
                        <td align="center" style="font-weight: 700; color: #b7b9cc;">{{ $key + 1 }}</td>
                        <td align="center"><span class="nik-styling">{{ $item->penduduk->nik ?? '-' }}</span></td>
                        <td class="col-nama">
                            <span class="nama-styling">{{ $item->penduduk->nama ?? 'N/A' }}</span>
                        </td>
                        <td>
                            <div style="font-weight: 700; color: #4e73df; font-size: 13px;">{{ $item->jenis_surat }}</div>
                        </td>
                        <td align="center">
                            <div style="font-weight: 700; color: #5a5c69; font-size: 12px;">{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</div>
                        </td>
                        <td align="center">
                            <div style="display: flex; gap: 8px; justify-content: center;">
                                {{-- FORM SETUJU --}}
                                <form action="{{ route('surat.setujui', $item->id_surat) }}" method="POST" onsubmit="return confirm('Setujui permohonan ini?')">
                                    @csrf
                                    <button type="submit" class="btn-verify-modern" style="background: #1cc88a;">
                                        <i class="fas fa-check-circle"></i> SETUJU
                                    </button>
                                </form>

                                {{-- FORM TOLAK --}}
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
                        <td colspan="6" align="center" style="padding: 120px; color: #b7b9cc; font-weight: 600;">
                            <i class="fas fa-check-double fa-3x mb-3" style="display: block; opacity: 0.3;"></i>
                            Tidak ada antrean surat untuk saat ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection