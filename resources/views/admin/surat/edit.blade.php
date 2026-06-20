@extends('layouts.admin')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet">

<style>
    .siapde-container-full {
        font-family: 'Poppins', sans-serif !important;
        background-color: #f4f7fe;
        margin: 0 !important;
        padding: 0 !important;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    .header-siapde-paten {
        height: 85px;
        background: var(--sidebar-primary);
        border-bottom: 3px solid var(--sidebar-accent);
        width: 100%;
        display: flex;
        align-items: center;
        padding: 0 35px;
        box-sizing: border-box;
        color: white;
    }

    .header-siapde-paten h5 {
        margin: 0 !important;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 18px;
    }

    .header-siapde-paten p {
        margin: 4px 0 0 0 !important;
        font-size: 13px;
        opacity: 0.75;
        font-weight: 500;
    }

    .form-row-classic {
        display: flex !important;
        margin-bottom: 20px !important;
        align-items: center !important;
    }

    .label-classic {
        width: 30% !important;
        text-align: right !important;
        padding-right: 30px !important;
        font-weight: 700 !important;
        font-size: 12px !important;
        color: var(--sidebar-primary) !important;
        margin: 0 !important;
        text-transform: uppercase;
    }

    .input-classic {
        width: 60% !important;
        text-align: left !important;
    }

    .ctrl-classic {
        display: block !important;
        width: 100% !important;
        padding: 9px 14px !important;
        font-size: 13px !important;
        border: 1px solid #d1d3e2 !important;
        border-radius: 8px !important;
        color: #5a5c69 !important;
        background-color: #fff !important;
        font-family: 'Poppins', sans-serif !important;
        box-sizing: border-box;
        transition: 0.2s !important;
        height: 40px;
    }

    textarea.ctrl-classic {
        height: auto !important;
    }

    .ctrl-classic:focus {
        border-color: var(--sidebar-accent) !important;
        outline: none !important;
        box-shadow: 0 0 0 3px rgba(46, 134, 193, 0.1) !important;
    }

    .ctrl-disabled {
        background-color: #f8f9fc !important;
        color: #94a3b8 !important;
        cursor: not-allowed;
    }

    .berkas-section-title {
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--sidebar-primary);
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .berkas-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
    }

    .berkas-card {
        border: 2px dashed #d1d3e2;
        border-radius: 10px;
        padding: 16px 12px 14px 12px;
        background: #f8f9fc;
        display: flex;
        flex-direction: column;
        align-items: center;
        transition: 0.2s;
        position: relative;
        cursor: pointer;
    }

    .berkas-card:hover {
        border-color: var(--sidebar-accent);
        background: #eef6fd;
    }

    .berkas-card.has-file {
        border-color: var(--sidebar-accent);
        background: #eef6fd;
        border-style: solid;
    }

    .berkas-icon-placeholder {
        width: 100%;
        height: 80px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: #b7b9cc;
        gap: 6px;
        margin-bottom: 8px;
    }

    .berkas-icon-placeholder i {
        font-size: 26px;
    }

    .berkas-icon-placeholder span {
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .berkas-preview {
        width: 100%;
        height: 80px;
        object-fit: cover;
        border-radius: 6px;
        margin-bottom: 8px;
        display: none;
    }

    .berkas-label-name {
        font-size: 10.5px;
        font-weight: 800;
        color: var(--sidebar-primary);
        text-align: center;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        margin-bottom: 3px;
        line-height: 1.3;
    }

    .berkas-label-desc {
        font-size: 10px;
        font-weight: 600;
        color: #94a3b8;
        text-align: center;
        line-height: 1.4;
    }

    .berkas-input-file {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
        z-index: 2;
    }

    .berkas-filename {
        font-size: 9.5px;
        font-weight: 700;
        color: var(--sidebar-accent);
        text-align: center;
        margin-top: 5px;
        word-break: break-all;
        line-height: 1.3;
        display: none;
    }

    .berkas-remove {
        position: absolute;
        top: 6px;
        right: 6px;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: #ef4444;
        color: white;
        border: none;
        font-size: 9px;
        cursor: pointer;
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 3;
    }

    @media (max-width: 768px) {
        .form-row-classic {
            display: block !important;
        }

        .label-classic {
            width: 100% !important;
            text-align: left !important;
            padding-right: 0 !important;
            margin-bottom: 5px !important;
        }

        .input-classic {
            width: 100% !important;
        }

        .berkas-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 480px) {
        .berkas-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="siapde-container-full">
    <div class="header-siapde-paten">
        <div>
            <h5>EDIT PENGAJUAN SURAT</h5>
            <p>Pemohon: {{ strtoupper($surat->penduduk->nama) }}</p>
        </div>
    </div>

    <div style="padding: 0 30px 40px 30px;">
        <div style="margin: 20px 0 15px 0;">
            <a href="{{ route('surat.index') }}" style="text-decoration: none; color: var(--sidebar-accent); font-weight: 700; font-size: 13px;">
                ← KEMBALI KE DAFTAR SURAT
            </a>
        </div>

        <div style="background: white; border: 1px solid #eaecf4; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.04); overflow: hidden; max-width: 860px; margin: 0 auto;">
            <div style="padding: 35px 40px;">
                <form action="{{ route('surat.update', $surat->id_surat) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- INFO PENDUDUK READ ONLY --}}
                    <div class="form-row-classic">
                        <label class="label-classic">NAMA PEMOHON :</label>
                        <div class="input-classic">
                            <input type="text" class="ctrl-classic ctrl-disabled" value="{{ $surat->penduduk->nama }}" disabled>
                        </div>
                    </div>

                    <div class="form-row-classic">
                        <label class="label-classic">NIK :</label>
                        <div class="input-classic">
                            <input type="text" class="ctrl-classic ctrl-disabled" value="{{ $surat->penduduk->nik }}" disabled style="font-family: 'Consolas', monospace !important;">
                        </div>
                    </div>

                    <div style="border-top: 1px dashed #eaecf4; margin: 10px 0 25px 0;"></div>

                    {{-- JENIS SURAT --}}
                    <div class="form-row-classic">
                        <label class="label-classic">JENIS SURAT :</label>
                        <div class="input-classic">
                            <select name="jenis_surat" id="jenis_surat" class="ctrl-classic" required>
                                <option value="">-- Pilih Jenis Surat --</option>
                                @php
                                $daftar_surat = [
                                'Surat Pengantar SKCK' => 'Surat Pengantar SKCK',
                                'Surat Keterangan Domisili' => 'Surat Keterangan Domisili',
                                'Surat Pengantar KTP' => 'Surat Pengantar KTP',
                                'Surat Keterangan Usaha' => 'Surat Keterangan Usaha (SKU)',
                                'Surat Keterangan Tidak Mampu' => 'Surat Keterangan Tidak Mampu (SKTM)',
                                'Surat Keterangan Kelahiran' => 'Surat Keterangan Kelahiran',
                                'Surat Keterangan Kematian' => 'Surat Keterangan Kematian',
                                'Surat Keterangan Ahli Waris' => 'Surat Keterangan Ahli Waris',
                                'Surat Keterangan Belum Memiliki Rumah' => 'Surat Keterangan Belum Memiliki Rumah',
                                'Surat Keterangan Pindah Penduduk' => 'Surat Keterangan Pindah Penduduk',
                                'Surat Keterangan Tanah' => 'Surat Keterangan Tanah',
                                ];
                                @endphp
                                @foreach($daftar_surat as $val => $label)
                                <option value="{{ $val }}" {{ $surat->jenis_surat == $val ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- BERKAS PENDUKUNG --}}
                    @php
                    $berkasDecoded = [];
                    if (!empty($surat->berkas)) {
                    $berkasDecoded = is_string($surat->berkas) ? json_decode($surat->berkas, true) : $surat->berkas;
                    }
                    $getFileOld = function($name) use ($berkasDecoded) {
                    if (is_array($berkasDecoded)) {
                    foreach ($berkasDecoded as $b) {
                    if (($b['nama'] ?? '') === $name) return $b['file'] ?? '';
                    }
                    }
                    return '';
                    };
                    $file1 = $getFileOld('Foto KK');
                    $file2 = $getFileOld('Foto KTP');
                    $file3 = $getFileOld('Surat Pengantar RT/RW');
                    $file4 = $getFileOld('Akta Kelahiran');
                    $file5 = $getFileOld('Surat Nikah / Cerai');
                    $file6 = $getFileOld('Berkas Lainnya');
                    @endphp

                    <div class="form-row-classic" style="align-items: flex-start;">
                        <label class="label-classic" style="padding-top: 6px;">BERKAS PENDUKUNG :</label>
                        <div class="input-classic">
                            <div class="berkas-section-title" style="margin-bottom: 12px;">
                                <i class="fas fa-paperclip"></i>
                                Perbarui Lampiran Berkas
                                <span style="text-transform: none; color:#94a3b8;">(Kosongkan jika tidak ingin mengubah)</span>
                            </div>
                            <div class="berkas-grid">

                                <div class="berkas-card {{ $file1 ? 'has-file' : '' }}" id="card_1">
                                    <input type="file" name="berkas[1]" class="berkas-input-file" accept="image/*,.pdf" onchange="previewBerkas(this,1)">
                                    <input type="hidden" name="nama_berkas[1]" value="Foto KK">
                                    <button type="button" class="berkas-remove" id="remove_1" onclick="removeBerkas(1)" style="{{ $file1 ? 'display:flex;' : '' }}"><i class="fas fa-times"></i></button>
                                    <div class="berkas-icon-placeholder" id="placeholder_1" style="{{ $file1 ? 'display:none;' : '' }}"><i class="fas fa-users"></i><span>Klik untuk unggah</span></div>
                                    <img class="berkas-preview" id="preview_1" src="{{ $file1 ? asset('uploads/berkas/'.$file1) : '' }}" alt="" style="{{ $file1 && in_array(pathinfo($file1,PATHINFO_EXTENSION),['jpg','jpeg','png']) ? 'display:block;' : '' }}">
                                    <div class="berkas-label-name">Foto KK</div>
                                    <div class="berkas-label-desc">Kartu Keluarga (semua halaman)</div>
                                    <div class="berkas-filename" id="filename_1" style="{{ $file1 ? 'display:block;' : '' }}">{{ $file1 }}</div>
                                </div>

                                <div class="berkas-card {{ $file2 ? 'has-file' : '' }}" id="card_2">
                                    <input type="file" name="berkas[2]" class="berkas-input-file" accept="image/*,.pdf" onchange="previewBerkas(this,2)">
                                    <input type="hidden" name="nama_berkas[2]" value="Foto KTP">
                                    <button type="button" class="berkas-remove" id="remove_2" onclick="removeBerkas(2)" style="{{ $file2 ? 'display:flex;' : '' }}"><i class="fas fa-times"></i></button>
                                    <div class="berkas-icon-placeholder" id="placeholder_2" style="{{ $file2 ? 'display:none;' : '' }}"><i class="fas fa-id-card"></i><span>Klik untuk unggah</span></div>
                                    <img class="berkas-preview" id="preview_2" src="{{ $file2 ? asset('uploads/berkas/'.$file2) : '' }}" alt="" style="{{ $file2 && in_array(pathinfo($file2,PATHINFO_EXTENSION),['jpg','jpeg','png']) ? 'display:block;' : '' }}">
                                    <div class="berkas-label-name">Foto KTP</div>
                                    <div class="berkas-label-desc">KTP pemohon (tampak depan, jelas)</div>
                                    <div class="berkas-filename" id="filename_2" style="{{ $file2 ? 'display:block;' : '' }}">{{ $file2 }}</div>
                                </div>

                                <div class="berkas-card {{ $file3 ? 'has-file' : '' }}" id="card_3">
                                    <input type="file" name="berkas[3]" class="berkas-input-file" accept="image/*,.pdf" onchange="previewBerkas(this,3)">
                                    <input type="hidden" name="nama_berkas[3]" value="Surat Pengantar RT/RW">
                                    <button type="button" class="berkas-remove" id="remove_3" onclick="removeBerkas(3)" style="{{ $file3 ? 'display:flex;' : '' }}"><i class="fas fa-times"></i></button>
                                    <div class="berkas-icon-placeholder" id="placeholder_3" style="{{ $file3 ? 'display:none;' : '' }}"><i class="fas fa-file-alt"></i><span>Klik untuk unggah</span></div>
                                    <img class="berkas-preview" id="preview_3" src="{{ $file3 ? asset('uploads/berkas/'.$file3) : '' }}" alt="" style="{{ $file3 && in_array(pathinfo($file3,PATHINFO_EXTENSION),['jpg','jpeg','png']) ? 'display:block;' : '' }}">
                                    <div class="berkas-label-name">Surat Pengantar RT/RW</div>
                                    <div class="berkas-label-desc">Surat pengantar dari RT atau RW setempat</div>
                                    <div class="berkas-filename" id="filename_3" style="{{ $file3 ? 'display:block;' : '' }}">{{ $file3 }}</div>
                                </div>

                                <div class="berkas-card {{ $file4 ? 'has-file' : '' }}" id="card_4">
                                    <input type="file" name="berkas[4]" class="berkas-input-file" accept="image/*,.pdf" onchange="previewBerkas(this,4)">
                                    <input type="hidden" name="nama_berkas[4]" value="Akta Kelahiran">
                                    <button type="button" class="berkas-remove" id="remove_4" onclick="removeBerkas(4)" style="{{ $file4 ? 'display:flex;' : '' }}"><i class="fas fa-times"></i></button>
                                    <div class="berkas-icon-placeholder" id="placeholder_4" style="{{ $file4 ? 'display:none;' : '' }}"><i class="fas fa-baby"></i><span>Klik untuk unggah</span></div>
                                    <img class="berkas-preview" id="preview_4" src="{{ $file4 ? asset('uploads/berkas/'.$file4) : '' }}" alt="" style="{{ $file4 && in_array(pathinfo($file4,PATHINFO_EXTENSION),['jpg','jpeg','png']) ? 'display:block;' : '' }}">
                                    <div class="berkas-label-name">Akta Kelahiran</div>
                                    <div class="berkas-label-desc">Akta kelahiran pemohon (jika diperlukan)</div>
                                    <div class="berkas-filename" id="filename_4" style="{{ $file4 ? 'display:block;' : '' }}">{{ $file4 }}</div>
                                </div>

                                <div class="berkas-card {{ $file5 ? 'has-file' : '' }}" id="card_5">
                                    <input type="file" name="berkas[5]" class="berkas-input-file" accept="image/*,.pdf" onchange="previewBerkas(this,5)">
                                    <input type="hidden" name="nama_berkas[5]" value="Surat Nikah / Cerai">
                                    <button type="button" class="berkas-remove" id="remove_5" onclick="removeBerkas(5)" style="{{ $file5 ? 'display:flex;' : '' }}"><i class="fas fa-times"></i></button>
                                    <div class="berkas-icon-placeholder" id="placeholder_5" style="{{ $file5 ? 'display:none;' : '' }}"><i class="fas fa-heart"></i><span>Klik untuk unggah</span></div>
                                    <img class="berkas-preview" id="preview_5" src="{{ $file5 ? asset('uploads/berkas/'.$file5) : '' }}" alt="" style="{{ $file5 && in_array(pathinfo($file5,PATHINFO_EXTENSION),['jpg','jpeg','png']) ? 'display:block;' : '' }}">
                                    <div class="berkas-label-name">Surat Nikah / Cerai</div>
                                    <div class="berkas-label-desc">Buku nikah atau surat cerai (jika diperlukan)</div>
                                    <div class="berkas-filename" id="filename_5" style="{{ $file5 ? 'display:block;' : '' }}">{{ $file5 }}</div>
                                </div>

                                <div class="berkas-card {{ $file6 ? 'has-file' : '' }}" id="card_6">
                                    <input type="file" name="berkas[6]" class="berkas-input-file" accept="image/*,.pdf" onchange="previewBerkas(this,6)">
                                    <input type="hidden" name="nama_berkas[6]" value="Berkas Lainnya">
                                    <button type="button" class="berkas-remove" id="remove_6" onclick="removeBerkas(6)" style="{{ $file6 ? 'display:flex;' : '' }}"><i class="fas fa-times"></i></button>
                                    <div class="berkas-icon-placeholder" id="placeholder_6" style="{{ $file6 ? 'display:none;' : '' }}"><i class="fas fa-file"></i><span>Klik untuk unggah</span></div>
                                    <img class="berkas-preview" id="preview_6" src="{{ $file6 ? asset('uploads/berkas/'.$file6) : '' }}" alt="" style="{{ $file6 && in_array(pathinfo($file6,PATHINFO_EXTENSION),['jpg','jpeg','png']) ? 'display:block;' : '' }}">
                                    <div class="berkas-label-name">Berkas Lainnya</div>
                                    <div class="berkas-label-desc">Dokumen tambahan sesuai kebutuhan</div>
                                    <div class="berkas-filename" id="filename_6" style="{{ $file6 ? 'display:block;' : '' }}">{{ $file6 }}</div>
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- BONGKAR DATA TANAH DARI DATABASE --}}
                    @php
                    $isTanah = $surat->jenis_surat == 'Surat Keterangan Tanah';
                    $dt = null;
                    if ($isTanah && !empty($surat->keterangan)) {
                    $dt = json_decode($surat->keterangan);
                    }
                    $ketBiasa = $isTanah ? '' : ($surat->keterangan ?? '');
                    @endphp

                    {{-- KETERANGAN BIASA --}}
                    <div id="form-keterangan-biasa" class="form-row-classic" style="align-items: flex-start; {{ $isTanah ? 'display:none !important;' : '' }}">
                        <label class="label-classic" style="padding-top: 9px;">KETERANGAN :</label>
                        <div class="input-classic">
                            <textarea name="keterangan" id="keterangan_asli" class="ctrl-classic" rows="4" placeholder="Contoh: Keperluan mengurus paspor atau syarat pendaftaran sekolah">{{ $ketBiasa }}</textarea>
                        </div>
                    </div>

                    {{-- FORM KHUSUS SURAT TANAH --}}
                    <div id="form-khusus-tanah" style="{{ $isTanah ? '' : 'display:none;' }} background: #f8f9fc; padding: 20px; border-radius: 8px; border: 1px solid #d1d3e2; margin-bottom: 20px;">
                        <h6 style="font-weight: 800; color: var(--sidebar-primary); text-transform: uppercase; margin-bottom: 15px; border-bottom: 2px solid #eaecf4; padding-bottom: 5px;">
                            <i class="fas fa-mountain-sun" style="margin-right: 6px;"></i> Detail Data Tanah
                        </h6>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                            <div>
                                <label style="font-size: 11px; font-weight: 800; color: var(--sidebar-primary); text-transform: uppercase; display: block; margin-bottom: 5px;">Luas Tanah (m²)</label>
                                <input type="text" id="t_luas" class="ctrl-classic" value="{{ $dt->luas ?? '' }}" placeholder="Contoh: 150">
                            </div>
                            <div>
                                <label style="font-size: 11px; font-weight: 800; color: var(--sidebar-primary); text-transform: uppercase; display: block; margin-bottom: 5px;">Tahun Perolehan</label>
                                <input type="text" id="t_tahun" class="ctrl-classic" value="{{ $dt->tahun ?? '' }}" placeholder="Contoh: 2015">
                            </div>
                            <div style="grid-column: span 2;">
                                <label style="font-size: 11px; font-weight: 800; color: var(--sidebar-primary); text-transform: uppercase; display: block; margin-bottom: 5px;">Letak Tanah</label>
                                <input type="text" id="t_letak" class="ctrl-classic" value="{{ $dt->letak ?? '' }}" placeholder="Dusun / Jalan / RT RW">
                            </div>
                            <div style="grid-column: span 2;">
                                <label style="font-size: 11px; font-weight: 800; color: var(--sidebar-primary); text-transform: uppercase; display: block; margin-bottom: 5px;">Asal Tanah</label>
                                <input type="text" id="t_asal" class="ctrl-classic" value="{{ $dt->asal ?? '' }}" placeholder="Contoh: Warisan dari Bapak Fulan">
                            </div>
                            <div>
                                <label style="font-size: 11px; font-weight: 800; color: var(--sidebar-primary); text-transform: uppercase; display: block; margin-bottom: 5px;">Status Penguasaan</label>
                                <select id="t_status" class="ctrl-classic">
                                    <option value="Milik Sendiri" {{ ($dt->status ?? '') == 'Milik Sendiri' ? 'selected' : '' }}>Milik Sendiri</option>
                                    <option value="Warisan" {{ ($dt->status ?? '') == 'Warisan' ? 'selected' : '' }}>Warisan</option>
                                    <option value="Hibah" {{ ($dt->status ?? '') == 'Hibah' ? 'selected' : '' }}>Hibah</option>
                                    <option value="Jual Beli" {{ ($dt->status ?? '') == 'Jual Beli' ? 'selected' : '' }}>Jual Beli</option>
                                </select>
                            </div>
                            <div>
                                <label style="font-size: 11px; font-weight: 800; color: var(--sidebar-primary); text-transform: uppercase; display: block; margin-bottom: 5px;">Penggunaan Tanah</label>
                                <select id="t_guna" class="ctrl-classic">
                                    <option value="Rumah Tinggal" {{ ($dt->guna ?? '') == 'Rumah Tinggal' ? 'selected' : '' }}>Rumah Tinggal</option>
                                    <option value="Pertanian" {{ ($dt->guna ?? '') == 'Pertanian' ? 'selected' : '' }}>Pertanian</option>
                                    <option value="Perkebunan" {{ ($dt->guna ?? '') == 'Perkebunan' ? 'selected' : '' }}>Perkebunan</option>
                                    <option value="Lainnya" {{ ($dt->guna ?? '') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                            </div>
                        </div>

                        <h6 style="font-weight: 800; font-size: 12px; color: var(--sidebar-primary); text-transform: uppercase; margin-bottom: 10px; border-bottom: 1px dashed #eaecf4; padding-bottom: 6px;">
                            <i class="fas fa-compass" style="margin-right: 6px;"></i> Batas-Batas Tanah
                        </h6>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                            <div>
                                <label style="font-size: 11px; font-weight: 700; display: block; margin-bottom: 5px;">Sebelah Utara</label>
                                <input type="text" id="t_u" class="ctrl-classic" value="{{ $dt->u ?? '' }}" placeholder="Contoh: Tanah Bapak A">
                            </div>
                            <div>
                                <label style="font-size: 11px; font-weight: 700; display: block; margin-bottom: 5px;">Sebelah Selatan</label>
                                <input type="text" id="t_s" class="ctrl-classic" value="{{ $dt->s ?? '' }}" placeholder="Contoh: Jalan Desa">
                            </div>
                            <div>
                                <label style="font-size: 11px; font-weight: 700; display: block; margin-bottom: 5px;">Sebelah Timur</label>
                                <input type="text" id="t_t" class="ctrl-classic" value="{{ $dt->t ?? '' }}" placeholder="Contoh: Sungai">
                            </div>
                            <div>
                                <label style="font-size: 11px; font-weight: 700; display: block; margin-bottom: 5px;">Sebelah Barat</label>
                                <input type="text" id="t_b" class="ctrl-classic" value="{{ $dt->b ?? '' }}" placeholder="Contoh: Tanah Ibu B">
                            </div>
                        </div>

                        <h6 style="font-weight: 800; font-size: 12px; color: var(--sidebar-primary); text-transform: uppercase; margin-bottom: 10px; border-bottom: 1px dashed #eaecf4; padding-bottom: 6px;">
                            <i class="fas fa-user-friends" style="margin-right: 6px;"></i> Data Saksi I
                        </h6>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                            <div>
                                <label style="font-size: 11px; font-weight: 700; display: block; margin-bottom: 5px;">Nama Saksi I</label>
                                <input type="text" id="t_s1_nama" class="ctrl-classic" value="{{ $dt->s1_nama ?? '' }}">
                            </div>
                            <div>
                                <label style="font-size: 11px; font-weight: 700; display: block; margin-bottom: 5px;">NIK Saksi I</label>
                                <input type="text" id="t_s1_nik" class="ctrl-classic" value="{{ $dt->s1_nik ?? '' }}">
                            </div>
                            <div>
                                <label style="font-size: 11px; font-weight: 700; display: block; margin-bottom: 5px;">Pekerjaan</label>
                                <input type="text" id="t_s1_kerja" class="ctrl-classic" value="{{ $dt->s1_kerja ?? '' }}">
                            </div>
                            <div>
                                <label style="font-size: 11px; font-weight: 700; display: block; margin-bottom: 5px;">Alamat</label>
                                <input type="text" id="t_s1_alamat" class="ctrl-classic" value="{{ $dt->s1_alamat ?? '' }}">
                            </div>
                        </div>

                        <h6 style="font-weight: 800; font-size: 12px; color: var(--sidebar-primary); text-transform: uppercase; margin-bottom: 10px; border-bottom: 1px dashed #eaecf4; padding-bottom: 6px;">
                            <i class="fas fa-user-friends" style="margin-right: 6px;"></i> Data Saksi II
                        </h6>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                            <div>
                                <label style="font-size: 11px; font-weight: 700; display: block; margin-bottom: 5px;">Nama Saksi II</label>
                                <input type="text" id="t_s2_nama" class="ctrl-classic" value="{{ $dt->s2_nama ?? '' }}">
                            </div>
                            <div>
                                <label style="font-size: 11px; font-weight: 700; display: block; margin-bottom: 5px;">NIK Saksi II</label>
                                <input type="text" id="t_s2_nik" class="ctrl-classic" value="{{ $dt->s2_nik ?? '' }}">
                            </div>
                            <div>
                                <label style="font-size: 11px; font-weight: 700; display: block; margin-bottom: 5px;">Pekerjaan</label>
                                <input type="text" id="t_s2_kerja" class="ctrl-classic" value="{{ $dt->s2_kerja ?? '' }}">
                            </div>
                            <div>
                                <label style="font-size: 11px; font-weight: 700; display: block; margin-bottom: 5px;">Alamat</label>
                                <input type="text" id="t_s2_alamat" class="ctrl-classic" value="{{ $dt->s2_alamat ?? '' }}">
                            </div>
                        </div>

                        <div>
                            <label style="font-size: 11px; font-weight: 800; color: var(--sidebar-primary); text-transform: uppercase; display: block; margin-bottom: 5px;">Keperluan Surat</label>
                            <textarea id="t_keperluan" class="ctrl-classic" rows="2" placeholder="Contoh: Pengurusan sertifikat tanah / jual beli / dll">{{ $dt->keperluan ?? '' }}</textarea>
                        </div>
                    </div>

                    {{-- TOMBOL SIMPAN --}}
                    <div style="border-top: 1px solid #eaecf4; margin-top: 30px; padding-top: 30px; display: flex; flex-direction: column; align-items: center;">
                        <button type="submit" style="background: var(--sidebar-primary); color: white; border: none; padding: 13px 0; font-weight: 800; border-radius: 10px; cursor: pointer; width: 300px; margin-bottom: 12px; font-family: 'Poppins', sans-serif; font-size: 13px; letter-spacing: 0.5px; transition: 0.2s;" onmouseover="this.style.background='var(--sidebar-accent)'" onmouseout="this.style.background='var(--sidebar-primary)'">
                            SIMPAN PERUBAHAN SURAT
                        </button>
                        <a href="{{ route('surat.index') }}" style="color: #e74a3b; text-decoration: none; font-weight: 700; font-size: 13px;">
                            BATAL DAN KELUAR
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Toggle form tanah saat jenis surat berubah
    document.getElementById('jenis_surat').addEventListener('change', function() {
        var isTanah = this.value === 'Surat Keterangan Tanah';
        document.getElementById('form-keterangan-biasa').style.display = isTanah ? 'none' : 'flex';
        document.getElementById('form-khusus-tanah').style.display = isTanah ? 'block' : 'none';
    });

    // Bungkus data tanah ke JSON saat submit
    document.querySelector('form').addEventListener('submit', function() {
        if (document.getElementById('jenis_surat').value === 'Surat Keterangan Tanah') {
            var dataTanah = {
                luas: document.getElementById('t_luas').value,
                letak: document.getElementById('t_letak').value,
                status: document.getElementById('t_status').value,
                guna: document.getElementById('t_guna').value,
                tahun: document.getElementById('t_tahun').value,
                asal: document.getElementById('t_asal').value,
                u: document.getElementById('t_u').value,
                s: document.getElementById('t_s').value,
                t: document.getElementById('t_t').value,
                b: document.getElementById('t_b').value,
                s1_nama: document.getElementById('t_s1_nama').value,
                s1_nik: document.getElementById('t_s1_nik').value,
                s1_kerja: document.getElementById('t_s1_kerja').value,
                s1_alamat: document.getElementById('t_s1_alamat').value,
                s2_nama: document.getElementById('t_s2_nama').value,
                s2_nik: document.getElementById('t_s2_nik').value,
                s2_kerja: document.getElementById('t_s2_kerja').value,
                s2_alamat: document.getElementById('t_s2_alamat').value,
                keperluan: document.getElementById('t_keperluan').value,
            };
            document.getElementById('keterangan_asli').value = JSON.stringify(dataTanah);
        }
    });

    const defaultIcons = ['fa-users', 'fa-id-card', 'fa-file-alt', 'fa-baby', 'fa-heart', 'fa-file'];

    function previewBerkas(input, index) {
        const file = input.files[0];
        if (!file) return;

        document.getElementById('card_' + index).classList.add('has-file');
        document.getElementById('filename_' + index).textContent = file.name;
        document.getElementById('filename_' + index).style.display = 'block';
        document.getElementById('remove_' + index).style.display = 'flex';

        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview_' + index).src = e.target.result;
                document.getElementById('preview_' + index).style.display = 'block';
                document.getElementById('placeholder_' + index).style.display = 'none';
            };
            reader.readAsDataURL(file);
        } else {
            document.getElementById('placeholder_' + index).innerHTML = '<i class="fas fa-file-pdf" style="font-size:28px;color:#ef4444;"></i><span>File PDF</span>';
            document.getElementById('placeholder_' + index).style.display = 'flex';
            document.getElementById('preview_' + index).style.display = 'none';
        }
    }

    function removeBerkas(index) {
        const card = document.getElementById('card_' + index);
        card.querySelector('input[type="file"]').value = '';
        card.classList.remove('has-file');

        document.getElementById('preview_' + index).style.display = 'none';
        document.getElementById('preview_' + index).src = '';
        document.getElementById('filename_' + index).style.display = 'none';
        document.getElementById('filename_' + index).textContent = '';
        document.getElementById('remove_' + index).style.display = 'none';
        document.getElementById('placeholder_' + index).innerHTML =
            '<i class="fas ' + defaultIcons[index - 1] + '"></i><span>Klik untuk unggah</span>';
        document.getElementById('placeholder_' + index).style.display = 'flex';
    }
</script>
@endsection