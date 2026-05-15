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
                                <div style="background: #f8fafc; padding: 10px 15px; border: 1px solid #d1d3e2; border-radius: 4px; display: inline-flex; align-items: center; gap: 10px; color: #5a5c69; font-weight: bold;">
                                    <i class="fas fa-lock" style="font-size: 11px; color: #94a3b8;"></i>
                                    {{ date('d/m/Y') }}
                                    <span style="font-size: 9px; background: #eaecf4; color: #4e73df; padding: 2px 8px; border-radius: 3px; text-transform: uppercase;">Otomatis</span>
                                </div>
                                <input type="hidden" name="tanggal_pengajuan" value="{{ date('Y-m-d') }}">
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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

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
    }

    .ctrl-classic:focus {
        border-color: #4e73df;
        outline: none;
        background-color: #fffde7;
    }

    /* Sinkronisasi Select2 dengan Style Bos */
    .select2-container--bootstrap-5 .select2-selection {
        border: 1px solid #d1d3e2 !important;
        border-radius: 4px !important;
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2-pencarian').select2({
            theme: 'bootstrap-5',
            placeholder: "-- Cari Nama atau NIK --",
            allowClear: true,
            width: '100%'
        });
    });
</script>
@endsection