@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4" style="background-color: #f4f7f6; min-height: 100vh;">
    <div class="row justify-content-center">
        <div class="col-md-10">

            <!-- Tombol Kembali di Atas (Rapi & Sejajar) -->
            <div style="margin-bottom: 15px; display: flex; justify-content: flex-start;">
                <a href="{{ route('penduduk.index') }}" style="text-decoration: none; color: #4e73df; font-weight: bold; font-size: 13px;">
                    ← KEMBALI KE DAFTAR UTAMA
                </a>
            </div>

            <div style="background: white; border: 1px solid #d1d3e2; border-radius: 4px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); overflow: hidden;">

                <!-- 1. Judul Formulir: DIPAKSA KE TENGAH -->
                <div style="background-color: #4e73df; padding: 15px; text-align: center !important;">
                    <h5 style="color: white !important; margin: 0 !important; font-weight: bold !important; text-transform: uppercase; letter-spacing: 2px; display: block !important; text-align: center !important;">
                        Formulir Input Data Penduduk
                    </h5>
                </div>

                <div style="padding: 40px;">
                    <form action="{{ route('penduduk.store') }}" method="POST">
                        @csrf

                        <!-- NIK -->
                        <div class="form-row-classic">
                            <label class="label-classic">NOMOR INDUK (NIK) :</label>
                            <div class="input-classic">
                                <input type="text" name="nik" class="ctrl-classic" placeholder="Masukkan 16 digit NIK" required maxlength="16">
                            </div>
                        </div>

                        <!-- Nama Lengkap -->
                        <div class="form-row-classic">
                            <label class="label-classic">NAMA LENGKAP :</label>
                            <div class="input-classic">
                                <input type="text" name="nama" class="ctrl-classic" placeholder="Sesuai KTP / KK" required>
                            </div>
                        </div>

                        <!-- Tempat & Tanggal Lahir -->
                        <div class="form-row-classic">
                            <label class="label-classic">TEMPAT, TGL LAHIR :</label>
                            <div class="input-classic" style="display: flex; gap: 10px;">
                                <input type="text" name="tempat_lahir" class="ctrl-classic" style="flex: 2 !important;" placeholder="Tempat Lahir" required>
                                <input type="date" name="tgl_lahir" class="ctrl-classic" style="flex: 1 !important;" required>
                            </div>
                        </div>

                        <!-- Jenis Kelamin -->
                        <div class="form-row-classic">
                            <label class="label-classic">JENIS KELAMIN :</label>
                            <div class="input-classic" style="display: flex; gap: 20px;">
                                <label style="font-weight: normal; font-size: 14px; cursor: pointer;"><input type="radio" name="jenis_kelamin" value="L" required> Laki-laki</label>
                                <label style="font-weight: normal; font-size: 14px; cursor: pointer;"><input type="radio" name="jenis_kelamin" value="P"> Perempuan</label>
                            </div>
                        </div>

                        <!-- Agama -->
                        <div class="form-row-classic">
                            <label class="label-classic">AGAMA :</label>
                            <div class="input-classic">
                                <select name="agama" class="ctrl-classic" style="width: 250px !important;" required>
                                    <option value="" disabled selected>- Pilih Agama -</option>
                                    <option value="Islam">Islam</option>
                                    <option value="Kristen">Kristen</option>
                                    <option value="Katolik">Katolik</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Budha">Budha</option>
                                    <option value="Konghucu">Konghucu</option>
                                </select>
                            </div>
                        </div>

                        <!-- Pekerjaan -->
                        <div class="form-row-classic">
                            <label class="label-classic">PEKERJAAN :</label>
                            <div class="input-classic">
                                <input type="text" name="pekerjaan" class="ctrl-classic" placeholder="Contoh: Petani, Wiraswasta, Mahasiswa">
                            </div>
                        </div>

                        <!-- Status Perkawinan -->
                        <div class="form-row-classic">
                            <label class="label-classic">STATUS KAWIN :</label>
                            <div class="input-classic">
                                <select name="status_perkawinan" class="ctrl-classic" style="width: 250px !important;" required>
                                    <option value="" disabled selected>- Pilih Status -</option>
                                    <option value="Belum Kawin">Belum Kawin</option>
                                    <option value="Kawin">Kawin</option>
                                    <option value="Cerai Hidup">Cerai Hidup</option>
                                    <option value="Cerai Mati">Cerai Mati</option>
                                </select>
                            </div>
                        </div>

                        <!-- Alamat / Dusun -->
                        <div class="form-row-classic" style="align-items: flex-start;">
                            <label class="label-classic" style="padding-top: 5px;">ALAMAT / DUSUN :</label>
                            <div class="input-classic">
                                <textarea name="alamat" class="ctrl-classic" rows="3" placeholder="Nama Jalan, RT/RW, Dusun" required></textarea>
                            </div>
                        </div>

                        <!-- 2. Footer: SIMPAN & BATAL DIPAKSA KE TENGAH -->
                        <div style="border-top: 1px solid #eee; margin-top: 30px; padding-top: 30px; text-align: center !important; width: 100%;">
                            <div style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
                                <button type="submit" style="background-color: #4e73df; color: white; border: none; padding: 12px 60px; font-weight: bold; border-radius: 4px; cursor: pointer; box-shadow: 0 4px 6px rgba(78, 115, 223, 0.2); width: 300px !important; margin-bottom: 10px;">
                                    SIMPAN DATA KE SISTEM
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
    /* CSS Mandiri untuk memaksa layout tetap rapi */
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
    }
</style>
@endsection