@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4" style="background-color: #f8f9fc; min-height: 100vh; font-family: 'Nunito', sans-serif;">
    <div class="shadow-sm" style="border-radius: 15px; overflow: hidden; border: 1px solid #e3e6f0; background: white;">

        {{-- Header Biru --}}
        <div style="background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); padding: 20px; color: white; text-align: center;">
            <h2 style="margin: 0; font-weight: 800; text-transform: uppercase; letter-spacing: 1.5px; font-size: 18px;">PENGATURAN PROFIL DESA</h2>
        </div>

        {{-- Form Input --}}
        <form action="{{ route('profil.store') }}" method="POST" style="padding: 30px;">
            @csrf
            @if(session('success'))
            <div style="background: #d1fae5; color: #065f46; padding: 15px; border-radius: 100px; margin-bottom: 25px; font-weight: 700; font-size: 13px; border: 1px solid #a7f3d0; text-align: center;">
                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            </div>
            @endif

            <div class="row">
                {{-- Identitas Desa --}}
                <div class="col-md-12 mb-4">
                    <label style="font-weight: 800; color: #4e73df; font-size: 11px; text-transform: uppercase; display: block; margin-bottom: 8px;">Nama Desa</label>
                    <input type="text" name="nama_desa" class="form-control shadow-none" value="{{ $profil->nama_desa ?? '' }}" style="border-radius: 8px; border: 1px solid #d1d3e2; padding: 10px 15px;">
                </div>

                <div class="col-md-6 mb-4">
                    <label style="font-weight: 800; color: #4e73df; font-size: 11px; text-transform: uppercase; display: block; margin-bottom: 8px;">Visi Desa</label>
                    <textarea name="visi" class="form-control shadow-none" rows="3" style="border-radius: 8px; border: 1px solid #d1d3e2;">{{ $profil->visi ?? '' }}</textarea>
                </div>

                <div class="col-md-6 mb-4">
                    <label style="font-weight: 800; color: #4e73df; font-size: 11px; text-transform: uppercase; display: block; margin-bottom: 8px;">Misi Desa</label>
                    <textarea name="misi" class="form-control shadow-none" rows="3" style="border-radius: 8px; border: 1px solid #d1d3e2;">{{ $profil->misi ?? '' }}</textarea>
                </div>

                {{-- Row 1 Perangkat Desa --}}
                <div class="col-md-4 mb-4">
                    <label style="font-weight: 800; color: #1cc88a; font-size: 11px; text-transform: uppercase; display: block; margin-bottom: 8px;">Nama Kepala Desa</label>
                    <input type="text" name="nama_kades" class="form-control shadow-none" value="{{ $profil->nama_kades ?? '' }}" style="border-radius: 8px; border: 1px solid #d1d3e2;">
                </div>

                <div class="col-md-4 mb-4">
                    <label style="font-weight: 800; color: #1cc88a; font-size: 11px; text-transform: uppercase; display: block; margin-bottom: 8px;">Nama Sekretaris</label>
                    <input type="text" name="nama_sekdes" class="form-control shadow-none" value="{{ $profil->nama_sekdes ?? '' }}" style="border-radius: 8px; border: 1px solid #d1d3e2;">
                </div>

                <div class="col-md-4 mb-4">
                    <label style="font-weight: 800; color: #1cc88a; font-size: 11px; text-transform: uppercase; display: block; margin-bottom: 8px;">Nama Kaur Umum</label>
                    <input type="text" name="nama_kaur" class="form-control shadow-none" value="{{ $profil->nama_kaur ?? '' }}" style="border-radius: 8px; border: 1px solid #d1d3e2;">
                </div>

                {{-- Row 2 Perangkat Desa (Tambahan Baru) --}}
                <div class="col-md-4 mb-4">
                    <label style="font-weight: 800; color: #1cc88a; font-size: 11px; text-transform: uppercase; display: block; margin-bottom: 8px;">Nama Bendahara</label>
                    <input type="text" name="nama_bendahara" class="form-control shadow-none" value="{{ $profil->nama_bendahara ?? '' }}" style="border-radius: 8px; border: 1px solid #d1d3e2;">
                </div>

                <div class="col-md-4 mb-4">
                    <label style="font-weight: 800; color: #1cc88a; font-size: 11px; text-transform: uppercase; display: block; margin-bottom: 8px;">Nama Kasi Pemerintahan</label>
                    <input type="text" name="nama_kasi" class="form-control shadow-none" value="{{ $profil->nama_kasi ?? '' }}" style="border-radius: 8px; border: 1px solid #d1d3e2;">
                </div>

                <div class="col-md-4 mb-4">
                    <label style="font-weight: 800; color: #1cc88a; font-size: 11px; text-transform: uppercase; display: block; margin-bottom: 8px;">Nama Kepala Dusun</label>
                    <input type="text" name="nama_kadus" class="form-control shadow-none" value="{{ $profil->nama_kadus ?? '' }}" style="border-radius: 8px; border: 1px solid #d1d3e2;">
                </div>
            </div>

            <div style="text-align: right; border-top: 1px solid #f1f3f9; padding-top: 20px;">
                <button type="submit" style="background: #4e73df; color: white; border: none; padding: 12px 35px; border-radius: 50px; font-weight: 800; font-size: 12px; box-shadow: 0 4px 12px rgba(78, 115, 223, 0.2); transition: 0.3s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                    <i class="fas fa-save mr-2"></i> SIMPAN PROFIL DESA
                </button>
            </div>
        </form>
    </div>
</div>
@endsection