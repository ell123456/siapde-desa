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
        table-layout: fixed;
        width: 100%;
        border-collapse: collapse;
        background: white;
    }

    .table-paten th,
    .table-paten td {
        vertical-align: top;
        padding: 14px 10px;
        border-bottom: 1px solid #f1f3f9;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }

    .table-paten th {
        color: var(--sidebar-primary);
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        background: #f8f9fc;
        border-bottom: 2px solid var(--sidebar-accent);
        vertical-align: middle;
        white-space: nowrap;
    }

    .table-paten th:first-child,
    .table-paten td:first-child {
        padding-left: 16px !important;
    }

    .table-paten th:last-child,
    .table-paten td:last-child {
        padding-right: 16px !important;
    }

    .nama-styling {
        font-weight: 700;
        font-size: 12.5px;
        color: var(--sidebar-primary);
        text-transform: uppercase;
        line-height: 1.4;
        display: block;
    }

    .jenis-styling {
        font-weight: 700;
        font-size: 11.5px;
        color: var(--sidebar-accent);
        line-height: 1.4;
    }

    .nik-styling {
        color: var(--sidebar-accent);
        font-weight: 700;
        font-family: 'Consolas', monospace;
        font-size: 12px;
        letter-spacing: 0.3px;
    }

    .btn-square-custom {
        width: 30px;
        height: 30px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: white;
        border: none;
        transition: 0.2s;
        text-decoration: none;
        font-size: 12px;
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
        padding: 0 10px;
        outline: none;
    }

    .berkas-item {
        display: flex;
        align-items: flex-start;
        gap: 5px;
        font-size: 12px;
        font-weight: 600;
        padding: 3px 0;
        color: #374151;
        line-height: 1.4;
    }

    .berkas-item i {
        font-size: 10px;
        flex-shrink: 0;
        margin-top: 2px;
    }

    .berkas-valid {
        color: #065f46;
    }

    .berkas-invalid {
        color: #991b1b;
    }

    .berkas-pending {
        color: #856404;
    }

    .keterangan-label {
        font-size: 9.5px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 6px;
        color: var(--sidebar-primary);
        background: #f0f4ff;
        padding: 3px 7px;
        border-radius: 4px;
        display: inline-block;
        border: 1px solid #e0e7ff;
    }

    /* MODAL REVIEW - SAMA DENGAN ARSIP */
    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.6);
        z-index: 9999;
        display: none;
        justify-content: center;
        align-items: center;
        backdrop-filter: blur(4px);
    }

    .modal-box {
        background: white;
        width: 780px;
        max-width: 95vw;
        height: 90vh;
        max-height: 90vh;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.35);
        display: flex;
        flex-direction: column;
        animation: fadeUp 0.25s ease;
    }

    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

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

    .modal-footer button {
        background: var(--sidebar-primary);
        color: white;
        border: none;
        padding: 8px 20px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 12px;
        cursor: pointer;
        font-family: 'Poppins', sans-serif;
        transition: 0.2s;
    }

    .modal-footer button:hover {
        background: var(--sidebar-accent);
    }
</style>

<div class="siapde-container-full">
    <div class="header-siapde-paten">
        <h4>DAFTAR PENGAJUAN SURAT LAYANAN</h4>
    </div>

    {{-- FILTER --}}
    <div style="background: #f8f9fc; padding: 18px 20px; border-bottom: 1px solid #eaecf4; margin-bottom: 20px;">
        <div style="display: flex; justify-content: space-between; align-items: flex-end; gap: 16px; flex-wrap: wrap;">
            <form action="{{ route('surat.index') }}" method="GET" style="display: flex; gap: 10px; flex: 1; align-items: flex-end; flex-wrap: wrap;">
                <div>
                    <label style="display: block; font-size: 10px; font-weight: 800; color: var(--sidebar-primary); text-transform: uppercase; margin-bottom: 5px; letter-spacing: 0.5px;">Tgl Mulai</label>
                    <input type="date" name="tgl_mulai" value="{{ request('tgl_mulai') }}" class="filter-item" style="width: 140px;">
                </div>
                <div>
                    <label style="display: block; font-size: 10px; font-weight: 800; color: var(--sidebar-primary); text-transform: uppercase; margin-bottom: 5px; letter-spacing: 0.5px;">Tgl Selesai</label>
                    <input type="date" name="tgl_selesai" value="{{ request('tgl_selesai') }}" class="filter-item" style="width: 140px;">
                </div>
                <div style="min-width: 200px; flex: 1;">
                    <label style="display: block; font-size: 10px; font-weight: 800; color: var(--sidebar-primary); text-transform: uppercase; margin-bottom: 5px; letter-spacing: 0.5px;">Jenis Surat</label>
                    <select name="jenis_surat" class="filter-item" style="width: 100%; background: white;">
                        <option value="">-- Semua Jenis --</option>
                        @foreach($daftar_surat as $key => $value)
                        <option value="{{ $key }}" {{ request('jenis_surat') == $key ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="display: flex; gap: 6px;">
                    <button type="submit" style="background: var(--sidebar-primary); color: white; border: none; padding: 0 18px; border-radius: 8px; font-weight: 800; font-size: 11px; cursor: pointer; height: 38px; font-family: 'Poppins', sans-serif;">
                        <i class="fas fa-filter mr-1"></i> FILTER
                    </button>
                    <a href="{{ route('surat.index') }}" style="background: #eaecf4; color: #5a5c69; padding: 0 18px; border-radius: 8px; font-weight: 800; font-size: 11px; text-decoration: none; height: 38px; display: inline-flex; align-items: center;">
                        RESET
                    </a>
                </div>
            </form>

            <a href="{{ route('surat.create') }}" style="background: var(--sidebar-accent); color: white; padding: 0 20px; border-radius: 50px; font-weight: 800; font-size: 11px; text-decoration: none; box-shadow: 0 4px 12px rgba(46,134,193,0.25); height: 38px; display: inline-flex; align-items: center; transition: 0.2s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                <i class="fas fa-plus-circle" style="margin-right: 7px;"></i> TAMBAH SURAT
            </a>
        </div>
    </div>

    {{-- TABEL --}}
    <div style="padding: 0 0 40px 0; overflow-x: auto;">
        <div style="background: white; border-top: 1px solid #eaecf4; border-bottom: 1px solid #eaecf4;">
            <table class="table-paten">
                <thead>
                    <tr>
                        <th style="text-align:center; width:3%;">NO</th>
                        <th style="text-align:center; width:12%;">NIK</th>
                        <th style="text-align:left; width:17%;">NAMA PENDUDUK</th>
                        <th style="text-align:left; width:15%;">JENIS SURAT</th>
                        <th style="text-align:center; width:13%;">DIAJUKAN</th>
                        <th style="text-align:left; width:17%;">BERKAS PENDUKUNG</th>
                        <th style="text-align:center; width:10%;">STATUS</th>
                        <th style="text-align:center; width:12%;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($surats as $index => $s)
                    <tr onmouseover="this.style.backgroundColor='#f8f9fc'" onmouseout="this.style.backgroundColor='transparent'">

                        {{-- NO --}}
                        <td align="center" style="font-weight: 700; color: #b7b9cc; font-size: 12px; vertical-align: middle;">{{ $index + 1 }}</td>

                        {{-- NIK --}}
                        <td align="center" style="vertical-align: middle;">
                            <span class="nik-styling">{{ $s->penduduk->nik ?? '-' }}</span>
                        </td>

                        {{-- NAMA --}}
                        <td style="vertical-align: middle;">
                            <span class="nama-styling">{{ $s->penduduk->nama ?? 'DATA TIDAK DITEMUKAN' }}</span>
                        </td>

                        {{-- JENIS SURAT --}}
                        <td style="vertical-align: middle;">
                            <span class="jenis-styling">{{ $s->jenis_surat }}</span>
                        </td>

                        {{-- TGL DIAJUKAN --}}
                        <td align="center" style="vertical-align: middle;">
                            <div style="font-weight: 700; color: #5a5c69; font-size: 11.5px;">
                                {{ \Carbon\Carbon::parse($s->tanggal_pengajuan ?? $s->created_at)->format('d/m/Y') }}
                            </div>
                        </td>

                        {{-- BERKAS --}}
                        <td style="vertical-align: top;">
                            @php
                            $berkas = $s->berkas ?? [];
                            if (is_string($berkas)) $berkas = json_decode($berkas, true) ?? [];
                            if (empty($berkas)) {
                            if (!empty($s->foto_kk)) $berkas[] = ['nama' => 'Foto KK', 'status' => 'valid', 'file' => $s->foto_kk];
                            if (!empty($s->foto_ktp)) $berkas[] = ['nama' => 'Foto KTP', 'status' => 'valid', 'file' => $s->foto_ktp];
                            if (!empty($s->surat_pengantar))$berkas[] = ['nama' => 'Surat Pengantar RT/RW','status' => 'valid', 'file' => $s->surat_pengantar];
                            if (!empty($s->akta_kelahiran)) $berkas[] = ['nama' => 'Akta Kelahiran', 'status' => 'valid', 'file' => $s->akta_kelahiran];
                            if (!empty($s->surat_nik)) $berkas[] = ['nama' => 'Surat Nikah/Cerai', 'status' => 'valid', 'file' => $s->surat_nik];
                            if (!empty($s->berkas_lainnya)) $berkas[] = ['nama' => 'Berkas Lainnya', 'status' => 'valid', 'file' => $s->berkas_lainnya];
                            }
                            @endphp

                            @if(count($berkas) > 0)
                            <div class="keterangan-label"><i class="fas fa-paperclip" style="margin-right: 3px;"></i>Lampiran</div>
                            @foreach($berkas as $idx => $b)
                            @php
                            $namaberkas = is_array($b) ? ($b['nama'] ?? $b['name'] ?? '-') : ($b->nama ?? '-');
                            $statusberkas = strtolower(is_array($b) ? ($b['status'] ?? '') : ($b->status ?? ''));
                            $namafile = is_array($b) ? ($b['file'] ?? '') : ($b->file ?? '');
                            $isValid = in_array($statusberkas, ['valid','lengkap']);
                            $isInvalid = in_array($statusberkas, ['tidak valid','tidak lengkap','ditolak']);
                            $warna = $isValid ? 'berkas-valid' : ($isInvalid ? 'berkas-invalid' : 'berkas-pending');
                            $icon = $isValid ? 'fa-check-circle berkas-valid' : ($isInvalid ? 'fa-times-circle berkas-invalid' : 'fa-clock berkas-pending');
                            @endphp
                            <div class="berkas-item">
                                <i class="fas {{ $icon }}"></i>
                                @if(!empty($namafile))
                                <a href="javascript:void(0)"
                                    onclick="bukaReview('{{ asset('uploads/berkas/'.$namafile) }}','{{ $namaberkas }}','{{ $s->penduduk->nama ?? '' }}','{{ $s->jenis_surat }}')"
                                    class="{{ $warna }}"
                                    style="text-decoration:none; cursor:pointer; font-size:12px; font-weight:700;"
                                    title="Klik untuk preview">
                                    {{ $idx+1 }}. {{ $namaberkas }} <i class="fas fa-eye" style="font-size:10px; opacity:0.7;"></i>
                                </a>
                                @else
                                <span class="{{ $warna }}">{{ $idx+1 }}. {{ $namaberkas }}</span>
                                @endif
                            </div>
                            @endforeach
                            @else
                            <span style="font-size: 11px; color: #b7b9cc; font-weight: 600;">
                                <i class="fas fa-minus" style="margin-right: 3px;"></i>Belum ada berkas
                            </span>
                            @endif
                        </td>

                        {{-- STATUS --}}
                        <td align="center" style="vertical-align: middle;">
                            @php
                            $st = strtolower($s->status);
                            $stStyle = $st=='disetujui' ? 'background:#d1fae5;color:#065f46;border:1px solid #a7f3d0;' :
                            ($st=='selesai' ? 'background:#e0f2fe;color:#0369a1;border:1px solid #bae6fd;' :
                            ($st=='ditolak' ? 'background:#fee2e2;color:#991b1b;border:1px solid #fecaca;' :
                            'background:#fff3cd;color:#856404;border:1px solid #ffeeba;'));
                            @endphp
                            <span style="padding:5px 8px; border-radius:6px; font-size:9.5px; font-weight:800; display:inline-block; {{ $stStyle }}">
                                {{ strtoupper($s->status) }}
                            </span>
                        </td>

                        {{-- AKSI --}}
                        <td align="center" style="vertical-align: middle;">
                            <div style="display: flex; flex-direction: column; gap: 5px; align-items: center;">
                                <div style="display: flex; gap: 5px; justify-content: center;">
                                    @if($st == 'disetujui')
                                    <a href="{{ route('surat.cetak', $s->id_surat) }}" target="_blank" class="btn-square-custom" style="background: var(--sidebar-accent);" title="Cetak" onclick="setTimeout(function(){ location.reload(); }, 1200);">
                                        <i class="fas fa-print"></i>
                                    </a>
                                    @endif
                                    @if(in_array($st, ['diajukan','disetujui','ditolak']))
                                    <a href="{{ route('surat.edit', $s->id_surat) }}" class="btn-square-custom" style="background: #f6c23e;" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @endif
                                    @if($st == 'selesai')
                                    <span class="btn-square-custom" style="background: #e2e8f0; color: #94a3b8; cursor: not-allowed;" title="Selesai">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    @endif
                                </div>
                                @if($st == 'ditolak')
                                <div style="color:#dc2626; font-weight:700; font-size:9.5px; text-align:center; background:#fee2e2; border:1px solid #fecaca; padding:3px 6px; border-radius:4px; max-width:110px; word-break:break-word; line-height:1.3;">
                                    <i class="fas fa-exclamation-circle"></i> {{ $s->keterangan ?? 'TIDAK LENGKAP' }}
                                </div>
                                @endif
                            </div>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" align="center" style="padding: 80px 0; color: #b7b9cc;">
                            <i class="fas fa-folder-open fa-3x" style="color: #dddfeb; margin-bottom: 12px; display: block;"></i>
                            <div style="font-weight: 800; color: #5a5c69; font-size: 14px; margin-bottom: 4px;">Data Tidak Ditemukan</div>
                            <div style="font-size: 12px; font-weight: 600;">Coba sesuaikan filter pencarian.</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- MODAL REVIEW BERKAS --}}
{{-- MODAL REVIEW BERKAS --}}
<div class="siapde-modal-overlay" id="popupPreviewArsip">
    <div class="siapde-modal-card">
        <div class="siapde-modal-header">
            <div>
                <h5 id="modalTitleBerkas" style="margin: 0; font-weight: 800; color: var(--sidebar-primary); text-transform: uppercase; font-size: 15px; letter-spacing: 0.5px;">PREVIEW BERKAS</h5>
                <p id="modalSubTitleSurat" style="margin: 4px 0 0 0; font-size: 11.5px; color: #858796; font-weight: 600; text-transform: uppercase;"></p>
            </div>
            <button type="button" onclick="tutupModalPreview()" style="background: none; border: none; font-size: 20px; color: #b7b9cc; cursor: pointer;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="siapde-modal-body" id="modalBodyContent">
        </div>
        <div class="siapde-modal-footer">
            <button type="button" onclick="tutupModalPreview()" style="background: #6e707e; color: white; border: none; padding: 8px 20px; border-radius: 6px; font-weight: 700; font-size: 12px; cursor: pointer; font-family: 'Poppins', sans-serif;">
                TUTUP PREVIEW
            </button>
        </div>
    </div>
</div>

<script>
    function bukaReview(url, namaBerkas, namaPemohon, jenisSurat) {
        document.getElementById('modalTitleBerkas').textContent = 'MELIHAT ARSIP: ' + namaBerkas.toUpperCase();
        document.getElementById('modalSubTitleSurat').textContent = 'PEMOHON: ' + namaPemohon.toUpperCase() + ' | JENIS: ' + jenisSurat.toUpperCase();

        const body = document.getElementById('modalBodyContent');
        body.innerHTML = '';

        const ext = url.split('.').pop().toLowerCase();
        if (ext === 'pdf') {
            body.innerHTML = `<iframe src="${url}" style="width:100%; height:530px; border:none; border-radius:8px;"></iframe>`;
        } else {
            body.innerHTML = `<img src="${url}" style="max-width:100%; max-height:500px; object-fit:contain; border-radius:8px; box-shadow:0 4px 12px rgba(0,0,0,0.15);">`;
        }

        document.getElementById('popupPreviewArsip').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function tutupModalPreview() {
        document.getElementById('popupPreviewArsip').style.display = 'none';
        document.getElementById('modalBodyContent').innerHTML = '';
        document.body.style.overflow = '';
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') tutupModalPreview();
    });

    window.addEventListener('click', function(e) {
        if (e.target.id === 'popupPreviewArsip') tutupModalPreview();
    });
</script>
@endsection