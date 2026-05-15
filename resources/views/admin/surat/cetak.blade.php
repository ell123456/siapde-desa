<!DOCTYPE html>
<html>

<head>
    <title>Cetak Surat - {{ $item->status == 'disetujui' ? $item->penduduk->nama : 'Akses Ditolak' }}</title>
    <style>
        /* Pengaturan Kertas A4 agar pas 1 halaman */
        @page {
            margin: 1cm 2cm 1cm 2cm;
        }

        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 11pt;
            line-height: 1.3;
            color: #000;
            margin: 0;
        }

        /* KOP SURAT RINGKAS */
        .kop-surat {
            width: 100%;
            border-bottom: 3px double #000;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }

        .logo-cell {
            width: 80px;
            text-align: left;
            vertical-align: middle;
        }

        .text-cell {
            text-align: center;
        }

        .text-cell h3 {
            margin: 0;
            font-size: 12pt;
            text-transform: uppercase;
        }

        .text-cell h2 {
            margin: 0;
            font-size: 14pt;
            text-transform: uppercase;
        }

        .text-cell p {
            margin: 2px 0 0 0;
            font-size: 9pt;
        }

        /* ISI SURAT */
        .judul-surat {
            text-align: center;
            text-decoration: underline;
            font-weight: bold;
            font-size: 13pt;
            text-transform: uppercase;
        }

        .nomor-surat {
            text-align: center;
            margin-bottom: 15px;
            font-size: 11pt;
        }

        .pembuka {
            text-indent: 40px;
            text-align: justify;
            margin-bottom: 10px;
        }

        /* TABEL DATA */
        .data-table {
            margin: 5px 0 5px 45px;
            width: 90%;
        }

        .data-table td {
            padding: 2px 0;
            vertical-align: top;
        }

        .label {
            width: 160px;
        }

        .titik {
            width: 15px;
        }

        .penutup {
            text-indent: 40px;
            text-align: justify;
            margin-top: 15px;
        }

        /* TANDA TANGAN DIGITAL STYLE */
        .footer-ttd {
            margin-top: 30px;
            float: right;
            width: 250px;
            text-align: center;
        }

        .qr-wrapper {
            margin: 5px 0;
        }

        .tte-info {
            font-size: 8pt;
            color: #444;
            line-height: 1.2;
            margin-top: 2px;
        }

        .clear {
            clear: both;
        }

        /* Style untuk halaman Error Peringatan */
        .alert-danger {
            border: 2px dashed #cc0000;
            padding: 20px;
            background-color: #fff5f5;
            text-align: center;
            margin-top: 50px;
            font-family: 'Arial', sans-serif;
        }

        .alert-danger h2 {
            color: #cc0000;
            margin-bottom: 5px;
        }
    </style>
</head>

<body>
    {{-- 🛡️ SISTEM PENGAMAN UTAMA: Cek Status Surat --}}
    @if($item->status !== 'disetujui')
    <div class="alert-danger">
        <h2>⚠️ DOKUMEN TIDAK SAH!</h2>
        <p>Surat Keterangan ini tidak dapat dicetak karena <strong>BELUM DISETUJUI</strong> atau <strong>DITOLAK</strong> oleh Kepala Desa.</p>
        <p style="font-size: 9pt; color: #666; margin-top: 15px;">Sistem Administrasi Pelayanan Desa (SIAPDE)</p>
    </div>
    @else
    {{-- JIKA STATUS DISETUJUI, MAKA KODE SURAT DI BAWAH INI BARU AKAN DIEKSEKUSI --}}
    @php
    $bulanIndo = ['01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'];
    $tglLahirRaw = \Carbon\Carbon::parse($item->penduduk->tgl_lahir);
    $tglLahirIndo = $tglLahirRaw->format('d') . ' ' . $bulanIndo[$tglLahirRaw->format('m')] . ' ' . $tglLahirRaw->format('Y');

    // Tanggal Surat menggunakan disetujui_at (Waktu Persetujuan Kades)
    $tglAcc = $item->disetujui_at ? \Carbon\Carbon::parse($item->disetujui_at) : \Carbon\Carbon::now();
    $tglSuratIndo = $tglAcc->format('d') . ' ' . $bulanIndo[$tglAcc->format('m')] . ' ' . $tglAcc->format('Y');
    @endphp

    <table class="kop-surat">
        <tr>
            <td class="logo-cell">
                @if($logoBase64) <img src="{{ $logoBase64 }}" width="75"> @endif
            </td>
            <td class="text-cell">
                <h3>PEMERINTAH KABUPATEN XYZ</h3>
                <h3>KECAMATAN XYZ</h3>
                <h2>KANTOR KEPALA DESA XYZ</h2>
                <p>Alamat: Alamat Contoh Desa XYZ - Kode Pos 00000</p>
            </td>
        </tr>
    </table>

    <div class="content">
        <div class="judul-surat">SURAT KETERANGAN {{ $item->jenis_surat }}</div>
        <div class="nomor-surat">Nomor: 140 / {{ str_pad($item->id_surat, 3, '0', STR_PAD_LEFT) }} / {{ date('Y') }}</div>

        <p class="pembuka">Yang bertanda tangan di bawah ini, Kepala Desa XYZ menerangkan dengan sebenarnya bahwa:</p>

        <table class="data-table">
            <tr>
                <td class="label">Nama Lengkap</td>
                <td class="titik">:</td>
                <td style="font-weight: bold;">{{ strtoupper($item->penduduk->nama) }}</td>
            </tr>
            <tr>
                <td>NIK</td>
                <td>:</td>
                <td style="font-weight: bold;">{{ $item->penduduk->nik }}</td>
            </tr>
            <tr>
                <td>Tempat, Tgl Lahir</td>
                <td>:</td>
                <td style="font-weight: bold;">{{ $item->penduduk->tempat_lahir }}, {{ $tglLahirIndo }}</td>
            </tr>
            <tr>
                <td>Jenis Kelamin</td>
                <td>:</td>
                <td>{{ ($item->penduduk->jenis_kelamin == 'L') ? 'Laki-laki' : 'Perempuan' }}</td>
            </tr>
            <tr>
                <td>Agama</td>
                <td>:</td>
                <td>{{ $item->penduduk->agama ?? '-' }}</td>
            </tr>
            <tr>
                <td>Pekerjaan</td>
                <td>:</td>
                <td>{{ $item->penduduk->pekerjaan ?? '-' }}</td>
            </tr>
            <tr>
                <td>Status Perkawinan</td>
                <td>:</td>
                <td>{{ $item->penduduk->status_perkawinan ?? '-' }}</td>
            </tr>
            <tr>
                <td>Alamat / Dusun</td>
                <td>:</td>
                <td>{{ $item->penduduk->alamat ?? $item->penduduk->dusun ?? 'Desa XYZ' }}</td>
            </tr>
        </table>

        <p class="penutup">Demikian surat keterangan ini diberikan kepada yang bersangkutan untuk dapat dipergunakan sebagaimana mestinya.</p>

        {{-- AREA TANDA TANGAN DIGITAL (TTE) --}}
        <div class="footer-ttd">
            <p>Desa XYZ, {{ $tglSuratIndo }}</p>
            <p style="margin-bottom: 5px;">Kepala Desa XYZ,</p>

            @if($item->tte_code)
            <div class="qr-wrapper">
                @php
                // Generate SVG mentah lalu di-encode ke Base64 supaya DomPDF mau nampilin gambarnya
                $qrCode = QrCode::size(90)->margin(0)->generate(url('/cek-surat/' . $item->tte_code));
                $base64Qr = base64_encode($qrCode);
                @endphp
                <img src="data:image/svg+xml;base64,{{ $base64Qr }}" width="90" height="90">
            </div>
            <div class="tte-info">
                <i>Dokumen ini sah & ditandatangani secara elektronik.</i><br>
                <strong>ID: {{ $item->tte_code }}</strong>
            </div>
            @else
            <br><br><br>
            <p><strong>( ________________________ )</strong></p>
            @endif

            <p style="margin-top: 10px;">
                <strong><u>{{ $profil->nama_kepdes ?? 'NAMA KEPALA DESA' }}</u></strong>
            </p>
        </div>
        <div class="clear"></div>
    </div>
    @endif
</body>

</html>