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
    }

    .nik-styling {
        color: var(--sidebar-accent);
        font-weight: 700;
        font-family: 'Consolas', monospace;
        font-size: 14px;
        letter-spacing: 0.5px;
    }

    .no-surat-styling {
        color: var(--sidebar-primary);
        font-weight: 700;
        font-size: 12.5px;
        background: var(--sidebar-accent-light);
        padding: 4px 10px;
        border-radius: 6px;
        display: inline-block;
        border: 1px solid rgba(46, 134, 193, 0.2);
    }

    .saring-select-kustom {
        height: 34px;
        padding: 0 12px;
        font-size: 11px;
        font-weight: 800;
        color: var(--sidebar-primary);
        border: 1px solid #d1d3e2;
        border-radius: 6px;
        background: white;
        outline: none;
        cursor: pointer;
        font-family: 'Poppins', sans-serif;
    }

    .saring-select-kustom:focus {
        border-color: var(--sidebar-accent);
    }

    /* CSS TAMBAHAN UNTUK LIST BERKAS DI ARSIP */
    .berkas-item {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 11px;
        font-weight: 600;
        padding: 3px 0;
        color: #374151;
    }

    .berkas-item i {
        font-size: 10px;
        flex-shrink: 0;
    }

    .berkas-link {
        color: var(--sidebar-accent);
        text-decoration: none;
        font-weight: 700;
        transition: 0.2s;
        cursor: pointer;
    }

    .berkas-link:hover {
        color: var(--sidebar-primary);
        text-decoration: underline;
    }

    .keterangan-box {
        min-width: 180px;
    }

    /* POPUP INTERNAL MODAL STYLE PREVIEW ARSIP */
    .siapde-modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(30, 41, 59, 0.6);
        backdrop-filter: blur(4px);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .siapde-modal-card {
        background: white;
        border-radius: 16px;
        width: 100%;
        max-width: 850px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.15);
        display: flex;
        flex-direction: column;
        max-height: 85vh;
        animation: modalSwoosh 0.25s ease-out;
        overflow: hidden;
    }

    @keyframes modalSwoosh {
        from {
            transform: translateY(15px);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .siapde-modal-header {
        background: #f8f9fc;
        padding: 16px 24px;
        border-bottom: 1px solid #eaecf4;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .siapde-modal-body {
        padding: 24px;
        overflow-y: auto;
        background: #f4f7fe;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 350px;
    }

    .siapde-modal-footer {
        background: #f8f9fc;
        padding: 14px 24px;
        border-top: 1px solid #eaecf4;
        display: flex;
        justify-content: flex-end;
    }
</style>

<div class="siapde-container-full">

    @php
    $bulanIndo = [
    '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
    '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
    '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
    ];

    // DETAIL SAKTI: Saring ulang di view untuk memastikan HANYA status 'selesai' yang lolos tampil
    $arsipSah = $surats->filter(function($item) {
    return strtolower($item->status) == 'selesai';
    });
    @endphp

    <div class="header-siapde-paten">
        <h4>ARSIP SURAT</h4>
    </div>

    {{-- ACTION BAR --}}
    <div style="background: #f8f9fc; padding: 15px 20px; border-bottom: 1px solid #eaecf4; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
        <div style="display: flex; align-items: center; gap: 15px;">
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
                <i class="fas fa-info-circle" style="color: var(--sidebar-accent);"></i> Menampilkan dokumen administrasi warga yang telah selesai diproses cetak dokumen.
            </div>
        </div>
        <div style="background: white; color: var(--sidebar-primary); padding: 8px 18px; border-radius: 50px; border: 1px solid #d1d3e2; font-weight: 800; font-size: 11.5px; display: flex; align-items: center; gap: 8px;">
            <i class="fas fa-file-invoice"></i> TOTAL: {{ $arsipSah->count() }} DOKUMEN
        </div>
    </div>

    {{-- TABEL --}}
    <div style="padding: 0 0 40px 0;">
        <div style="background: white; border-top: 1px solid #eaecf4; border-bottom: 1px solid #eaecf4; overflow: hidden;">
            <table class="table-paten">
                <thead>
                    <tr>
                        <th class="fit-column" style="text-align: center;">NO</th>
                        <th class="fit-column" style="text-align: center;">NOMOR SURAT</th>
                        <th class="fit-column" style="text-align: center;">NIK</th>
                        <th style="text-align: left; width: 22%;">NAMA PENDUDUK</th>
                        <th style="text-align: left; width: 18%;">JENIS SURAT</th>
                        <th style="text-align: left; width: 18%;">BERKAS PENDUKUNG</th> {{-- KOLOM BARU --}}
                        <th class="fit-column" style="text-align: center;">STATUS</th>
                        <th class="fit-column" style="text-align: left;">TGL PROSES</th>
                        <th class="fit-column" style="text-align: center;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($arsipSah as $item)
                    <tr class="baris-arsip-data" data-jenis="{{ $item->jenis_surat }}" onmouseover="this.style.backgroundColor='#f8f9fc'" onmouseout="this.style.backgroundColor='transparent'">
                        <td class="fit-column" align="center" style="font-weight: 700; color: #b7b9cc; font-size: 13px;">{{ $loop->iteration }}</td>
                        <td class="fit-column" align="center">
                            <span class="no-surat-styling">
                                {{ $item->nomor_surat ?? '140 / ' . str_pad($item->id_surat, 3, '0', STR_PAD_LEFT) . ' / ' . \Carbon\Carbon::parse($item->created_at)->format('Y') }}
                            </span>
                        </td>
                        <td class="fit-column" align="center">
                            <span class="nik-styling">{{ $item->penduduk->nik ?? '-' }}</span>
                        </td>
                        <td style="text-align: left;">
                            <span class="nama-styling">{{ $item->penduduk->nama ?? 'DATA TIDAK DITEMUKAN' }}</span>
                        </td>
                        <td style="text-align: left;">
                            <span class="jenis-styling">{{ $item->jenis_surat }}</span>
                        </td>

                        {{-- VALUE KOLOM BARU: MEMBACA BERKAS JSON LALU DIIKAT KE POPUP MODAL --}}
                        <td>
                            <div class="keterangan-box">
                                @php
                                $berkas = $item->berkas ?? [];
                                if (is_string($berkas)) {
                                $berkas = json_decode($berkas, true) ?? [];
                                }
                                @endphp

                                @if(count($berkas) > 0)
                                @foreach($berkas as $b)
                                @php
                                $namaberkas = is_array($b) ? ($b['nama'] ?? $b['name'] ?? '-') : $b->nama ?? '-';
                                $filename = is_array($b) ? ($b['file'] ?? '') : $b->file ?? '';
                                @endphp
                                <div class="berkas-item">
                                    <i class="fas fa-file-alt" style="font-size: 11px; color: #4e73df;"></i>
                                    @if(!empty($filename))
                                    <a href="javascript:void(0)" class="berkas-link" onclick="bukaModalPreview('{{ asset('uploads/berkas/' . $filename) }}', '{{ $namaberkas }}', '{{ $item->penduduk->nama ?? '-' }}', '{{ $item->jenis_surat }}')">
                                        {{ $loop->iteration }}. {{ $namaberkas }} <i class="fas fa-eye" style="font-size: 9px; color: #94a3b8; margin-left: 1px;"></i>
                                    </a>
                                    @else
                                    <span style="color: #858796;">{{ $loop->iteration }}. {{ $namaberkas }}</span>
                                    @endif
                                </div>
                                @endforeach
                                @else
                                <span style="font-size: 11px; color: #b7b9cc; font-weight: 600;">
                                    <i class="fas fa-minus" style="margin-right: 4px;"></i> Tidak ada berkas
                                </span>
                                @endif
                            </div>
                        </td>

                        <td class="fit-column" align="center">
                            <span style="padding: 6px 14px; border-radius: 6px; font-size: 10px; font-weight: 800; display: inline-block; background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd;">
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
                            <a href="{{ route('surat.cetak', $item->id_surat) }}" target="_blank" style="background: var(--sidebar-accent); color: white; width: 34px; height: 34px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; transition: 0.2s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'" title="Cetak Surat">
                                <i class="fas fa-file-pdf" style="font-size: 14px;"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" align="center" style="padding: 120px 0; color: #b7b9cc;">
                            <div style="margin-bottom: 20px;">
                                <i class="fas fa-archive fa-4x" style="color: #dddfeb; opacity: 0.8;"></i>
                            </div>
                            <h5 style="font-weight: 800; color: #5a5c69; margin: 0 0 5px 0; font-size: 15px;">Arsip Kosong</h5>
                            <p style="font-size: 12.5px; color: #b7b9cc; margin: 0; font-weight: 600;">Belum ada dokumen administrasi yang berstatus SELESAI dicetak.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- MODAL INTERNAL PREVIEW FILE ARSIP --}}
<div class="siapde-modal-overlay" id="popupPreviewArsip">
    <div class="siapde-modal-card">
        <div class="siapde-modal-header">
            <div>
                <h5 id="modalTitleBerkas" style="margin: 0; font-weight: 800; color: var(--sidebar-primary); text-transform: uppercase; font-size: 15px; letter-spacing: 0.5px;">PREVIEW BERKAS ARSIP</h5>
                <p id="modalSubTitleSurat" style="margin: 4px 0 0 0; font-size: 11.5px; color: #858796; font-weight: 600; text-transform: uppercase;"></p>
            </div>
            <button type="button" onclick="tutupModalPreview()" style="background: none; border: none; font-size: 20px; color: #b7b9cc; cursor: pointer;"><i class="fas fa-times"></i></button>
        </div>
        <div class="siapde-modal-body" id="modalBodyContent">
            {{-- Konten Gambar / PDF disuntik lewat Javascript --}}
        </div>
        <div class="siapde-modal-footer">
            <button type="button" onclick="tutupModalPreview()" style="background: #6e707e; color: white; border: none; padding: 8px 20px; border-radius: 6px; font-weight: 700; font-size: 12px; cursor: pointer;">TUTUP PREVIEW</button>
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
                if (filterValue === "" || jenisSurat.includes(filterValue) || filterValue.includes(jenisSurat)) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        });
    });

    // FUNGSI JAVASCRIPT POPUP PREVIEW ARSIP INTERNAL
    function bukaModalPreview(fileUrl, namaBerkas, namaWarga, jenisSurat) {
        document.getElementById('modalTitleBerkas').textContent = "MELIHAT ARSIP: " + namaBerkas;
        document.getElementById('modalSubTitleSurat').textContent = "PEMOHON: " + namaWarga + " | JENIS: " + jenisSurat;

        const bodyContent = document.getElementById('modalBodyContent');
        bodyContent.innerHTML = '';

        const fileExtension = fileUrl.split('.').pop().toLowerCase();

        if (fileExtension === 'pdf') {
            bodyContent.innerHTML = `<iframe src="${fileUrl}" style="width: 100%; height: 530px; border: none; border-radius: 8px;"></iframe>`;
        } else {
            bodyContent.innerHTML = `<img src="${fileUrl}" style="max-width: 100%; max-height: 500px; object-fit: contain; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">`;
        }

        document.getElementById('popupPreviewArsip').style.display = 'flex';
    }

    function tutupModalPreview() {
        document.getElementById('popupPreviewArsip').style.display = 'none';
        document.getElementById('modalBodyContent').innerHTML = '';
    }
</script>
@endsection