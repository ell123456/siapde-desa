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
        min-width: 190px;
    }

    /* CUSTOM INTERNAL MODAL STYLING (BIAR GA BENTROK) */
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
                        <th style="text-align: center; width: 14%;">NIK</th>
                        <th style="text-align: left; width: 23%;">NAMA PENDUDUK</th>
                        <th style="text-align: left; width: 18%;">JENIS SURAT</th>
                        <th style="text-align: center; width: 11%;">TGL MASUK</th>
                        <th style="text-align: left; width: 19%;">BERKAS PENDUKUNG</th>
                        <th style="text-align: center; width: 15%;">KEPUTUSAN</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($surats as $key => $item)
                    <tr onmouseover="this.style.backgroundColor='#f8f9fc'" onmouseout="this.style.backgroundColor='transparent'">
                        <td class="fit-column" align="center" style="font-weight: 700; color: #b7b9cc; font-size: 13px;">{{ $key + 1 }}</td>
                        <td align="center"><span class="nik-styling">{{ $item->penduduk->nik ?? '-' }}</span></td>
                        <td style="text-align: left;">
                            <span class="nama-styling">{{ $item->penduduk->nama ?? 'DATA TIDAK DITEMUKAN' }}</span>
                        </td>
                        <td style="text-align: left;">
                            <div style="font-weight: 700; color: var(--sidebar-accent); font-size: 13px; line-height: 1.4;">{{ $item->jenis_surat }}</div>
                        </td>
                        <td align="center">
                            <div style="font-weight: 700; color: #5a5c69; font-size: 13px;">
                                {{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}
                            </div>
                        </td>

                        {{-- KOLOM BERKAS PENDUKUNG (POPUP MODAL TERINTEGRASI) --}}
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
                                    <i class="fas fa-file-alt text-primary" style="font-size: 11px;"></i>
                                    @if(!empty($filename))
                                    {{-- MEMANGGIL JAVASCRIPT UNTUK POPUP DAN MENGIKAT DATA INFO SURAT --}}
                                    <a href="javascript:void(0)" class="berkas-link" onclick="bukaModalPreview('{{ asset('uploads/berkas/' . $filename) }}', '{{ $namaberkas }}', '{{ $item->penduduk->nama ?? '-' }}', '{{ $item->jenis_surat }}')">
                                        {{ $loop->iteration }}. {{ $namaberkas }} <i class="fas fa-eye" style="font-size: 10px; margin-left: 2px; color: #4e73df;"></i>
                                    </a>
                                    @else
                                    <span style="color: #858796;">{{ $loop->iteration }}. {{ $namaberkas }}</span>
                                    @endif
                                </div>
                                @endforeach
                                @else
                                <span style="font-size: 11px; color: #b7b9cc; font-weight: 600;">
                                    <i class="fas fa-minus" style="margin-right: 4px;"></i> Tidak ada lampiran
                                </span>
                                @endif
                            </div>
                        </td>

                        <td align="center">
                            <div style="display: flex; gap: 8px; justify-content: center;">
                                <form action="{{ route('surat.setujui', $item->id_surat) }}" method="POST" onsubmit="return confirm('Setujui permohonan ini?')">
                                    @csrf
                                    <button type="submit" class="btn-verify-modern" style="background: #1cc88a;">
                                        <i class="fas fa-check-circle"></i> SETUJU
                                    </button>
                                </form>

                                <form id="form_tolak_{{ $item->id_surat }}" action="{{ route('surat.tolak', $item->id_surat) }}" method="POST" onsubmit="return konfirmasiTolak(event, '{{ $item->id_surat }}')">
                                    @csrf
                                    <input type="hidden" name="keterangan" id="keterangan_val_{{ $item->id_surat }}">
                                    <button type="submit" class="btn-verify-modern" style="background: #e74a3b;">
                                        <i class="fas fa-times-circle"></i> TOLAK
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" align="center" style="padding: 120px 0; color: #b7b9cc;">
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

{{-- WINDOW POPUP PREVIEW BERKAS INTERNAL --}}
<div class="siapde-modal-overlay" id="popupPreviewBerkas">
    <div class="siapde-modal-card">
        <div class="siapde-modal-header">
            <div>
                <h5 id="modalTitleBerkas" style="margin: 0; font-weight: 800; color: var(--sidebar-primary); text-transform: uppercase; font-size: 15px; letter-spacing: 0.5px;">PREVIEW BERKAS</h5>
                <p id="modalSubTitleSurat" style="margin: 4px 0 0 0; font-size: 11.5px; color: #858796; font-weight: 600; text-transform: uppercase;"></p>
            </div>
            <button type="button" onclick="tutupModalPreview()" style="background: none; border: none; font-size: 20px; color: #b7b9cc; cursor: pointer;"><i class="fas fa-times"></i></button>
        </div>
        <div class="siapde-modal-body" id="modalBodyContent">
            {{-- Konten Gambar / Iframe PDF disuntik lewat Javascript di bawah --}}
        </div>
        <div class="siapde-modal-footer">
            <button type="button" onclick="tutupModalPreview()" style="background: #6e707e; color: white; border: none; padding: 8px 20px; border-radius: 6px; font-weight: 700; font-size: 12px; cursor: pointer;">TUTUP PREVIEW</button>
        </div>
    </div>
</div>

<script>
    // FUNGSI JAVASCRIPT UNTUK MEMBUKA POPUP INTERNAL PREVIEW BERKAS
    function bukaModalPreview(fileUrl, namaBerkas, namaWarga, jenisSurat) {
        // 1. Pasang Teks Info Surat Biar Kepala Desa Gak Bingung Data Milik Siapa
        document.getElementById('modalTitleBerkas').textContent = "MELIHAT: " + namaBerkas;
        document.getElementById('modalSubTitleSurat').textContent = "PEMOHON: " + namaWarga + " | JENIS: " + jenisSurat;

        const bodyContent = document.getElementById('modalBodyContent');
        bodyContent.innerHTML = ''; // Kosongkan preview sebelumnya

        // 2. Deteksi otomatis Ekstensi File
        const fileExtension = fileUrl.split('.').pop().toLowerCase();

        if (fileExtension === 'pdf') {
            // Jika PDF tampilkan menggunakan iframe embed internal
            bodyContent.innerHTML = `<iframe src="${fileUrl}" style="width: 100%; height: 550px; border: none; border-radius: 8px;"></iframe>`;
        } else {
            // Jika Gambar/Foto tampilkan menggunakan tag Image responsif
            bodyContent.innerHTML = `<img src="${fileUrl}" style="max-width: 100%; max-height: 520px; object-fit: contain; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">`;
        }

        // 3. Tampilkan Pop Up ke layar utama
        document.getElementById('popupPreviewBerkas').style.display = 'flex';
    }

    // FUNGSI JAVASCRIPT UNTUK MENUTUP POPUP
    function tutupModalPreview() {
        document.getElementById('popupPreviewBerkas').style.display = 'none';
        document.getElementById('modalBodyContent').innerHTML = '';
    }

    // FUNGSI INPUT ALASAN TOLAK
    function konfirmasiTolak(event, id) {
        event.preventDefault();
        let alasan = prompt("Masukkan alasan permohonan ditolak (Contoh: FOTO KK TIDAK ADA / KURANG):");
        if (alasan === null) return false;
        if (alasan.trim() === "") {
            alert("Gagal menolak! Anda harus mengisi alasan penolakan terlebih dahulu.");
            return false;
        }
        document.getElementById('keterangan_val_' + id).value = alasan.toUpperCase();
        document.getElementById('form_tolak_' + id).submit();
    }
</script>
@endsection