@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4" style="background-color: #f4f7f6; min-height: 100vh;">
    <div class="row justify-content-center">
        <div class="col-md-11">

            <div style="margin-bottom: 15px; display: flex; justify-content: flex-start;">
                <a href="{{ url('/surat') }}" style="text-decoration: none; color: #4e73df; font-weight: bold; font-size: 13px;">
                    ← KEMBALI KE DAFTAR SURAT
                </a>
            </div>

            <div style="background: white; border: 1px solid #d1d3e2; border-radius: 4px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); overflow: hidden;">

                <div style="background-color: #4e73df; padding: 15px; text-align: center;">
                    <h5 style="color: white; margin: 0; font-weight: bold; text-transform: uppercase; letter-spacing: 2px;">
                        Tambah Surat Baru
                    </h5>
                </div>

                <div style="padding: 40px;">
                    <form action="{{ url('/surat') }}" method="POST">
                        @csrf

                        <div class="form-row-classic">
                            <label class="label-classic">NAMA PENDUDUK / NIK :</label>
                            <div class="input-classic">
                                <select name="id_penduduk" id="id_penduduk" class="select2-pencarian" required>
                                    <option value="">-- Cari Nama atau NIK --</option>
                                    @foreach($penduduk as $p)
                                    <option value="{{ $p->id_penduduk }}">
                                        {{ $p->nik }} - {{ $p->nama }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

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
                                </select>
                            </div>
                        </div>

                        <div class="form-row-classic">
                            <label class="label-classic">TANGGAL PENGAJUAN :</label>
                            <div class="input-classic">
                                <input type="date" name="tanggal_pengajuan" id="tanggal_pengajuan" class="ctrl-classic" value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>

                        <div class="form-row-classic" style="align-items: flex-start;">
                            <label class="label-classic" style="padding-top: 5px;">KETERANGAN :</label>
                            <div class="input-classic">
                                <textarea name="keterangan" id="keterangan" class="ctrl-classic" rows="4" placeholder="Contoh: Keperluan mengurus paspor atau syarat pendaftaran sekolah"></textarea>
                            </div>
                        </div>

                        <div style="border-top: 1px solid #eee; margin-top: 30px; padding-top: 30px; text-align: center;">
                            <button type="submit" style="background-color: #4e73df; color: white; border: none; padding: 12px 60px; font-weight: bold; border-radius: 4px; cursor: pointer; box-shadow: 0 4px 6px rgba(78, 115, 223, 0.2); width: 300px;">
                                SIMPAN DATA SURAT
                            </button>
                            <div style="margin-top: 15px;">
                                <a href="{{ url('/surat') }}" style="color: #e74a3b; text-decoration: none; font-weight: bold; font-size: 13px;">
                                    BATAL DAN KELUAR
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
    .form-row-classic {
        display: flex;
        margin-bottom: 20px;
        align-items: center;
    }

    .label-classic {
        width: 30%;
        text-align: right;
        padding-right: 30px;
        font-weight: bold;
        font-size: 12px;
        color: #333;
        text-transform: uppercase;
    }

    .input-classic {
        width: 60%;
    }

    .ctrl-classic {
        display: block;
        width: 100%;
        padding: 8px 12px;
        font-size: 14px;
        border: 1px solid #d1d3e2;
        border-radius: 4px;
        color: #6e707e;
        background-color: #fff;
        box-sizing: border-box;
        height: 38px;
    }

    /* Khusus textarea agar tingginya fleksibel tidak terkunci 38px */
    textarea.ctrl-classic {
        height: auto !important;
    }

    .ctrl-classic:focus {
        border-color: #4e73df;
        outline: none;
        background-color: #fffde7;
    }

    /* 🎨 KALIBRASI VISUAL SELECT2 (BIAR JADI KEMBAR IDENTIK SAMA JENIS SURAT) */
    .select2-container--default .select2-selection--single {
        display: block !important;
        width: 100% !important;
        height: 38px !important;
        /* Tinggi disamakan persis */
        padding: 5px 12px !important;
        font-size: 14px !important;
        border: 1px solid #d1d3e2 !important;
        /* Warna border disamakan */
        border-radius: 4px !important;
        background-color: #fff !important;
    }

    /* Menghilangkan border bawaan fokus Select2 yang hitam tebal */
    .select2-container--default .select2-selection--single:focus {
        outline: none !important;
    }

    /* Efek teks di dalam box dropdown Select2 */
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #6e707e !important;
        line-height: 26px !important;
        padding-left: 0 !important;
    }

    /* Posisi panah kecil dropdown Select2 */
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px !important;
        right: 10px !important;
    }

    /* Efek Fokus Kuning Lembut saat Dropdown Pencarian Diklik Aktif */
    .select2-container--default.select2-container--open .select2-selection--single {
        border-color: #4e73df !important;
        background-color: #fffde7 !important;
        /* Efek fokus disamakan */
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer></script>

<script>
    window.addEventListener('load', function() {
        setTimeout(function() {
            if (typeof window.jQuery !== 'undefined') {
                window.jQuery('.select2-pencarian').select2({
                    placeholder: "-- Cari Nama atau NIK --",
                    allowClear: true,
                    width: '100%'
                });
            }
        }, 300);
    });
</script>
@endsection