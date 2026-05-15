@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4" style="background-color: #f4f7f6; min-height: 100vh;">
    <div class="row justify-content-center">
        <div class="col-md-11">

            <!-- Tombol Kembali di Atas -->
            <div style="margin-bottom: 15px; display: flex; justify-content: flex-start;">
                <a href="{{ route('penduduk.index') }}" style="text-decoration: none; color: #4e73df; font-weight: bold; font-size: 13px;">
                     ← KEMBALI KE DAFTAR PENDUDUK
                </a>
            </div>
            
            <div style="background: white; border: 1px solid #d1d3e2; border-radius: 4px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); overflow: hidden;">
                
                <!-- Judul Formulir: DIPAKSA KE TENGAH -->
                <div style="background-color: #4e73df; padding: 15px; text-align: center !important;">
                    <h5 style="color: white !important; margin: 0 !important; font-weight: bold !important; text-transform: uppercase; letter-spacing: 2px; display: block !important; text-align: center !important;">
                        Edit Data Penduduk
                    </h5>
                </div>

                <div style="padding: 40px;">
                    <!-- Pesan Error jika Validasi Gagal -->
                    @if ($errors->any())
                        <div style="color: #721c24; background-color: #f8d7da; border: 1px solid #f5c6cb; padding: 15px; margin-bottom: 25px; border-radius: 4px;">
                            <ul class="mb-0 small">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('penduduk.update', $penduduk->id_penduduk) }}" method="POST">
                        @csrf
                        @method('PUT') {{-- Kunci agar data bisa terupdate --}}

                        <!-- NIK -->
                        <div class="form-row-classic">
                            <label class="label-classic">NOMOR INDUK (NIK) :</label>
                            <div class="input-classic">
                                <input type="text" name="nik" class="ctrl-classic" value="{{ old('nik', $penduduk->nik) }}" required maxlength="16">
                            </div>
                        </div>

                        <!-- Nama Lengkap -->
                        <div class="form-row-classic">
                            <label class="label-classic">NAMA LENGKAP :</label>
                            <div class="input-classic">
                                <input type="text" name="nama" class="ctrl-classic" value="{{ old('nama', $penduduk->nama) }}" required>
                            </div>
                        </div>

                        <!-- Tempat & Tanggal Lahir (Satu Baris) -->
                        <div class="form-row-classic">
                            <label class="label-classic">TEMPAT, TGL LAHIR :</label>
                            <div class="input-classic" style="display: flex; gap: 10px;">
                                <input type="text" name="tempat_lahir" class="ctrl-classic" style="flex: 2 !important;" value="{{ old('tempat_lahir', $penduduk->tempat_lahir) }}" placeholder="Tempat Lahir" required>
                                <input type="date" name="tgl_lahir" class="ctrl-classic" style="flex: 1 !important;" value="{{ old('tgl_lahir', $penduduk->tgl_lahir) }}" required>
                            </div>
                        </div>

                        <!-- Jenis Kelamin -->
                        <div class="form-row-classic">
                            <label class="label-classic">JENIS KELAMIN :</label>
                            <div class="input-classic" style="display: flex; gap: 20px;">
                                <label style="font-weight: normal; font-size: 14px; cursor: pointer;">
                                    <input type="radio" name="jenis_kelamin" value="L" {{ old('jenis_kelamin', $penduduk->jenis_kelamin) == 'L' ? 'checked' : '' }} required> Laki-laki
                                </label>
                                <label style="font-weight: normal; font-size: 14px; cursor: pointer;">
                                    <input type="radio" name="jenis_kelamin" value="P" {{ old('jenis_kelamin', $penduduk->jenis_kelamin) == 'P' ? 'checked' : '' }}> Perempuan
                                </label>
                            </div>
                        </div>

                        <!-- Agama -->
                        <div class="form-row-classic">
                            <label class="label-classic">AGAMA :</label>
                            <div class="input-classic">
                                <select name="agama" class="ctrl-classic" style="width: 250px !important;" required>
                                    <option value="" disabled>- Pilih Agama -</option>
                                    @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Budha', 'Konghucu'] as $agama)
                                        <option value="{{ $agama }}" {{ old('agama', $penduduk->agama) == $agama ? 'selected' : '' }}>{{ $agama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Pekerjaan -->
                        <div class="form-row-classic">
                            <label class="label-classic">PEKERJAAN :</label>
                            <div class="input-classic">
                                <input type="text" name="pekerjaan" class="ctrl-classic" value="{{ old('pekerjaan', $penduduk->pekerjaan) }}" placeholder="Contoh: Petani, Wiraswasta">
                            </div>
                        </div>

                        <!-- Status Perkawinan -->
                        <div class="form-row-classic">
                            <label class="label-classic">STATUS KAWIN :</label>
                            <div class="input-classic">
                                <select name="status_perkawinan" class="ctrl-classic" style="width: 250px !important;" required>
                                    <option value="" disabled>- Pilih Status -</option>
                                    @foreach(['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'] as $status)
                                        <option value="{{ $status }}" {{ old('status_perkawinan', $penduduk->status_perkawinan) == $status ? 'selected' : '' }}>{{ $status }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Alamat / Dusun -->
                        <div class="form-row-classic" style="align-items: flex-start;">
                            <label class="label-classic" style="padding-top: 5px;">ALAMAT / DUSUN :</label>
                            <div class="input-classic">
                                <textarea name="alamat" class="ctrl-classic" rows="3" placeholder="Nama Jalan, RT/RW, Dusun" required>{{ old('alamat', $penduduk->alamat) }}</textarea>
                            </div>
                        </div>

                        <!-- Footer: SIMPAN & BATAL DIPAKSA KE TENGAH -->
                        <div style="border-top: 1px solid #eee; margin-top: 30px; padding-top: 30px; text-align: center !important; width: 100%;">
                            <div style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
                                <button type="submit" style="background-color: #4e73df; color: white; border: none; padding: 12px 60px; font-weight: bold; border-radius: 4px; cursor: pointer; box-shadow: 0 4px 6px rgba(78, 115, 223, 0.2); width: 300px !important; margin-bottom: 10px;">
                                    UPDATE DATA PENDUDUK
                                </button>
                                <a href="{{ route('penduduk.index') }}" style="color: #e74a3b; text-decoration: none; font-weight: bold; font-size: 13px;">
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

<style>
    /* CSS Mandiri untuk memaksa layout tetap rapi kiri-kanan */
    .form-row-classic {
        display: flex !important;
        margin-bottom: 20px !important;
        align-items: center !important;
    }

    .label-classic {
        width: 30% !important;
        text-align: right !important;
        padding-right: 30px !important;
        font-weight: bold !important;
        font-size: 12px !important;
        color: #333 !important;
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
        padding: 8px 12px !important;
        font-size: 14px !important;
        border: 1px solid #d1d3e2 !important;
        border-radius: 4px !important;
        color: #6e707e !important;
        background-color: #fff !important;
    }

    .ctrl-classic:focus {
        border-color: #4e73df !important;
        outline: none !important;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.1) !important;
        background-color: #fffde7 !important;
    }

    /* Responsif Mobile */
    @media (max-width: 768px) {
        .form-row-classic { display: block !important; }
        .label-classic { width: 100% !important; text-align: left !important; padding-right: 0 !important; margin-bottom: 5px !important; }
        .input-classic { width: 100% !important; }
    }
</style>
@endsection