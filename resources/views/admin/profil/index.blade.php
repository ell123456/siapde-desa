@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Profil Desa</h1>
        <a href="{{ route('profil.edit') }}" class="btn btn-primary shadow-sm"><i class="fas fa-edit fa-sm text-white-50"></i> Edit Profil</a>
    </div>

    <div class="row">
        {{-- Card Utama --}}
        <div class="col-xl-12 col-md-12 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <h5 class="font-weight-bold text-primary">{{ $profil->nama_desa ?? 'Nama Desa Belum Diatur' }}</h5>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="font-weight-bold">Visi</h6>
                            <p>{{ $profil->visi ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="font-weight-bold">Misi</h6>
                            <p>{{ $profil->misi ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- PERSYARATAN DOKUMEN (DI SINI LU HARUS TAMBAHIN) --}}
    <h6 class="m-0 font-weight-bold text-primary mb-3">DAFTAR PERSYARATAN DOKUMEN</h6>
    <div class="row">
        @php
        $syaratList = [
        ['t' => 'SKU', 'v' => $profil->syarat_sku ?? '-'],
        ['t' => 'SKTM', 'v' => $profil->syarat_sktm ?? '-'],
        ['t' => 'SKCK', 'v' => $profil->syarat_skck ?? '-'],
        ['t' => 'KTP', 'v' => $profil->syarat_ktp ?? '-'],
        ['t' => 'DOMISILI', 'v' => $profil->syarat_domisili ?? '-'],
        ['t' => 'AHLI WARIS', 'v' => $profil->syarat_waris ?? '-'],
        ['t' => 'KELAHIRAN', 'v' => $profil->syarat_lahir ?? '-'],
        ['t' => 'KEMATIAN', 'v' => $profil->syarat_mati ?? '-']
        ];
        @endphp

        @foreach($syaratList as $item)
        <div class="col-md-3 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="font-weight-bold text-warning text-uppercase mb-1" style="font-size: 12px;">{{ $item['t'] }}</div>
                    <div class="text-xs text-gray-800">{{ $item['v'] }}</div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection