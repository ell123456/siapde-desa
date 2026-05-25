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

    /* SELECT2 SELARAS TEMA NAVY */
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

    .select2-container--default .select2-search--dropdown .select2-search__field:focus {
        border-color: var(--sidebar-accent) !important;
        outline: none !important;
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
                <form action="{{ url('/surat') }}" method="POST">
                    @csrf

                    <div class="form-row-classic">
                        <label class="label-classic">NAMA PENDUDUK / NIK :</label>
                        <div class="input-classic">
                            <select name="id_penduduk" id="id_penduduk" class="select2-pencarian" required>
                                <option value="">-- Cari Nama atau NIK --</option>
                                @foreach($penduduk as $p)
                                <option value="{{ $p->id_penduduk }}">{{ $p->nik }} - {{ $p->nama }}</option>
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
                            <input type="date" name="tanggal_pengajuan" class="ctrl-classic" value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>

                    <div class="form-row-classic" style="align-items: flex-start;">
                        <label class="label-classic" style="padding-top: 9px;">KETERANGAN :</label>
                        <div class="input-classic">
                            <textarea name="keterangan" class="ctrl-classic" rows="4" placeholder="Contoh: Keperluan mengurus paspor atau syarat pendaftaran sekolah"></textarea>
                        </div>
                    </div>

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