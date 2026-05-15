@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div style="background: white; border-radius: 20px; padding: 35px; border: 1px solid #e2e8f0; box-shadow: 0 10px 30px rgba(0,0,0,0.02);">

        {{-- Judul Halaman --}}
        <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 30px; border-bottom: 2px solid #f8fafc; padding-bottom: 20px;">
            <div style="background: #1e3a8a; color: white; width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                <i class="fas fa-user-edit"></i>
            </div>
            <div>
                <h4 style="margin: 0; font-weight: 800; color: #1e3a8a;">Konfigurasi Profil Desa</h4>
                <p style="margin: 0; color: #94a3b8; font-size: 13px;">Kelola identitas wilayah dan daftar pejabat desa.</p>
            </div>
        </div>

        <form action="{{ route('profil.update') }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Grid Identitas --}}
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 25px; margin-bottom: 30px;">
                <div>
                    <label style="font-weight: 700; color: #1e3a8a; font-size: 12px; text-transform: uppercase; letter-spacing: 1px;">Nama Desa</label>
                    <input type="text" name="nama_desa" value="{{ $profil->nama_desa }}" class="form-control" style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #e2e8f0; margin-top: 8px;" required>
                </div>
                <div>
                    <label style="font-weight: 700; color: #1e3a8a; font-size: 12px; text-transform: uppercase; letter-spacing: 1px;">Alamat Kantor Desa</label>
                    <input type="text" name="alamat" value="{{ $profil->alamat }}" class="form-control" style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #e2e8f0; margin-top: 8px;">
                </div>
            </div>

            {{-- Section Perangkat (Navy Style Card) --}}
            <div style="background: #f8fafc; border-radius: 15px; padding: 25px; margin-bottom: 30px; border: 1px solid #f1f5f9;">
                <h6 style="margin-top: 0; margin-bottom: 20px; font-weight: 800; color: #1e3a8a; font-size: 14px;"><i class="fas fa-users-cog" style="margin-right: 10px;"></i> DAFTAR PEJABAT STRUKTURAL</h6>
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
                    <div>
                        <label style="font-size: 11px; font-weight: 700; color: #64748b;">NAMA KEPALA DESA</label>
                        <input type="text" name="nama_kades" value="{{ $profil->nama_kades }}" class="form-control" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #e2e8f0; margin-top: 5px;">
                    </div>
                    <div>
                        <label style="font-size: 11px; font-weight: 700; color: #64748b;">NAMA SEKRETARIS DESA</label>
                        <input type="text" name="nama_sekdes" value="{{ $profil->nama_sekdes }}" class="form-control" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #e2e8f0; margin-top: 5px;">
                    </div>
                    <div>
                        <label style="font-size: 11px; font-weight: 700; color: #64748b;">NAMA PERANGKAT DESA</label>
                        <input type="text" name="nama_kaur" value="{{ $profil->nama_kaur }}" class="form-control" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #e2e8f0; margin-top: 5px;">
                    </div>
                </div>
            </div>

            {{-- Visi & Misi --}}
            <div style="margin-bottom: 25px;">
                <label style="font-weight: 700; color: #1e3a8a; font-size: 12px; text-transform: uppercase;">Visi Desa</label>
                <textarea name="visi" rows="3" class="form-control" style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #e2e8f0; margin-top: 8px;">{{ $profil->visi }}</textarea>
            </div>

            <div style="margin-bottom: 35px;">
                <label style="font-weight: 700; color: #1e3a8a; font-size: 12px; text-transform: uppercase;">Misi Desa</label>
                <textarea name="misi" rows="5" class="form-control" style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #e2e8f0; margin-top: 8px;">{{ $profil->misi }}</textarea>
                <small style="color: #94a3b8; font-style: italic;">*Gunakan enter untuk memisahkan setiap poin misi.</small>
            </div>

            {{-- Tombol Aksi --}}
            <div style="display: flex; gap: 15px; border-top: 2px solid #f8fafc; padding-top: 25px;">
                <button type="submit" style="background: #1e3a8a; color: white; border: none; padding: 12px 35px; border-radius: 10px; font-weight: 700; cursor: pointer; transition: 0.3s; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-save"></i> SIMPAN PERUBAHAN
                </button>
                <a href="{{ route('profil.index') }}" style="background: #f1f5f9; color: #64748b; text-decoration: none; padding: 12px 35px; border-radius: 10px; font-weight: 700; display: flex; align-items: center;">BATAL</a>
            </div>
        </form>
    </div>
</div>
@endsection