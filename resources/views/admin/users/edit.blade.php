@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4" style="background-color: #f4f7f6; min-height: 100vh;">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div style="margin-bottom: 15px;">
                <a href="{{ route('user.index') }}" style="text-decoration: none; color: #4e73df; font-weight: bold; font-size: 13px;"> ← KEMBALI </a>
            </div>

            <div style="background: white; border: 1px solid #d1d3e2; border-radius: 4px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); overflow: hidden;">
                <div style="background-color: #4e73df; padding: 15px; text-align: center !important;">
                    <h5 style="color: white !important; margin: 0 !important; font-weight: bold; text-transform: uppercase; letter-spacing: 2px;">Edit Pengguna</h5>
                </div>

                <div style="padding: 40px;">
                    {{-- Alert kalau ada Error --}}
                    @if ($errors->any())
                    <div style="background-color: #f8d7da; color: #842029; padding: 15px; border-radius: 4px; margin-bottom: 20px; font-size: 13px;">
                        <ul style="margin: 0;">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('user.update', $user->id_user) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-row-classic">
                            <label class="label-classic">NAMA LENGKAP :</label>
                            <div class="input-classic">
                                <input type="text" name="name" class="ctrl-classic" value="{{ old('name', $user->name) }}" required>
                            </div>
                        </div>

                        <div class="form-row-classic">
                            <label class="label-classic">USERNAME :</label>
                            <div class="input-classic">
                                <input type="text" name="username" class="ctrl-classic" value="{{ old('username', $user->username) }}" required>
                            </div>
                        </div>

                        {{-- Perbaikan Layout Password --}}
                        <div class="form-row-classic">
                            <label class="label-classic">PASSWORD BARU :</label>
                            <div class="input-classic">
                                <input type="password" name="password" class="ctrl-classic" placeholder="Isi hanya jika ingin ganti password...">
                                <small style="color: #e74a3b; font-size: 10px; display: block; margin-top: 5px; font-style: italic;">
                                    *Biarkan kosong jika tetap ingin menggunakan password lama.
                                </small>
                            </div>
                        </div>

                        <div class="form-row-classic">
                            <label class="label-classic">STATUS AKUN :</label>
                            <div class="input-classic">
                                <select name="status" class="ctrl-classic" style="width: 200px;">
                                    <option value="aktif" {{ $user->status == 'aktif' ? 'selected' : '' }}>AKTIF</option>
                                    <option value="nonaktif" {{ $user->status == 'nonaktif' ? 'selected' : '' }}>NON-AKTIF</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row-classic">
                            <label class="label-classic">ROLE / JABATAN :</label>
                            <div class="input-classic">
                                <select name="role" class="ctrl-classic" style="width: 200px;">
                                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>ADMIN</option>
                                    <option value="kepdes" {{ $user->role == 'kepdes' ? 'selected' : '' }}>KEPDES</option>
                                </select>
                            </div>
                        </div>

                        <div style="text-align: center; margin-top: 30px; border-top: 1px solid #e3e6f0; padding-top: 20px;">
                            <button type="submit" class="btn-update-classic">
                                <i class="fas fa-save"></i> UPDATE DATA USER
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-row-classic {
        display: flex;
        margin-bottom: 20px;
        align-items: flex-start;
        /* Mengubah center ke start agar label sejajar dengan input meski ada <small> */
    }

    .label-classic {
        width: 30%;
        text-align: right;
        padding-right: 30px;
        padding-top: 8px;
        /* Menyesuaikan tinggi dengan input */
        font-weight: bold;
        font-size: 11px;
        text-transform: uppercase;
        color: #4e73df;
    }

    .input-classic {
        width: 60%;
    }

    .ctrl-classic {
        width: 100%;
        padding: 10px;
        border: 1px solid #d1d3e2;
        border-radius: 4px;
        color: #6e707e;
    }

    .ctrl-classic:focus {
        outline: none;
        border-color: #bac8f3;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
    }

    .btn-update-classic {
        padding: 12px 50px;
        font-weight: bold;
        background-color: #4e73df;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        text-transform: uppercase;
        font-size: 12px;
        transition: 0.3s;
    }

    .btn-update-classic:hover {
        background-color: #2e59d9;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
</style>
@endsection