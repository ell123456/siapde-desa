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

    .form-card {
        background: white;
        border: 1px solid #eaecf4;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
        overflow: hidden;
        margin: 30px auto;
        width: 100%;
        max-width: 860px;
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
        transition: 0.2s !important;
    }

    .ctrl-classic:focus {
        border-color: var(--sidebar-accent) !important;
        outline: none !important;
        box-shadow: 0 0 0 3px rgba(46, 134, 193, 0.1) !important;
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
        <h5>FORMULIR INPUT DATA PENDUDUK</h5>
    </div>

    <div style="padding: 0 30px 40px 30px;">
        <div style="margin: 20px 0 15px 0;">
            <a href="{{ route('penduduk.index') }}" style="text-decoration: none; color: var(--sidebar-accent); font-weight: 700; font-size: 13px;">
                ← KEMBALI KE DAFTAR UTAMA
            </a>
        </div>

        <div class="form-card">
            <div style="padding: 35px 40px;">
                <form action="{{ route('penduduk.store') }}" method="POST">
                    @csrf

                    <div class="form-row-classic">
                        <label class="label-classic">NOMOR INDUK (NIK) :</label>
                        <div class="input-classic">
                            <input type="text" name="nik" class="ctrl-classic" placeholder="Masukkan 16 digit NIK" required maxlength="16">
                        </div>
                    </div>

                    <div class="form-row-classic">
                        <label class="label-classic">NAMA LENGKAP :</label>
                        <div class="input-classic">
                            <input type="text" name="nama" class="ctrl-classic" placeholder="Sesuai KTP / KK" required>
                        </div>
                    </div>

                    <div class="form-row-classic">
                        <label class="label-classic">TEMPAT, TGL LAHIR :</label>
                        <div class="input-classic" style="display: flex; gap: 10px;">
                            <input type="text" name="tempat_lahir" class="ctrl-classic" style="flex: 2 !important;" placeholder="Tempat Lahir" required>
                            <input type="date" name="tgl_lahir" class="ctrl-classic" style="flex: 1 !important;" required>
                        </div>
                    </div>

                    <div class="form-row-classic">
                        <label class="label-classic">JENIS KELAMIN :</label>
                        <div class="input-classic" style="display: flex; gap: 20px;">
                            <label style="font-weight: 600; font-size: 13px; cursor: pointer; color: #5a5c69;"><input type="radio" name="jenis_kelamin" value="L" required> Laki-laki</label>
                            <label style="font-weight: 600; font-size: 13px; cursor: pointer; color: #5a5c69;"><input type="radio" name="jenis_kelamin" value="P"> Perempuan</label>
                        </div>
                    </div>

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

                    <div class="form-row-classic">
                        <label class="label-classic">PEKERJAAN :</label>
                        <div class="input-classic">
                            <input type="text" name="pekerjaan" class="ctrl-classic" placeholder="Contoh: Petani, Wiraswasta, Mahasiswa">
                        </div>
                    </div>

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

                    <div class="form-row-classic" style="align-items: flex-start;">
                        <label class="label-classic" style="padding-top: 9px;">ALAMAT / DUSUN :</label>
                        <div class="input-classic">
                            <textarea name="alamat" class="ctrl-classic" rows="3" placeholder="Nama Jalan, RT/RW, Dusun" required></textarea>
                        </div>
                    </div>

                    <div style="border-top: 1px solid #eaecf4; margin-top: 30px; padding-top: 30px; display: flex; flex-direction: column; align-items: center;">
                        <button type="submit" style="background: var(--sidebar-primary); color: white; border: none; padding: 13px 0; font-weight: 800; border-radius: 10px; cursor: pointer; width: 300px; margin-bottom: 12px; font-family: 'Poppins', sans-serif; font-size: 13px; letter-spacing: 0.5px; transition: 0.2s;" onmouseover="this.style.background='var(--sidebar-accent)'" onmouseout="this.style.background='var(--sidebar-primary)'">
                            SIMPAN DATA KE SISTEM
                        </button>
                        <a href="{{ route('penduduk.index') }}" style="color: #e74a3b; text-decoration: none; font-weight: 700; font-size: 13px;">
                            BATAL DAN KELUAR
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection