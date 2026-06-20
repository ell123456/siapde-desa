@extends('layouts.admin')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet">

<style>
    .siapde-page-wrapper {
        font-family: 'Poppins', sans-serif !important;
        background-color: #f4f7fe;
        min-height: 100vh;
    }

    /* Header Rapi & Sejajar */
    .siapde-page-header {
        background-color: #1a3a5c;
        padding: 20px 30px;
        display: flex;
        align-items: center;
        border-bottom: 3px solid #2e86c1;
    }

    .siapde-page-header h2 {
        color: white;
        margin: 0;
        font-size: 18px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    /* Info Bar */
    .siapde-info-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: white;
        border-bottom: 1px solid #e8eef6;
        padding: 12px 30px;
        font-size: 13px;
        color: #555;
        font-weight: 500;
    }

    .siapde-info-bar span {
        font-size: 11px;
        font-weight: 700;
        color: #1a3a5c;
        border: 1.5px solid #1a3a5c;
        padding: 4px 14px;
        border-radius: 20px;
    }

    /* Content & Card Rapi (Sudut Melengkung) */
    .siapde-content-container {
        padding: 25px 30px;
    }

    .siapde-filter-card {
        background: white;
        border-radius: 8px;
        /* Sudut melengkung */
        padding: 24px;
        border: 1px solid #e8eef6;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        /* Shadow halus */
    }

    .siapde-form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .siapde-form-group label {
        font-size: 11px;
        font-weight: 700;
        color: #1a3a5c;
        text-transform: uppercase;
    }

    .siapde-input-select {
        height: 38px;
        border: 1px solid #cbd5e1;
        border-radius: 4px;
        padding: 0 12px;
        font-size: 13px;
        color: #334155;
        font-weight: 600;
        background: white;
        width: 220px;
        cursor: pointer;
    }

    .siapde-btn-submit {
        height: 38px;
        display: inline-flex;
        align-items: center;
        padding: 0 20px;
        border-radius: 4px;
        font-weight: 700;
        font-size: 11px;
        color: white;
        background-color: #2e86c1;
        border: none;
        cursor: pointer;
        text-transform: uppercase;
        gap: 8px;
    }

    .siapde-btn-submit:hover {
        background-color: #1a3a5c;
    }
</style>

<div class="siapde-page-wrapper">
    <div class="siapde-page-header">
        <h2>Rekapitulasi Laporan Administrasi Desa</h2>
    </div>

    <div class="siapde-info-bar">
        <p style="margin:0">📄 Pilih periode untuk mengunduh laporan dalam format PDF.</p>
        <span>LAPORAN BULANAN</span>
    </div>

    <div class="siapde-content-container">
        <div class="siapde-filter-card">
            <form action="{{ route('laporan.cetak-pdf') }}" method="GET" target="_blank"
                style="display: flex; gap: 20px; align-items: flex-end; flex-wrap: wrap;">

                <div class="siapde-form-group">
                    <label>Bulan</label>
                    <select name="bulan" class="siapde-input-select">
                        <option value="">-- Semua Bulan --</option>
                        @foreach(['01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'] as $key => $val)
                        <option value="{{ $key }}" {{ date('m') == $key ? 'selected' : '' }}>{{ $val }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="siapde-form-group">
                    <label>Tahun</label>
                    <select name="tahun" class="siapde-input-select">
                        @for($t = date('Y'); $t >= date('Y')-4; $t--)
                        <option value="{{ $t }}">{{ $t }}</option>
                        @endfor
                    </select>
                </div>

                <button type="submit" class="siapde-btn-submit">
                    <i class="fas fa-file-pdf"></i> Generate PDF Laporan
                </button>
            </form>
        </div>
    </div>
</div>
@endsection