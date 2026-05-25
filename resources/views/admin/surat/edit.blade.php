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
                <form action="{{ route('surat.update', $surat->id_surat) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- INFO PENDUDUK (READ ONLY) --}}
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

                    {{-- PEMISAH --}}
                    <div style="border-top: 1px dashed #eaecf4; margin: 10px 0 25px 0;"></div>

                    {{-- BAGIAN YANG BISA DIEDIT --}}
                    <div class="form-row-classic">
                        <label class="label-classic">JENIS SURAT :</label>
                        <div class="input-classic">
                            <select name="jenis_surat" class="ctrl-classic" required>
                                <option value="">-- Pilih Jenis Surat --</option>
                                @foreach([
                                'Surat Pengantar SKCK' => 'Surat Pengantar SKCK',
                                'Surat Keterangan Domisili' => 'Surat Keterangan Domisili',
                                'Surat Pengantar KTP' => 'Surat Pengantar KTP',
                                'Surat Keterangan Usaha' => 'Surat Keterangan Usaha (SKU)',
                                'Surat Keterangan Tidak Mampu' => 'Surat Keterangan Tidak Mampu (SKTM)',
                                'Surat Keterangan Kelahiran' => 'Surat Keterangan Kelahiran',
                                'Surat Keterangan Kematian' => 'Surat Keterangan Kematian',
                                'Surat Keterangan Ahli Waris' => 'Surat Keterangan Ahli Waris',
                                ] as $val => $label)
                                <option value="{{ $val }}" {{ $surat->jenis_surat == $val ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-row-classic" style="align-items: flex-start;">
                        <label class="label-classic" style="padding-top: 9px;">KETERANGAN :</label>
                        <div class="input-classic">
                            <textarea name="keterangan" class="ctrl-classic" rows="4" placeholder="Contoh: Keperluan mengurus paspor atau syarat pendaftaran sekolah">{{ $surat->keterangan }}</textarea>
                        </div>
                    </div>

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
@endsection