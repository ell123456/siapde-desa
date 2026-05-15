@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4" style="background-color: #f4f7f6; min-height: 100vh;">
    <div class="row justify-content-center">
        <div class="col-md-8"> {{-- Ukuran lebih kecil dari index agar form tidak terlalu lebar --}}

            <div style="background: white; border: 1px solid #d1d3e2; border-radius: 4px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); overflow: hidden;">

                {{-- Header Form --}}
                <div style="background-color: #4e73df; padding: 15px; text-align: center !important;">
                    <h5 style="color: white !important; margin: 0 !important; font-weight: bold; text-transform: uppercase; letter-spacing: 2px;">
                        Tambah Pengguna Baru
                    </h5>
                </div>

                <div style="padding: 30px;">

                    {{-- Menampilkan Error Validasi Jika Ada --}}
                    @if ($errors->any())
                    <div style="background-color: #f8d7da; color: #842029; padding: 10px; margin-bottom: 20px; border-radius: 4px; font-size: 13px;">
                        <ul style="margin: 0; padding-left: 20px;">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('user.store') }}" method="POST">
                        @csrf

                        <div class="form-group-classic">
                            <label>NAMA LENGKAP</label>
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap..." required>
                        </div>

                        <div class="form-group-classic">
                            <label>USERNAME</label>
                            <input type="text" name="username" value="{{ old('username') }}" placeholder="Username untuk login..." required>
                        </div>

                        <div class="form-group-classic">
                            <label>PASSWORD</label>
                            <input type="password" name="password" placeholder="Minimal 6 karakter..." required>
                        </div>

                        <div class="form-group-classic">
                            <label>ROLE / JABATAN</label>
                            <select name="role" required>
                                <option value="">-- Pilih Jabatan --</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>ADMIN (OPERATOR)</option>
                                <option value="kepdes" {{ old('role') == 'kepdes' ? 'selected' : '' }}>KEPALA DESA</option>
                            </select>
                        </div>

                        <div class="form-group-classic">
                            <label>STATUS AKUN</label>
                            <select name="status" required>
                                <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>AKTIF</option>
                                <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>NON-AKTIF</option>
                            </select>
                        </div>

                        <hr style="border: 0; border-top: 1px solid #e3e6f0; margin: 25px 0;">

                        <div style="display: flex; gap: 10px;">
                            <button type="submit" class="btn-save-classic">
                                <i class="fas fa-save"></i> SIMPAN PENGGUNA
                            </button>
                            <a href="{{ route('user.index') }}" class="btn-cancel-classic">
                                BATAL
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Styling Form Classic */
    .form-group-classic {
        margin-bottom: 20px;
    }

    .form-group-classic label {
        display: block;
        font-size: 11px;
        font-weight: bold;
        color: #4e73df;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .form-group-classic input,
    .form-group-classic select {
        width: 100%;
        padding: 10px 15px;
        border: 1px solid #d1d3e2;
        border-radius: 4px;
        font-size: 14px;
        color: #6e707e;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .form-group-classic input:focus,
    .form-group-classic select:focus {
        outline: none;
        border-color: #bac8f3;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
    }

    /* Tombol Aksi */
    .btn-save-classic {
        background-color: #1cc88a;
        color: white;
        padding: 12px 25px;
        border: none;
        border-radius: 4px;
        font-weight: bold;
        font-size: 12px;
        cursor: pointer;
        transition: 0.3s;
        text-transform: uppercase;
    }

    .btn-save-classic:hover {
        background-color: #17a673;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .btn-cancel-classic {
        background-color: #858796;
        color: white;
        padding: 12px 25px;
        border-radius: 4px;
        text-decoration: none;
        font-weight: bold;
        font-size: 12px;
        transition: 0.3s;
        display: inline-block;
        text-align: center;
    }

    .btn-cancel-classic:hover {
        background-color: #717384;
        color: white;
        text-decoration: none;
    }
</style>
@endsection