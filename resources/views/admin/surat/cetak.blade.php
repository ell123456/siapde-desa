<!DOCTYPE html>
<html>

<head>
    <title>Cetak Surat - {{ $item->status == 'disetujui' || $item->status == 'selesai' ? $item->penduduk->nama : 'Akses Ditolak' }}</title>
    <style>
        /* Pengaturan Kertas A4 agar pas 1 halaman */
        @page {
            margin: 1cm 2cm 1cm 2cm;
        }

        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 11pt;
            line-height: 1.25;
            color: #000;
            margin: 0;
        }

        /* KOP SURAT RINGKAS */
        .kop-surat {
            width: 100%;
            border-bottom: 3px double #000;
            padding-bottom: 5px;
            margin-bottom: 10px;
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
            font-size: 12pt;
            text-transform: uppercase;
            margin-bottom: 2px;
        }

        .nomor-surat {
            text-align: center;
            margin-bottom: 15px;
            font-size: 11pt;
        }

        /* PARAGRAF MENJOROK KE DALAM (40px) */
        .indent {
            text-indent: 40px;
            text-align: justify;
            margin: 5px 0;
        }

        .penutup {
            text-indent: 40px;
            text-align: justify;
            margin-top: 15px;
        }

        /* TABEL DATA STANDAR (Dibuat margin 50px agar lebih menjorok dari teks) */
        .data-table {
            margin: 5px 0 10px 50px;
            /* <--- INI YANG BIKIN MENJOROK KE DALAM */
            width: 85%;
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

        /* KUNCI UTAMA: ANTI TERPOTONG BEDA HALAMAN */
        .keep-together {
            page-break-inside: avoid;
        }

        /* TANDA TANGAN DIGITAL STYLE */
        .footer-ttd {
            margin-top: 20px;
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

        /* Style Error Peringatan */
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
    @if($item->status !== 'disetujui' && $item->status !== 'selesai')
    <div class="alert-danger">
        <h2>⚠️ DOKUMEN TIDAK SAH!</h2>
        <p>Surat Keterangan ini tidak dapat dicetak karena <strong>BELUM DISETUJUI</strong> atau <strong>DITOLAK</strong> oleh Kepala Desa.</p>
        <p style="font-size: 9pt; color: #666; margin-top: 15px;">Sistem Administrasi Pelayanan Desa (SIAPDE)</p>
    </div>
    @else

    {{-- PERSIAPAN DATA TANGGAL & JSON --}}
    @php
    $bulanIndo = ['01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'];
    $tglLahirRaw = \Carbon\Carbon::parse($item->penduduk->tgl_lahir);
    $tglLahirIndo = $tglLahirRaw->format('d') . ' ' . $bulanIndo[$tglLahirRaw->format('m')] . ' ' . $tglLahirRaw->format('Y');

    $tglAcc = $item->disetujui_at ? \Carbon\Carbon::parse($item->disetujui_at) : \Carbon\Carbon::now();
    $tglSuratIndo = $tglAcc->format('d') . ' ' . $bulanIndo[$tglAcc->format('m')] . ' ' . $tglAcc->format('Y');

    $tanah = null;
    if ($item->jenis_surat == 'Surat Keterangan Tanah' && !empty($item->keterangan)) {
    $tanah = json_decode($item->keterangan);
    }
    @endphp

    {{-- KOP SURAT --}}
    <table class="kop-surat">
        <tr>
            <td class="logo-cell">
                @if($logoBase64) <img src="{{ $logoBase64 }}" width="70"> @endif
            </td>
            <td class="text-cell">
                <h3>PEMERINTAH KABUPATEN {{ $profil->kabupaten ?? 'MATAHARI' }}</h3>
                <h3>KECAMATAN {{ $profil->kecamatan ?? 'MATAHARI' }}</h3>
                <h2>KANTOR KEPALA DESA {{ $profil->nama_desa ?? 'MATAHARI' }}</h2>
                <p>Alamat: {{ $profil->alamat ?? 'Jalan Raya Desa Matahari No. 1' }}</p>
            </td>
        </tr>
    </table>

    <div class="content">

        {{-- ========================================================== --}}
        {{-- 1. LAYOUT KHUSUS SURAT TANAH --}}
        {{-- ========================================================== --}}
        @if($item->jenis_surat == 'Surat Keterangan Tanah')
        <div class="judul-surat">SURAT KETERANGAN TANAH</div>
        <div class="nomor-surat">Nomor: 140 / {{ str_pad($item->id_surat, 3, '0', STR_PAD_LEFT) }} / {{ date('Y') }}</div>

        <p class="indent">Yang bertanda tangan di bawah ini:</p>
        <table class="data-table">
            <tr>
                <td class="label">Nama</td>
                <td class="titik">:</td>
                <td style="font-weight: bold;">{{ $profil->nama_kades ?? '................' }}</td>
            </tr>
            <tr>
                <td class="label">Jabatan</td>
                <td class="titik">:</td>
                <td>Kepala Desa {{ $profil->nama_desa ?? 'XYZ' }}</td>
            </tr>
        </table>

        <p class="indent">Menerangkan bahwa orang tersebut di bawah ini:</p>
        <table class="data-table">
            <tr>
                <td class="label">Nama Lengkap</td>
                <td class="titik">:</td>
                <td style="font-weight: bold;">{{ strtoupper($item->penduduk->nama) }}</td>
            </tr>
            <tr>
                <td class="label">NIK</td>
                <td class="titik">:</td>
                <td>{{ $item->penduduk->nik }}</td>
            </tr>
            <tr>
                <td class="label">Tempat/Tgl Lahir</td>
                <td class="titik">:</td>
                <td>{{ $item->penduduk->tempat_lahir }}, {{ $tglLahirIndo }}</td>
            </tr>
            <tr>
                <td class="label">Jenis Kelamin</td>
                <td class="titik">:</td>
                <td>{{ ($item->penduduk->jenis_kelamin == 'L') ? 'Laki-laki' : 'Perempuan' }}</td>
            </tr>
            <tr>
                <td class="label">Pekerjaan / Agama</td>
                <td class="titik">:</td>
                <td>{{ $item->penduduk->pekerjaan ?? '........................' }} / {{ $item->penduduk->agama ?? '........................' }}</td>
            </tr>
            <tr>
                <td class="label">Alamat</td>
                <td class="titik">:</td>
                <td>{{ $item->penduduk->alamat ?? $item->penduduk->dusun ?? 'Desa XYZ' }}</td>
            </tr>
        </table>

        <p class="indent">Adalah benar menguasai/memiliki sebidang tanah dengan keterangan sebagai berikut:</p>
        <table class="data-table">
            <tr>
                <td class="label">Luas Tanah</td>
                <td class="titik">:</td>
                <td>{{ $tanah->luas ?? '...............' }} m²</td>
            </tr>
            <tr>
                <td class="label">Letak Tanah</td>
                <td class="titik">:</td>
                <td>{{ $tanah->letak ?? '................................................................................................' }}</td>
            </tr>
            <tr>
                <td class="label">Status Penguasaan</td>
                <td class="titik">:</td>
                <td>{{ $tanah->status ?? 'Milik Sendiri / Warisan / Hibah / Jual Beli *)' }}</td>
            </tr>
            <tr>
                <td class="label">Penggunaan Tanah</td>
                <td class="titik">:</td>
                <td>{{ $tanah->guna ?? 'Rumah Tinggal / Pertanian / Perkebunan / Lainnya *)' }}</td>
            </tr>
            <tr>
                <td class="label">Tahun Perolehan</td>
                <td class="titik">:</td>
                <td>{{ $tanah->tahun ?? '................................................................................................' }}</td>
            </tr>
            <tr>
                <td class="label">Asal Tanah</td>
                <td class="titik">:</td>
                <td>{{ $tanah->asal ?? '................................................................................................' }}</td>
            </tr>
        </table>

        <p class="indent">Batas-batas tanah:</p>
        <table class="data-table">
            <tr>
                <td class="label">Sebelah Utara</td>
                <td class="titik">:</td>
                <td>{{ $tanah->u ?? '................................................................................................' }}</td>
            </tr>
            <tr>
                <td class="label">Sebelah Selatan</td>
                <td class="titik">:</td>
                <td>{{ $tanah->s ?? '................................................................................................' }}</td>
            </tr>
            <tr>
                <td class="label">Sebelah Timur</td>
                <td class="titik">:</td>
                <td>{{ $tanah->t ?? '................................................................................................' }}</td>
            </tr>
            <tr>
                <td class="label">Sebelah Barat</td>
                <td class="titik">:</td>
                <td>{{ $tanah->b ?? '................................................................................................' }}</td>
            </tr>
        </table>

        <p class="indent">Adapun sebagai saksi dalam surat keterangan ini adalah:</p>
        <table class="data-table">
            <tr>
                <td class="label">Saksi I</td>
                <td class="titik">:</td>
                <td>{{ $tanah->s1_nama ?? '...........................................' }} / NIK: {{ $tanah->s1_nik ?? '...........................................' }}</td>
            </tr>
            <tr>
                <td class="label">Saksi II</td>
                <td class="titik">:</td>
                <td>{{ $tanah->s2_nama ?? '...........................................' }} / NIK: {{ $tanah->s2_nik ?? '...........................................' }}</td>
            </tr>
        </table>

        {{-- BLOCK TANDA TANGAN DIBUNGKUS CLASS KEEP-TOGETHER BIAR GAK MISAH HALAMAN --}}
        <div class="keep-together">
            <p class="indent">Berdasarkan keterangan pemohon, para saksi, dan sepengetahuan Pemerintah Desa, tanah tersebut dikuasai oleh yang bersangkutan serta tidak dalam sengketa dengan pihak lain.</p>

            <p class="indent">Demikian surat keterangan ini dibuat dengan sebenarnya untuk dipergunakan sebagaimana mestinya.</p>

            {{-- Tanda Tangan 3 Kolom OTOMATIS SURAT TANAH --}}
            <table style="width: 100%; margin-top: 15px; text-align: center; border: none;">
                <tr>
                    <td style="width: 30%; color: transparent;">.</td>
                    <td style="width: 30%; color: transparent;">.</td>
                    <td style="width: 40%;">Desa {{ $profil->nama_desa ?? 'XYZ' }}, {{ $tglSuratIndo }}</td>
                </tr>
                <tr>
                    <td style="width: 30%;">Saksi I,</td>
                    <td style="width: 30%;">Saksi II,</td>
                    <td style="width: 40%;">Kepala Desa {{ $profil->nama_desa ?? 'XYZ' }}</td>
                </tr>
                <tr>
                    {{-- SAKSI 1 --}}
                    <td style="height: 85px; vertical-align: bottom;">
                        <br>
                        <strong>( <u>{{ $tanah->s1_nama ?? '........................' }}</u> )</strong>
                    </td>

                    {{-- SAKSI 2 --}}
                    <td style="height: 85px; vertical-align: bottom;">
                        <br>
                        <strong>( <u>{{ $tanah->s2_nama ?? '........................' }}</u> )</strong>
                    </td>

                    {{-- KEPALA DESA --}}
                    <td style="height: 85px; vertical-align: bottom; position: relative;">
                        @if($item->tte_code)
                        <div style="margin-bottom: 5px;">
                            @php
                            $qrCode = QrCode::size(60)->margin(0)->generate(url('/cek-surat/' . $item->tte_code));
                            $base64Qr = base64_encode($qrCode);
                            @endphp
                            <img src="data:image/svg+xml;base64,{{ $base64Qr }}" width="60" height="60">
                        </div>
                        @else
                        <div style="font-size: 10px; color: #666; margin-bottom: 5px;">Materai Rp10.000</div>
                        @endif
                        <strong>( <u>{{ $profil->nama_kades ?? '........................' }}</u> )</strong>
                    </td>
                </tr>
            </table>
        </div>


        {{-- ========================================================== --}}
        {{-- 2. LAYOUT STANDAR UNTUK SURAT LAINNYA (KTP, SKU, SKTM, dll) --}}
        {{-- ========================================================== --}}
        @else
        <div class="judul-surat">{{ strtoupper($item->jenis_surat) }}</div>
        <div class="nomor-surat">Nomor: 140 / {{ str_pad($item->id_surat, 3, '0', STR_PAD_LEFT) }} / {{ date('Y') }}</div>

        {{-- DIUBAH MENJADI TABEL AGAR SERAGAM DENGAN SURAT TANAH --}}
        <p class="indent">Yang bertanda tangan di bawah ini:</p>
        <table class="data-table">
            <tr>
                <td class="label">Nama</td>
                <td class="titik">:</td>
                <td style="font-weight: bold;">{{ $profil->nama_kades ?? '................' }}</td>
            </tr>
            <tr>
                <td class="label">Jabatan</td>
                <td class="titik">:</td>
                <td>Kepala Desa {{ $profil->nama_desa ?? 'XYZ' }}</td>
            </tr>
        </table>

        <p class="indent">Menerangkan dengan sebenarnya bahwa orang tersebut di bawah ini:</p>

        <table class="data-table">
            <tr>
                <td class="label">Nama Lengkap</td>
                <td class="titik">:</td>
                <td style="font-weight: bold;">{{ strtoupper($item->penduduk->nama) }}</td>
            </tr>
            <tr>
                <td class="label">NIK</td>
                <td class="titik">:</td>
                <td style="font-weight: bold;">{{ $item->penduduk->nik }}</td>
            </tr>
            <tr>
                <td class="label">Tempat, Tgl Lahir</td>
                <td class="titik">:</td>
                <td>{{ $item->penduduk->tempat_lahir }}, {{ $tglLahirIndo }}</td>
            </tr>
            <tr>
                <td class="label">Jenis Kelamin</td>
                <td class="titik">:</td>
                <td>{{ ($item->penduduk->jenis_kelamin == 'L') ? 'Laki-laki' : 'Perempuan' }}</td>
            </tr>
            <tr>
                <td class="label">Agama</td>
                <td class="titik">:</td>
                <td>{{ $item->penduduk->agama ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Pekerjaan</td>
                <td class="titik">:</td>
                <td>{{ $item->penduduk->pekerjaan ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Status Perkawinan</td>
                <td class="titik">:</td>
                <td>{{ $item->penduduk->status_perkawinan ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Alamat / Dusun</td>
                <td class="titik">:</td>
                <td>{{ $item->penduduk->alamat ?? $item->penduduk->dusun ?? 'Desa XYZ' }}</td>
            </tr>
        </table>

        {{-- PARAGRAF ISI DISESUAIKAN, KEPERLUAN/ADMINISTRASI DIHILANGKAN BIAR RAPI --}}
        @if($item->jenis_surat == 'Surat Keterangan Usaha' || $item->jenis_surat == 'Surat Keterangan Usaha (SKU)')
        <p class="indent">Berdasarkan pengamatan kami, nama tersebut di atas adalah benar warga yang berdomisili di Desa {{ $profil->nama_desa ?? 'XYZ' }} dan benar-benar memiliki usaha/kegiatan di bidang: <strong>{{ $item->keterangan ?? '........................................................' }}</strong>.</p>

        @elseif($item->jenis_surat == 'Surat Keterangan Tidak Mampu' || $item->jenis_surat == 'Surat Keterangan Tidak Mampu (SKTM)')
        <p class="indent">Berdasarkan data kependudukan dan hasil pemantauan sosial di lapangan, orang tersebut di atas adalah benar warga Desa {{ $profil->nama_desa ?? 'XYZ' }} yang tergolong dalam keluarga pra-sejahtera atau <strong>Tidak Mampu</strong>.</p>

        @elseif($item->jenis_surat == 'Surat Pengantar SKCK')
        <p class="indent">Bahwa orang tersebut di atas adalah benar warga Desa {{ $profil->nama_desa ?? 'XYZ' }} yang berkelakuan baik, bermasyarakat secara normal, serta tidak sedang terlibat dalam proses pelanggaran hukum atau tindak kriminalitas apa pun.</p>

        @elseif($item->jenis_surat == 'Surat Keterangan Domisili')
        <p class="indent">Adalah benar penduduk tetap yang sah berdomisili dan menetap di lingkungan Desa {{ $profil->nama_desa ?? 'XYZ' }}.</p>

        @else
        {{-- UNTUK SURAT UMUM LAINNYA --}}
        <p class="indent">Adalah benar warga Desa {{ $profil->nama_desa ?? 'XYZ' }}, dan surat keterangan ini dikeluarkan secara resmi untuk dipergunakan sebagaimana mestinya.</p>
        @endif

        {{-- BLOCK TANDA TANGAN DIBUNGKUS CLASS KEEP-TOGETHER --}}
        <div class="keep-together">
            @if($item->jenis_surat != 'Surat Umum Lainnya')
            <p class="penutup">Demikian surat keterangan ini diberikan kepada yang bersangkutan untuk dapat dipergunakan sebagaimana mestinya.</p>
            @endif

            {{-- TANDA TANGAN SURAT STANDAR --}}
            <div class="footer-ttd">
                <p>Desa {{ $profil->nama_desa ?? 'XYZ' }}, {{ $tglSuratIndo }}</p>
                <p style="margin-bottom: 5px;">Kepala Desa {{ $profil->nama_desa ?? 'XYZ' }},</p>

                @if($item->tte_code)
                <div class="qr-wrapper">
                    @php
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
                {{-- Kalau nggak ada TTE, kasih spasi buat tanda tangan basah --}}
                <br><br><br><br>
                @endif

                <p style="margin-top: 10px;">
                    <strong><u>{{ $profil->nama_kades ?? '........................' }}</u></strong>
                </p>
            </div>
            <div class="clear"></div>
        </div>
        @endif
        {{-- AKHIR LAYOUT STANDAR --}}

    </div>
    @endif
</body>

</html>