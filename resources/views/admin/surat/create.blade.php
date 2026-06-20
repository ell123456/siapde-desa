@extends('layouts.admin')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

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

    .select2-container {
        width: 100% !important;
    }

    .select2-container--default .select2-selection--single {
        height: 40px !important;
        padding: 5px 12px !important;
        font-size: 13px !important;
        border: 1px solid #d1d3e2 !important;
        border-radius: 8px !important;
        background-color: #fff !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #5a5c69 !important;
        line-height: 28px !important;
        padding-left: 0 !important;
        font-family: 'Poppins', sans-serif !important;
        font-size: 13px !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 38px !important;
        right: 10px !important;
    }

    .select2-container--default.select2-container--open .select2-selection--single {
        border-color: var(--sidebar-accent) !important;
        box-shadow: 0 0 0 3px rgba(46, 134, 193, 0.1) !important;
    }

    .select2-container--default .select2-results__option--highlighted {
        background-color: var(--sidebar-primary) !important;
    }

    .select2-dropdown {
        border: 1px solid #d1d3e2 !important;
        border-radius: 8px !important;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08) !important;
        font-family: 'Poppins', sans-serif !important;
        font-size: 13px !important;
    }

    .select2-container--default .select2-search--dropdown .select2-search__field {
        border: 1px solid #d1d3e2 !important;
        border-radius: 6px !important;
        padding: 7px 10px !important;
        font-family: 'Poppins', sans-serif !important;
        font-size: 12px !important;
        outline: none !important;
    }

    .select2-container--default .select2-search--dropdown .select2-search__field:focus {
        border-color: var(--sidebar-accent) !important;
        box-shadow: 0 0 0 2px rgba(46, 134, 193, 0.1) !important;
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
        <h5>TAMBAH SURAT BARU</h5>
    </div>

    <div style="padding: 0 30px 40px 30px;">
        <div style="margin: 20px 0 15px 0;">
            <a href="{{ url('/surat') }}" style="text-decoration: none; color: var(--sidebar-accent); font-weight: 700; font-size: 13px;">
                ← KEMBALI KE DAFTAR SURAT
            </a>
        </div>

        <div style="background: white; border: 1px solid #eaecf4; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.04); overflow: hidden; max-width: 860px; margin: 0 auto;">
            <div style="padding: 35px 40px;">
                <form action="{{ url('/surat') }}" method="POST" enctype="multipart/form-data" id="form-surat">
                    @csrf

                    {{-- 1. NAMA PENDUDUK / NIK --}}
                    <div class="form-row-classic">
                        <label class="label-classic">NAMA PENDUDUK / NIK :</label>
                        <div class="input-classic">
                            <select name="id_penduduk" id="id_penduduk" required>
                                <option value="">-- Ketik nama atau NIK untuk mencari --</option>
                                @foreach($penduduk as $p)
                                <option value="{{ $p->id_penduduk }}">{{ $p->nik }} — {{ $p->nama }}</option>
                                @endforeach
                            </select>
                            <div style="margin-top: 5px; font-size: 10px; font-weight: 600; color: #94a3b8;">
                                <i class="fas fa-info-circle"></i> Ketik NIK atau nama untuk mencari data penduduk
                            </div>
                        </div>
                    </div>

                    {{-- 2. JENIS SURAT --}}
                    <div class="form-row-classic">
                        <label class="label-classic">JENIS SURAT :</label>
                        <div class="input-classic">
                            <select name="jenis_surat" id="jenis_surat" class="ctrl-classic" required>
                                <option value="">-- Pilih Jenis Surat --</option>
                                <option value="Surat Pengantar SKCK">Surat Pengantar SKCK</option>
                                <option value="Surat Keterangan Domisili">Surat Keterangan Domisili</option>
                                <option value="Surat Pengantar KTP">Surat Pengantar KTP</option>
                                <option value="Surat Keterangan Usaha">Surat Keterangan Usaha (SKU)</option>
                                <option value="Surat Keterangan Tidak Mampu">Surat Keterangan Tidak Mampu (SKTM)</option>
                                <option value="Surat Keterangan Kelahiran">Surat Keterangan Kelahiran</option>
                                <option value="Surat Keterangan Kematian">Surat Keterangan Kematian</option>
                                <option value="Surat Keterangan Ahli Waris">Surat Keterangan Ahli Waris</option>
                                <option value="Surat Keterangan Belum Memiliki Rumah">Surat Keterangan Belum Memiliki Rumah</option>
                                <option value="Surat Keterangan Pindah Penduduk">Surat Keterangan Pindah Penduduk</option>
                                <option value="Surat Keterangan Tanah">Surat Keterangan Tanah</option>
                            </select>
                        </div>
                    </div>

                    {{-- 3. TANGGAL PENGAJUAN --}}
                    <div class="form-row-classic">
                        <label class="label-classic">TANGGAL PENGAJUAN :</label>
                        <div class="input-classic">
                            <input type="date" name="tanggal_pengajuan" class="ctrl-classic" value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>

                    {{-- 4. BERKAS PENDUKUNG --}}
                    <div class="form-row-classic" style="align-items: flex-start;">
                        <label class="label-classic" style="padding-top: 6px;">BERKAS PENDUKUNG :</label>
                        <div class="input-classic">
                            <div class="berkas-section-title" style="margin-bottom: 12px;">
                                <i class="fas fa-paperclip"></i>
                                Unggah Lampiran Berkas
                                <span style="font-size: 10px; font-weight: 600; color: #94a3b8; text-transform: none; letter-spacing: 0;">(JPG/PNG/PDF, maks. 2MB)</span>
                            </div>

                            <div class="berkas-grid">

                                {{-- BERKAS 1 --}}
                                <div class="berkas-card" id="card_1">
                                    <input type="file" name="berkas[1]" class="berkas-input-file" accept="image/*,.pdf" onchange="previewBerkas(this,1)">
                                    <input type="hidden" name="nama_berkas[1]" value="Foto KK">
                                    <button type="button" class="berkas-remove" id="remove_1" onclick="removeBerkas(1)"><i class="fas fa-times"></i></button>
                                    <div class="berkas-icon-placeholder" id="placeholder_1"><i class="fas fa-users"></i><span>Klik untuk unggah</span></div>
                                    <img class="berkas-preview" id="preview_1" src="" alt="">
                                    <div class="berkas-label-name">Foto KK</div>
                                    <div class="berkas-label-desc">Kartu Keluarga (semua halaman)</div>
                                    <div class="berkas-filename" id="filename_1"></div>
                                </div>

                                {{-- BERKAS 2 --}}
                                <div class="berkas-card" id="card_2">
                                    <input type="file" name="berkas[2]" class="berkas-input-file" accept="image/*,.pdf" onchange="previewBerkas(this,2)">
                                    <input type="hidden" name="nama_berkas[2]" value="Foto KTP">
                                    <button type="button" class="berkas-remove" id="remove_2" onclick="removeBerkas(2)"><i class="fas fa-times"></i></button>
                                    <div class="berkas-icon-placeholder" id="placeholder_2"><i class="fas fa-id-card"></i><span>Klik untuk unggah</span></div>
                                    <img class="berkas-preview" id="preview_2" src="" alt="">
                                    <div class="berkas-label-name">Foto KTP</div>
                                    <div class="berkas-label-desc">KTP pemohon (tampak depan, jelas)</div>
                                    <div class="berkas-filename" id="filename_2"></div>
                                </div>

                                {{-- BERKAS 3 --}}
                                <div class="berkas-card" id="card_3">
                                    <input type="file" name="berkas[3]" class="berkas-input-file" accept="image/*,.pdf" onchange="previewBerkas(this,3)">
                                    <input type="hidden" name="nama_berkas[3]" value="Surat Pengantar RT/RW">
                                    <button type="button" class="berkas-remove" id="remove_3" onclick="removeBerkas(3)"><i class="fas fa-times"></i></button>
                                    <div class="berkas-icon-placeholder" id="placeholder_3"><i class="fas fa-file-alt"></i><span>Klik untuk unggah</span></div>
                                    <img class="berkas-preview" id="preview_3" src="" alt="">
                                    <div class="berkas-label-name">Surat Pengantar RT/RW</div>
                                    <div class="berkas-label-desc">Surat pengantar dari RT atau RW setempat</div>
                                    <div class="berkas-filename" id="filename_3"></div>
                                </div>

                                {{-- BERKAS 4 --}}
                                <div class="berkas-card" id="card_4">
                                    <input type="file" name="berkas[4]" class="berkas-input-file" accept="image/*,.pdf" onchange="previewBerkas(this,4)">
                                    <input type="hidden" name="nama_berkas[4]" value="Akta Kelahiran">
                                    <button type="button" class="berkas-remove" id="remove_4" onclick="removeBerkas(4)"><i class="fas fa-times"></i></button>
                                    <div class="berkas-icon-placeholder" id="placeholder_4"><i class="fas fa-baby"></i><span>Klik untuk unggah</span></div>
                                    <img class="berkas-preview" id="preview_4" src="" alt="">
                                    <div class="berkas-label-name">Akta Kelahiran</div>
                                    <div class="berkas-label-desc">Akta kelahiran pemohon (jika diperlukan)</div>
                                    <div class="berkas-filename" id="filename_4"></div>
                                </div>

                                {{-- BERKAS 5 --}}
                                <div class="berkas-card" id="card_5">
                                    <input type="file" name="berkas[5]" class="berkas-input-file" accept="image/*,.pdf" onchange="previewBerkas(this,5)">
                                    <input type="hidden" name="nama_berkas[5]" value="Surat Nikah / Cerai">
                                    <button type="button" class="berkas-remove" id="remove_5" onclick="removeBerkas(5)"><i class="fas fa-times"></i></button>
                                    <div class="berkas-icon-placeholder" id="placeholder_5"><i class="fas fa-heart"></i><span>Klik untuk unggah</span></div>
                                    <img class="berkas-preview" id="preview_5" src="" alt="">
                                    <div class="berkas-label-name">Surat Nikah / Cerai</div>
                                    <div class="berkas-label-desc">Buku nikah atau surat cerai (jika diperlukan)</div>
                                    <div class="berkas-filename" id="filename_5"></div>
                                </div>

                                {{-- BERKAS 6 --}}
                                <div class="berkas-card" id="card_6">
                                    <input type="file" name="berkas[6]" class="berkas-input-file" accept="image/*,.pdf" onchange="previewBerkas(this,6)">
                                    <input type="hidden" name="nama_berkas[6]" value="Berkas Lainnya">
                                    <button type="button" class="berkas-remove" id="remove_6" onclick="removeBerkas(6)"><i class="fas fa-times"></i></button>
                                    <div class="berkas-icon-placeholder" id="placeholder_6"><i class="fas fa-file"></i><span>Klik untuk unggah</span></div>
                                    <img class="berkas-preview" id="preview_6" src="" alt="">
                                    <div class="berkas-label-name">Berkas Lainnya</div>
                                    <div class="berkas-label-desc">Dokumen tambahan sesuai kebutuhan</div>
                                    <div class="berkas-filename" id="filename_6"></div>
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- 5. KETERANGAN BIASA (sembunyi kalau pilih Surat Tanah) --}}
                    <div id="form-keterangan-biasa" class="form-row-classic" style="align-items: flex-start;">
                        <label class="label-classic" style="padding-top: 9px;">KETERANGAN :</label>
                        <div class="input-classic">
                            <textarea name="keterangan" id="keterangan_asli" class="ctrl-classic" rows="4" placeholder="Contoh: Keperluan mengurus paspor atau syarat pendaftaran sekolah"></textarea>
                        </div>
                    </div>

                    {{-- 6. FORM KHUSUS SURAT TANAH (awalnya sembunyi) --}}
                    <div id="form-khusus-tanah" style="display: none; background: #f8f9fc; padding: 20px; border-radius: 8px; border: 1px solid #d1d3e2; margin-bottom: 20px;">
                        <h6 style="font-weight: 800; color: var(--sidebar-primary); text-transform: uppercase; margin-bottom: 15px; border-bottom: 2px solid #eaecf4; padding-bottom: 5px;">
                            <i class="fas fa-mountain-sun" style="margin-right: 6px;"></i> Detail Data Tanah
                        </h6>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                            <div>
                                <label style="font-size: 11px; font-weight: 800; color: var(--sidebar-primary); text-transform: uppercase; display: block; margin-bottom: 5px;">Luas Tanah (m²)</label>
                                <input type="text" id="t_luas" class="ctrl-classic" placeholder="Contoh: 150">
                            </div>
                            <div>
                                <label style="font-size: 11px; font-weight: 800; color: var(--sidebar-primary); text-transform: uppercase; display: block; margin-bottom: 5px;">Tahun Perolehan</label>
                                <input type="text" id="t_tahun" class="ctrl-classic" placeholder="Contoh: 2015">
                            </div>
                            <div style="grid-column: span 2;">
                                <label style="font-size: 11px; font-weight: 800; color: var(--sidebar-primary); text-transform: uppercase; display: block; margin-bottom: 5px;">Letak Tanah</label>
                                <input type="text" id="t_letak" class="ctrl-classic" placeholder="Dusun / Jalan / RT RW">
                            </div>
                            <div style="grid-column: span 2;">
                                <label style="font-size: 11px; font-weight: 800; color: var(--sidebar-primary); text-transform: uppercase; display: block; margin-bottom: 5px;">Asal Tanah</label>
                                <input type="text" id="t_asal" class="ctrl-classic" placeholder="Contoh: Warisan dari Bapak Fulan">
                            </div>
                            <div>
                                <label style="font-size: 11px; font-weight: 800; color: var(--sidebar-primary); text-transform: uppercase; display: block; margin-bottom: 5px;">Status Penguasaan</label>
                                <select id="t_status" class="ctrl-classic">
                                    <option value="Milik Sendiri">Milik Sendiri</option>
                                    <option value="Warisan">Warisan</option>
                                    <option value="Hibah">Hibah</option>
                                    <option value="Jual Beli">Jual Beli</option>
                                </select>
                            </div>
                            <div>
                                <label style="font-size: 11px; font-weight: 800; color: var(--sidebar-primary); text-transform: uppercase; display: block; margin-bottom: 5px;">Penggunaan Tanah</label>
                                <select id="t_guna" class="ctrl-classic">
                                    <option value="Rumah Tinggal">Rumah Tinggal</option>
                                    <option value="Pertanian">Pertanian</option>
                                    <option value="Perkebunan">Perkebunan</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                        </div>

                        <h6 style="font-weight: 800; font-size: 12px; color: var(--sidebar-primary); text-transform: uppercase; margin-bottom: 10px; border-bottom: 1px dashed #eaecf4; padding-bottom: 6px;">
                            <i class="fas fa-compass" style="margin-right: 6px;"></i> Batas-Batas Tanah
                        </h6>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                            <div>
                                <label style="font-size: 11px; font-weight: 700; display: block; margin-bottom: 5px;">Sebelah Utara</label>
                                <input type="text" id="t_u" class="ctrl-classic" placeholder="Contoh: Tanah Bapak A">
                            </div>
                            <div>
                                <label style="font-size: 11px; font-weight: 700; display: block; margin-bottom: 5px;">Sebelah Selatan</label>
                                <input type="text" id="t_s" class="ctrl-classic" placeholder="Contoh: Jalan Desa">
                            </div>
                            <div>
                                <label style="font-size: 11px; font-weight: 700; display: block; margin-bottom: 5px;">Sebelah Timur</label>
                                <input type="text" id="t_t" class="ctrl-classic" placeholder="Contoh: Sungai">
                            </div>
                            <div>
                                <label style="font-size: 11px; font-weight: 700; display: block; margin-bottom: 5px;">Sebelah Barat</label>
                                <input type="text" id="t_b" class="ctrl-classic" placeholder="Contoh: Tanah Ibu B">
                            </div>
                        </div>

                        <h6 style="font-weight: 800; font-size: 12px; color: var(--sidebar-primary); text-transform: uppercase; margin-bottom: 10px; border-bottom: 1px dashed #eaecf4; padding-bottom: 6px;">
                            <i class="fas fa-user-friends" style="margin-right: 6px;"></i> Data Saksi I
                        </h6>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                            <div>
                                <label style="font-size: 11px; font-weight: 700; display: block; margin-bottom: 5px;">Nama Saksi I</label>
                                <input type="text" id="t_s1_nama" class="ctrl-classic">
                            </div>
                            <div>
                                <label style="font-size: 11px; font-weight: 700; display: block; margin-bottom: 5px;">NIK Saksi I</label>
                                <input type="text" id="t_s1_nik" class="ctrl-classic">
                            </div>
                            <div>
                                <label style="font-size: 11px; font-weight: 700; display: block; margin-bottom: 5px;">Pekerjaan</label>
                                <input type="text" id="t_s1_kerja" class="ctrl-classic">
                            </div>
                            <div>
                                <label style="font-size: 11px; font-weight: 700; display: block; margin-bottom: 5px;">Alamat</label>
                                <input type="text" id="t_s1_alamat" class="ctrl-classic">
                            </div>
                        </div>

                        <h6 style="font-weight: 800; font-size: 12px; color: var(--sidebar-primary); text-transform: uppercase; margin-bottom: 10px; border-bottom: 1px dashed #eaecf4; padding-bottom: 6px;">
                            <i class="fas fa-user-friends" style="margin-right: 6px;"></i> Data Saksi II
                        </h6>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                            <div>
                                <label style="font-size: 11px; font-weight: 700; display: block; margin-bottom: 5px;">Nama Saksi II</label>
                                <input type="text" id="t_s2_nama" class="ctrl-classic">
                            </div>
                            <div>
                                <label style="font-size: 11px; font-weight: 700; display: block; margin-bottom: 5px;">NIK Saksi II</label>
                                <input type="text" id="t_s2_nik" class="ctrl-classic">
                            </div>
                            <div>
                                <label style="font-size: 11px; font-weight: 700; display: block; margin-bottom: 5px;">Pekerjaan</label>
                                <input type="text" id="t_s2_kerja" class="ctrl-classic">
                            </div>
                            <div>
                                <label style="font-size: 11px; font-weight: 700; display: block; margin-bottom: 5px;">Alamat</label>
                                <input type="text" id="t_s2_alamat" class="ctrl-classic">
                            </div>
                        </div>

                        <div style="margin-top: 5px;">
                            <label style="font-size: 11px; font-weight: 800; color: var(--sidebar-primary); text-transform: uppercase; display: block; margin-bottom: 5px;">Keperluan Surat</label>
                            <textarea id="t_keperluan" class="ctrl-classic" rows="2" placeholder="Contoh: Pengurusan sertifikat tanah / jual beli / dll"></textarea>
                        </div>
                    </div>

                    {{-- TOMBOL SIMPAN --}}
                    <div style="border-top: 1px solid #eaecf4; margin-top: 30px; padding-top: 30px; display: flex; flex-direction: column; align-items: center;">
                        <button type="submit" style="background: var(--sidebar-primary); color: white; border: none; padding: 13px 0; font-weight: 800; border-radius: 10px; cursor: pointer; width: 300px; margin-bottom: 12px; font-family: 'Poppins', sans-serif; font-size: 13px; letter-spacing: 0.5px; transition: 0.2s;" onmouseover="this.style.background='var(--sidebar-accent)'" onmouseout="this.style.background='var(--sidebar-primary)'">
                            SIMPAN DATA SURAT
                        </button>
                        <a href="{{ url('/surat') }}" style="color: #e74a3b; text-decoration: none; font-weight: 700; font-size: 13px;">
                            BATAL DAN KELUAR
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener('load', function() {
        var s = document.createElement('script');
        s.src = 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js';
        s.onload = function() {
            $('#id_penduduk').select2({
                placeholder: '-- Ketik nama atau NIK untuk mencari --',
                allowClear: true,
                width: '100%',
                minimumInputLength: 0,
                language: {
                    searching: function() {
                        return 'Sedang mencari...';
                    },
                    noResults: function() {
                        return 'Data penduduk tidak ditemukan';
                    },
                }
            });
        };
        document.body.appendChild(s);
    });

    // Toggle form surat tanah
    document.getElementById('jenis_surat').addEventListener('change', function() {
        var isTanah = this.value === 'Surat Keterangan Tanah';
        document.getElementById('form-keterangan-biasa').style.display = isTanah ? 'none' : 'flex';
        document.getElementById('form-khusus-tanah').style.display = isTanah ? 'block' : 'none';
    });

    // *** PERBAIKAN UTAMA: Bungkus data tanah ke JSON sebelum submit ***
    document.getElementById('form-surat').addEventListener('submit', function(e) {
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