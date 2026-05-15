<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validasi Surat Digital</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7fe;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }

        .card {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
            text-align: center;
        }

        .success-icon {
            color: #22c55e;
            font-size: 70px;
            margin-bottom: 20px;
        }

        h2 {
            color: #1e3a8a;
            margin-bottom: 5px;
        }

        .status-badge {
            background: #dcfce7;
            color: #15803d;
            padding: 5px 15px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.9rem;
            display: inline-block;
            margin-bottom: 25px;
        }

        .info-box {
            text-align: left;
            background: #f8fafc;
            padding: 15px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
        }

        .info-item {
            margin-bottom: 10px;
            border-bottom: 1px solid #edf2f7;
            padding-bottom: 5px;
        }

        .info-item:last-child {
            border: none;
        }

        .label {
            font-size: 0.8rem;
            color: #64748b;
            font-weight: 600;
        }

        .value {
            font-size: 1rem;
            color: #1e293b;
            font-weight: 700;
            display: block;
        }

        .footer-note {
            margin-top: 25px;
            font-size: 0.75rem;
            color: #94a3b8;
        }
    </style>
</head>

<body>
    <div class="card">
        <i class="fas fa-check-circle success-icon"></i>
        <h2>Dokumen Asli</h2>
        <div class="status-badge">TERVERIFIKASI DIGITAL</div>

        <div class="info-box">
            <div class="info-item">
                <span class="label">Jenis Surat</span>
                <span class="value">Surat Keterangan {{ $surat->jenis_surat }}</span>
            </div>
            <div class="info-item">
                <span class="label">Nama Pemilik</span>
                <span class="value">{{ strtoupper($surat->penduduk->nama) }}</span>
            </div>
            <div class="info-item">
                <span class="label">NIK</span>
                <span class="value">{{ $surat->penduduk->nik }}</span>
            </div>
            <div class="info-item">
                <span class="label">Tanggal Disetujui</span>
                <span class="value">{{ \Carbon\Carbon::parse($surat->disetujui_at)->format('d F Y H:i') }} WIB</span>
            </div>
            <div class="info-item">
                <span class="label">ID TTE</span>
                <span class="value">{{ $surat->tte_code }}</span>
            </div>
        </div>

        <p class="footer-note">Sistem Informasi Administrasi Pemerintahan Desa (SIAPDE)<br>&copy; {{ date('Y') }} Kantor Kepala Desa XYZ</p>
    </div>
</body>

</html>