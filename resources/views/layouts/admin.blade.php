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
            --sidebar-primary: #1a3a5c;
            --sidebar-accent: #2e86c1;
            --sidebar-accent-light: #e6f1fb;
            --sidebar-text: rgba(255, 255, 255, 0.75);
            --sidebar-text-active: #ffffff;
            --bg-body: #f4f7fe;
            --text-main: #334155;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-body);
            margin: 0;
            color: var(--text-main);
            overflow: auto !important;
        }

        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* --- SIDEBAR --- */
        .sidebar {
            width: 240px;
            background-color: var(--sidebar-primary);
            color: white;
            position: fixed;
            height: 100vh;
            top: 0;
            left: 0;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.08);
        }

        .sidebar-brand {
            height: 85px;
            padding: 0 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(0, 0, 0, 0.15);
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            box-sizing: border-box;
        }

        .sidebar-brand div {
            font-weight: 800;
            font-size: 1.15rem;
            color: white;
            letter-spacing: 1px;
        }

        .sidebar-section {
            padding: 20px 22px 5px 22px;
            font-size: 0.65rem;
            color: rgba(255, 255, 255, 0.35);
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .sidebar a {
            color: var(--sidebar-text);
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 10px 18px;
            margin: 2px 12px;
            border-radius: 10px;
            font-size: 0.83rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.07);
            color: white;
        }

        .sidebar a.active {
            color: var(--sidebar-text-active);
            background: var(--sidebar-accent);
            font-weight: 700;
        }

        .sidebar i {
            margin-right: 12px;
            width: 18px;
            text-align: center;
            font-size: 14px;
        }

        /* --- PROFIL USER DI SIDEBAR --- */
        .sidebar-user {
            padding: 12px 15px;
            margin: 5px 15px 20px 15px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 14px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar-user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: var(--sidebar-accent);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 15px;
            flex-shrink: 0;
        }

        .sidebar-user-name {
            font-size: 13px;
            font-weight: 700;
            color: #ffffff;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            text-transform: capitalize;
        }

        .sidebar-user-role {
            font-size: 10px;
            font-weight: 600;
            color: #7ec8e3;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-top: 2px;
        }

        /* --- CONTENT AREA --- */
        .content-area {
            flex-grow: 1;
            margin-left: 240px;
            padding: 0 !important;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .main-container {
            padding: 0px !important;
            flex-grow: 1;
            box-sizing: border-box;
        }

        /* --- TOMBOL LOGOUT --- */
        .logout-btn {
            background: transparent;
            color: rgba(255, 255, 255, 0.5);
            width: calc(100% - 24px);
            margin: auto 12px 20px 12px;
            padding: 10px;
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            cursor: pointer;
            font-weight: 600;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.2s ease;
            font-family: 'Poppins', sans-serif;
        }

        .logout-btn:hover {
            background: rgba(231, 76, 60, 0.15);
            color: #e74c3c;
            border-color: rgba(231, 76, 60, 0.3);
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="sidebar">

            {{-- BRAND / LOGO --}}
            <div class="sidebar-brand">
                <img src="{{ asset('logo-desa.png') }}" alt="Logo" style="width: 34px;">
                <div>SIAPDE</div>
            </div>

            {{-- PROFIL USER --}}
            <div class="sidebar-user">
                <div class="sidebar-user-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <div style="overflow: hidden;">
                    <div class="sidebar-user-name">
                        {{ auth()->user()->username ?? 'Pengguna' }}
                    </div>
                    <div class="sidebar-user-role">
                        {{ auth()->user()->role == 'kepdes' ? 'Kepala Desa' : 'Admin Sistem' }}
                    </div>
                </div>
            </div>

            {{-- NAVIGASI UTAMA --}}
            <div class="sidebar-section">Navigasi Utama</div>
            <a href="{{ route('dashboard') }}" class="{{ Request::is('dashboard') ? 'active' : '' }}">
                <i class="fas fa-th-large"></i> Dashboard
            </a>
            <a href="{{ route('penduduk.index') }}" class="{{ Request::is('penduduk*') ? 'active' : '' }}">
                <i class="fas fa-users"></i> Data Penduduk
            </a>
            <a href="{{ route('surat.index') }}" class="{{ Request::is('surat') ? 'active' : '' }}">
                <i class="fas fa-envelope-open-text"></i> Data Surat
                @if(auth()->user()->role == 'admin')
                @php
                $disetujuiCount = \App\Models\Surat::where('status', 'Disetujui')->count();
                @endphp
                @if($disetujuiCount > 0)
                <span style="margin-left:auto; background:#e74c3c; color:white; font-size:10px; font-weight:700; padding:2px 7px; border-radius:99px;">
                    {{ $disetujuiCount }}
                </span>
                @endif
                @endif
            </a>

            @if(auth()->user()->role == 'kepdes')
            <a href="{{ route('surat.verifikasi') }}" class="{{ Request::is('surat/verifikasi') ? 'active' : '' }}">
                <i class="fas fa-file-signature"></i> Verifikasi
                @php
                $pendingCount = \App\Models\Surat::where('status', 'Diajukan')->count();
                @endphp
                @if($pendingCount > 0)
                <span style="margin-left:auto; background:#e74c3c; color:white; font-size:10px; font-weight:700; padding:2px 7px; border-radius:99px;">
                    {{ $pendingCount }}
                </span>
                @endif
            </a>
            @endif

            <a class="nav-link {{ request()->is('arsip-surat*') ? 'active' : '' }}" href="{{ url('/arsip-surat') }}">
                <i class="fas fa-fw fa-archive"></i>
                <span>Arsip Surat</span>
            </a>

            {{-- PENGATURAN SISTEM --}}
            <div class="sidebar-section">Pengaturan Sistem</div>
            <a href="{{ route('laporan.index') }}" class="{{ Request::is('laporan*') ? 'active' : '' }}">
                <i class="fas fa-file-invoice"></i> Laporan
            </a>
            <a href="{{ route('user.index') }}" class="{{ Request::is('user*') ? 'active' : '' }}">
                <i class="fas fa-user-shield"></i> Manajemen User
            </a>

            {{-- LOGOUT --}}
            <form action="{{ route('logout') }}" method="POST" style="margin-top: auto;">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="fas fa-power-off"></i> Keluar Sistem
                </button>
            </form>

        </div>

        <div class="content-area">
            <div class="main-container">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>