<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIAPDE | {{ $profil->nama_desa ?? 'Digital' }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --bg-body: #f4f7fe;
            --sidebar-navy: #1e3a8a;
            --neon-cyan: #22d3ee;
            --text-main: #334155;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-body);
            margin: 0;
            color: var(--text-main);
            /* --- FIX SCROLL: AKTIF --- */
            overflow: auto !important;
        }

        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* --- SIDEBAR --- */
        .sidebar {
            width: 240px;
            background-color: var(--sidebar-navy);
            color: white;
            position: fixed;
            height: 100vh;
            top: 0;
            left: 0;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.05);
        }

        /* FIX LOGO: Kunci tinggi 85px agar sejajar lurus dengan header */
        .sidebar-brand {
            height: 85px;
            padding: 0 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(0, 0, 0, 0.1);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            box-sizing: border-box;
        }

        .sidebar-brand div {
            font-weight: 800;
            font-size: 1.15rem;
            color: white;
        }

        .sidebar-section {
            padding: 20px 22px 5px 22px;
            font-size: 0.65rem;
            color: rgba(255, 255, 255, 0.4);
            text-transform: uppercase;
            font-weight: 800;
        }

        .sidebar a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 10px 18px;
            margin: 3px 12px;
            border-radius: 12px;
            font-size: 0.83rem;
            transition: 0.3s;
        }

        .sidebar a.active {
            color: white;
            background: rgba(255, 255, 255, 0.15);
            font-weight: 700;
            border-left: 3px solid var(--neon-cyan);
        }

        .sidebar i {
            margin-right: 12px;
            width: 18px;
            text-align: center;
        }

        /* --- CONTENT AREA: MEPET SIDEBAR --- */
        .content-area {
            flex-grow: 1;
            margin-left: 240px;
            padding: 0 !important;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* --- KELAS HEADER PATEN: Gunakan ini di semua halaman (Data Penduduk, Surat, dll) --- */
        .header-siapde-paten {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            margin-top: 0 !important;
            /* Lurus atas mentok */
            color: white;
            border-bottom: 3px solid var(--neon-cyan);
            box-shadow: 0 5px 20px rgba(34, 211, 238, 0.15);
            width: 100%;
            display: flex;
            align-items: center;
            /* Teks otomatis center vertikal */
            height: 85px;
            /* SAMAKAN: Harus sama dengan sidebar-brand */
            padding: 0 60px;
            /* Jarak teks agar rapi */
            box-sizing: border-box;
        }

        .header-siapde-paten h2,
        .header-siapde-paten h4 {
            margin: 0 !important;
            padding: 0 !important;
            line-height: 1 !important;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 1.1rem;
        }

        /* CONTAINER ISI: JARAK PAS BIAR GAK MEPET BANGET */
        .main-container {
            padding: 40px 60px;
            flex-grow: 1;
            box-sizing: border-box;
        }

        .logout-btn {
            background: rgba(239, 68, 68, 0.1);
            color: #f87171;
            width: calc(100% - 24px);
            margin: auto 12px 20px 12px;
            padding: 10px;
            border-radius: 10px;
            border: 1px solid rgba(239, 68, 68, 0.15);
            cursor: pointer;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-transform: uppercase;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="sidebar">
            <div class="sidebar-brand">
                <img src="{{ asset('logo-desa.png') }}" alt="Logo" style="width: 34px;">
                <div>SIAPDE</div>
            </div>

            <div class="sidebar-section">Navigasi Utama</div>
            <a href="{{ route('dashboard') }}" class="{{ Request::is('dashboard') ? 'active' : '' }}"><i class="fas fa-th-large"></i> Dashboard</a>
            <a href="{{ route('penduduk.index') }}" class="{{ Request::is('penduduk*') ? 'active' : '' }}"><i class="fas fa-users"></i> Data Penduduk</a>
            <a href="{{ route('surat.index') }}" class="{{ Request::is('surat') ? 'active' : '' }}"><i class="fas fa-envelope-open-text"></i> Data Surat</a>

            @if(auth()->user()->role == 'kepdes')
            <a href="{{ route('surat.verifikasi') }}" class="{{ Request::is('surat/verifikasi') ? 'active' : '' }}"><i class="fas fa-file-signature"></i> Verifikasi</a>
            @endif

            <a href="{{ route('surat.arsip') }}" class="{{ Request::is('surat/arsip') ? 'active' : '' }}"><i class="fas fa-archive"></i> Arsip Surat</a>

            <div class="sidebar-section">Pengaturan Sistem</div>
            <a href="{{ route('surat.cetakSemua') }}" target="_blank"><i class="fas fa-file-pdf"></i> Laporan</a>
            <a href="{{ route('user.index') }}" class="{{ Request::is('user*') ? 'active' : '' }}"><i class="fas fa-user-shield"></i> Manajemen User</a>

            <form action="{{ route('logout') }}" method="POST" style="margin-top: auto;">
                @csrf
                <button type="submit" class="logout-btn"><i class="fas fa-power-off"></i> KELUAR SISTEM</button>
            </form>
        </div>

        <div class="content-area">
            @yield('content')
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>