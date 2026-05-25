@extends('layouts.admin')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet">

<style>
    .siapde-page-wrapper {
        font-family: 'Poppins', sans-serif !important;
        background-color: #f4f7fe;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    .siapde-banner-header {
        background-color: #1a3a5c;
        padding: 22px 25px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    }

    .siapde-banner-header h2 {
        color: white;
        margin: 0 !important;
        font-size: 15px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
    }

    .siapde-content-container {
        padding: 20px 25px;
        box-sizing: border-box;
    }

    .siapde-filter-card {
        background: white;
        border-radius: 4px;
        padding: 24px;
        border: 1px solid #e8eef6;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.01);
    }

    .siapde-form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .siapde-form-group label {
        font-size: 11px;
        font-weight: 700;
        color: #1a3a5c;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .siapde-input-select {
        height: 38px;
        border: 1px solid #cbd5e1;
        border-radius: 4px;
        padding: 0 12px;
        font-size: 13px;
        color: #334155;
        font-weight: 600;
        outline: none;
        background: white;
        width: 240px;
        font-family: 'Poppins', sans-serif;
        cursor: pointer;
    }

    .siapde-input-select:focus {
        border-color: #2e86c1;
    }

    .siapde-btn-submit {
        height: 38px;
        display: inline-flex;
        align-items: center;
        padding: 0 20px;
        border-radius: 4px;
        font-weight: 700;
        font-size: 11px;
        letter-spacing: 0.5px;
        color: white;
        background-color: #2e86c1;
        border: none;
        cursor: pointer;
        transition: background-color 0.2s;
        text-transform: uppercase;
        font-family: 'Poppins', sans-serif;
    }

    .siapde-btn-submit:hover {
        background-color: #1a3a5c;
    }
</style>

<div class="siapde-page-wrapper">
    <div class="siapde-banner-header">
        <h2>REKAPITULASI LAPORAN ADMINISTRASI DESA</h2>
    </div>

    <div class="siapde-content-container">
        <div class="siapde-filter-card">
            <form action="{{ route('laporan.cetak-pdf') }}" method="GET" target="_blank" style="display: flex; gap: 15px; align-items: flex-end; flex-wrap: wrap;">

                <div class="siapde-form-group">
                    <label>TGL MULAI</label>
                    <select name="bulan" class="siapde-input-select">
                        <option value="">-- Semua Bulan --</option>
                        @foreach(['01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'] as $key => $val)
                        <option value="{{ $key }}" {{ date('m') == $key ? 'selected' : '' }}>{{ $val }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="siapde-form-group">
                    <label>TGL SELESAI</label>
                    <select name="tahun" class="siapde-input-select">
                        @for($t = date('Y'); $t >= date('Y')-4; $t--)
                        <option value="{{ $t }}">{{ $t }}</option>
                        @endfor
                    </select>
                </div>

                <button type="submit" class="siapde-btn-submit">
                    <i class="fas fa-file-pdf" style="margin-right: 8px; font-size: 13px;"></i> GENERATE PDF LAPORAN
                </button>
            </form>
        </div>
    </div>
</div>
@endsection