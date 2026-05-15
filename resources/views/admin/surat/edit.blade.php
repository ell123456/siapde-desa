@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4" style="background-color: #f8f9fc; min-height: 100vh; font-family: 'Nunito', sans-serif;">
    <div class="shadow-sm" style="border-radius: 15px; overflow: hidden; border: 1px solid #e3e6f0; background: white; max-width: 850px; margin: auto;">

        {{-- Header Navy --}}
        <div style="background: linear-gradient(135deg, #1e3a8a 0%, #224abe 100%); padding: 25px; color: white; text-align: center;">
            <h2 style="margin: 0; font-weight: 800; text-transform: uppercase; letter-spacing: 1.5px; font-size: 18px;">
                <i class="fas fa-file-signature mr-2"></i> Edit Pengajuan {{ $surat->jenis_surat }}
            </h2>
            {{-- Panggil nama penduduk lewat relasi $surat->penduduk --}}
            <p style="margin: 5px 0 0 0; font-size: 13px; opacity: 0.9;">Pemohon: {{ $surat->penduduk->nama }}</p>
        </div>

        <div style="padding: 30px;">
            <a href="{{ route('surat.index') }}" style="display: inline-block; background: #f1f5f9; color: #475569; padding: 8px 20px; border-radius: 8px; text-decoration: none; font-weight: 700; font-size: 12px; margin-bottom: 25px;">
                <i class="fas fa-arrow-left mr-1"></i> KEMBALI
            </a>

            <form action="{{ route('surat.update', $surat->id_surat) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    {{-- Info Penduduk (Read Only) --}}
                    <div class="col-md-6 mb-4">
                        <label style="font-weight: 800; color: #1e3a8a; font-size: 11px; text-transform: uppercase; display: block; margin-bottom: 8px;">Nama Pemohon</label>
                        <input type="text" class="form-control" value="{{ $surat->penduduk->nama }}" disabled style="background-color: #f8f9fc; border-radius: 8px; font-weight: 700;">
                    </div>

                    <div class="col-md-6 mb-4">
                        <label style="font-weight: 800; color: #1e3a8a; font-size: 11px; text-transform: uppercase; display: block; margin-bottom: 8px;">NIK</label>
                        <input type="text" class="form-control" value="{{ $surat->penduduk->nik }}" disabled style="background-color: #f8f9fc; border-radius: 8px; font-family: 'Consolas', monospace;">
                    </div>

                    {{-- Bagian yang Bisa Diedit --}}
                    <div class="col-md-12 mb-4">
                        <label style="font-weight: 800; color: #4e73df; font-size: 11px; text-transform: uppercase; display: block; margin-bottom: 8px;">Jenis Surat</label>
                        <select name="jenis_surat" class="form-control shadow-none" required style="border-radius: 8px; border: 1px solid #d1d3e2; height: auto; padding: 10px 15px;">
                            <option value="">-- Semua Jenis Surat --</option>
                            <option value="SKCK" {{ $surat->jenis_surat == 'SKCK' ? 'selected' : '' }}>Pengantar SKCK</option>
                            <option value="KTP" {{ $surat->jenis_surat == 'KTP' ? 'selected' : '' }}>Pengantar KTP</option>
                            <option value="Domisili" {{ $surat->jenis_surat == 'Domisili' ? 'selected' : '' }}>Keterangan Domisili</option>
                            <option value="SKU" {{ $surat->jenis_surat == 'SKU' ? 'selected' : '' }}>Keterangan Usaha (SKU)</option>
                            <option value="SKTM" {{ $surat->jenis_surat == 'SKTM' ? 'selected' : '' }}>Keterangan Tidak Mampu (SKTM)</option>
                            <option value="Kelahiran" {{ request('jenis_surat') == 'Kelahiran' ? 'selected' : '' }}>Surat Keterangan Kelahiran</option>
                            <option value="Kematian" {{ request('jenis_surat') == 'Kematian' ? 'selected' : '' }}>Surat Keterangan Kematian</option>
                            <option value="Ahli Waris" {{ $surat->jenis_surat == 'Ahli Waris' ? 'selected' : '' }}>Keterangan Ahli Waris</option>
                        </select>
                    </div>

                    <div class="col-md-12 mb-4">
                        <label style="font-weight: 800; color: #4e73df; font-size: 11px; text-transform: uppercase; display: block; margin-bottom: 8px;">Keperluan / Keterangan Tambahan</label>
                        <textarea name="keterangan" class="form-control shadow-none" rows="4" style="border-radius: 8px; border: 1px solid #d1d3e2;">{{ $surat->keterangan }}</textarea>
                    </div>
                </div>

                <div style="text-align: right; border-top: 1px solid #f1f3f9; padding-top: 25px;">
                    <button type="submit" style="background: #1e3a8a; color: white; border: none; padding: 12px 40px; border-radius: 50px; font-weight: 800; font-size: 12px; box-shadow: 0 4px 12px rgba(30, 58, 138, 0.2); cursor: pointer;">
                        <i class="fas fa-save mr-2"></i> SIMPAN PERUBAHAN SURAT
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection