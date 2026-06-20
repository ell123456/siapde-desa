@extends('layouts.admin')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet">

<style>
    .profil-wrapper {
        font-family: 'Poppins', sans-serif !important;
        background-color: #f4f7fe;
        padding: 0 !important;
        min-height: 100vh;
    }

    .header-profil {
        height: 85px;
        background: var(--sidebar-primary);
        border-bottom: 3px solid var(--sidebar-accent);
        display: flex;
        align-items: center;
        padding: 0 30px;
        color: white;
    }

    .header-profil h4 {
        margin: 0;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 18px;
    }

    .section-title {
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--sidebar-primary);
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 18px;
        padding-bottom: 10px;
        border-bottom: 2px solid #eaecf4;
    }

    .form-label-custom {
        font-size: 11px;
        font-weight: 700;
        color: var(--sidebar-primary);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 6px;
        display: block;
    }

    .ctrl {
        width: 100%;
        padding: 9px 14px;
        font-size: 13px;
        border: 1px solid #d1d3e2;
        border-radius: 8px;
        color: #5a5c69;
        background: white;
        font-family: 'Poppins', sans-serif;
        box-sizing: border-box;
        transition: 0.2s;
    }

    .ctrl:focus {
        border-color: var(--sidebar-accent);
        outline: none;
        box-shadow: 0 0 0 3px rgba(46, 134, 193, 0.1);
    }

    textarea.ctrl {
        resize: vertical;
    }

    .card-section {
        background: white;
        border: 1px solid #eaecf4;
        border-radius: 14px;
        padding: 28px;
        margin-bottom: 24px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
    }

    .grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .grid-3 {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 16px;
    }

    .grid-4 {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr 1fr;
        gap: 16px;
    }

    .syarat-card {
        background: #f8f9fc;
        border: 1px solid #eaecf4;
        border-radius: 10px;
        padding: 14px;
    }

    .syarat-card .label {
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
</style>

<div class="profil-wrapper">
    <div class="header-profil">
        <h4><i class="fas fa-cog mr-3"></i>Edit Profil & Persyaratan Dokumen</h4>
    </div>

    <div style="padding: 28px 30px 50px 30px; max-width: 1100px; margin: 0 auto;">

        @if(session('success'))
        <div style="background: #d1fae5; color: #065f46; padding: 12px 18px; border-radius: 10px; font-size: 13px; font-weight: 700; margin-bottom: 20px; border: 1px solid #a7f3d0;">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
        @endif

        <form action="{{ route('profil.update') }}" method="POST">
            @csrf
            @method('PUT')

            {{-- IDENTITAS DESA --}}
            <div class="card-section">
                <div class="section-title">
                    <i class="fas fa-landmark"></i> Identitas Desa
                </div>
                <div style="margin-bottom: 16px;">
                    <label class="form-label-custom">Nama Desa</label>
                    <input type="text" name="nama_desa" class="ctrl" value="{{ $profil->nama_desa ?? '' }}" placeholder="Masukkan nama desa">
                </div>
                <div class="grid-2">
                    <div>
                        <label class="form-label-custom">Visi</label>
                        <textarea name="visi" class="ctrl" rows="4" placeholder="Tuliskan visi desa...">{{ $profil->visi ?? '' }}</textarea>
                    </div>
                    <div>
                        <label class="form-label-custom">Misi</label>
                        <textarea name="misi" class="ctrl" rows="4" placeholder="Tuliskan misi desa (pisah per baris)...">{{ $profil->misi ?? '' }}</textarea>
                    </div>
                </div>
            </div>

            {{-- STRUKTUR APARAT --}}
            <div class="card-section">
                <div class="section-title">
                    <i class="fas fa-users"></i> Struktur Aparat Desa
                </div>
                <div class="grid-3">
                    @foreach([
                    ['name'=>'nama_kades', 'label'=>'Kepala Desa', 'icon'=>'fa-user-tie'],
                    ['name'=>'nama_sekdes', 'label'=>'Sekretaris Desa', 'icon'=>'fa-user-shield'],
                    ['name'=>'nama_kaur', 'label'=>'Kaur Umum', 'icon'=>'fa-users-gear'],
                    ['name'=>'nama_bendahara', 'label'=>'Bendahara Desa', 'icon'=>'fa-coins'],
                    ['name'=>'nama_kasi', 'label'=>'Kasi Pemerintahan', 'icon'=>'fa-landmark'],
                    ['name'=>'nama_kadus', 'label'=>'Kepala Dusun', 'icon'=>'fa-id-badge'],
                    ] as $a)
                    <div>
                        <label class="form-label-custom"><i class="fas {{ $a['icon'] }} mr-1"></i>{{ $a['label'] }}</label>
                        <input type="text" name="{{ $a['name'] }}" class="ctrl" value="{{ $profil->{$a['name']} ?? '' }}" placeholder="Nama {{ $a['label'] }}">
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- PERSYARATAN DOKUMEN --}}
            <div class="card-section">
                <div class="section-title">
                    <i class="fas fa-file-alt"></i> Persyaratan Dokumen Layanan Surat
                    <span style="font-size:10px; font-weight:600; color:#94a3b8; text-transform:none;">(Tulis tiap syarat di baris baru)</span>
                </div>

                {{-- BARIS 1: SKU, SKTM, SKCK, KTP --}}
                <div class="grid-4" style="margin-bottom: 16px;">
                    @foreach([
                    ['name'=>'syarat_sku', 'label'=>'SKU', 'icon'=>'fa-store', 'color'=>'#2e86c1'],
                    ['name'=>'syarat_sktm', 'label'=>'SKTM', 'icon'=>'fa-hand-holding-heart','color'=>'#e67e22'],
                    ['name'=>'syarat_skck', 'label'=>'SKCK', 'icon'=>'fa-user-shield', 'color'=>'#27ae60'],
                    ['name'=>'syarat_ktp', 'label'=>'KTP', 'icon'=>'fa-address-card', 'color'=>'#2e86c1'],
                    ] as $s)
                    <div class="syarat-card">
                        <div class="label" style="color:{{ $s['color'] }}">
                            <i class="fas {{ $s['icon'] }}"></i>{{ $s['label'] }}
                        </div>
                        <textarea name="{{ $s['name'] }}" class="ctrl" rows="5" placeholder="Tulis syarat...">{{ $profil->{$s['name']} ?? '' }}</textarea>
                    </div>
                    @endforeach
                </div>

                {{-- BARIS 2: DOMISILI, AHLI WARIS, KELAHIRAN, KEMATIAN --}}
                <div class="grid-4" style="margin-bottom: 16px;">
                    @foreach([
                    ['name'=>'syarat_domisili', 'label'=>'DOMISILI', 'icon'=>'fa-home', 'color'=>'#e67e22'],
                    ['name'=>'syarat_waris', 'label'=>'AHLI WARIS', 'icon'=>'fa-scroll', 'color'=>'#8e44ad'],
                    ['name'=>'syarat_lahir', 'label'=>'KELAHIRAN', 'icon'=>'fa-baby', 'color'=>'#27ae60'],
                    ['name'=>'syarat_mati', 'label'=>'KEMATIAN', 'icon'=>'fa-file-medical', 'color'=>'#e74a3b'],
                    ] as $s)
                    <div class="syarat-card">
                        <div class="label" style="color:{{ $s['color'] }}">
                            <i class="fas {{ $s['icon'] }}"></i>{{ $s['label'] }}
                        </div>
                        <textarea name="{{ $s['name'] }}" class="ctrl" rows="5" placeholder="Tulis syarat...">{{ $profil->{$s['name']} ?? '' }}</textarea>
                    </div>
                    @endforeach
                </div>

                {{-- BARIS 3: 3 SURAT BARU --}}
                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px;">
                    @foreach([
                    ['name'=>'syarat_belum_rumah', 'label'=>'BELUM MILIKI RUMAH', 'icon'=>'fa-house-crack', 'color'=>'#0891b2'],
                    ['name'=>'syarat_pindah', 'label'=>'PINDAH PENDUDUK', 'icon'=>'fa-truck-moving', 'color'=>'#7c3aed'],
                    ['name'=>'syarat_tanah', 'label'=>'KET. TANAH', 'icon'=>'fa-mountain-sun', 'color'=>'#b45309'],
                    ] as $s)
                    <div class="syarat-card">
                        <div class="label" style="color:{{ $s['color'] }}">
                            <i class="fas {{ $s['icon'] }}"></i>{{ $s['label'] }}
                        </div>
                        <textarea name="{{ $s['name'] }}" class="ctrl" rows="5" placeholder="Tulis syarat...">{{ $profil->{$s['name']} ?? '' }}</textarea>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- TOMBOL SIMPAN --}}
            <div style="text-align: center;">
                <button type="submit" style="background: var(--sidebar-primary); color: white; border: none; padding: 14px 60px; font-weight: 800; border-radius: 50px; cursor: pointer; font-family: 'Poppins', sans-serif; font-size: 13px; letter-spacing: 0.5px; box-shadow: 0 4px 15px rgba(26,58,92,0.2); transition: 0.2s;" onmouseover="this.style.background='var(--sidebar-accent)'" onmouseout="this.style.background='var(--sidebar-primary)'">
                    <i class="fas fa-save mr-2"></i> SIMPAN SEMUA PERUBAHAN
                </button>
            </div>

        </form>
    </div>
</div>
@endsection