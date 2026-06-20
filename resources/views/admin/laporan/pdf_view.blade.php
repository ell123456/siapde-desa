<!DOCTYPE html>
<html>

<head>
    <title>Laporan Data Surat</title>
    <style>
        @page {
            margin: 1cm 2cm;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            margin: 0;
            padding: 0;
            color: #000;
        }

        .kop-surat {
            width: 100%;
            border-bottom: 4px double #000;
            padding-bottom: 5px;
            margin-bottom: 20px;
        }

        .logo-cell {
            width: 100px;
            text-align: left;
            vertical-align: middle;
        }

        .text-cell {
            text-align: center;
            padding-right: 45px;
        }

        .text-cell h3 {
            margin: 0;
            font-size: 13pt;
            text-transform: uppercase;
        }

        .text-cell h2 {
            margin: 0;
            font-size: 15pt;
            font-weight: bold;
            text-transform: uppercase;
        }

        .text-cell p {
            margin: 3px 0 0 0;
            font-size: 9pt;
            font-style: italic;
        }

        .judul-halaman {
            text-align: center;
            font-weight: bold;
            text-decoration: underline;
            margin: 20px 0 5px 0;
            font-size: 13pt;
            text-transform: uppercase;
            line-height: 1.6;
        }

        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 10pt;
        }

        table.data-table th,
        table.data-table td {
            border: 1px solid black;
            padding: 6px 8px;
            vertical-align: middle;
        }

        table.data-table th {
            background-color: #f2f2f2;
            text-align: center;
            font-weight: bold;
            text-transform: uppercase;
        }

        .text-center {
            text-align: center;
        }

        .rekap-table {
            width: 55%;
            margin-top: 20px;
            border-collapse: collapse;
            font-size: 10pt;
        }

        .rekap-table th,
        .rekap-table td {
            border: 1px solid black;
            padding: 5px 8px;
        }

        .rekap-table th {
            background-color: #f2f2f2;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>

<body>
    @php
    $bulanIndo = [
    '01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April',
    '05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus',
    '09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'
    ];

    // Filter hanya yang selesai
    $suratSelesai = $surats->where('status', 'selesai')->values();

    // Hitung per jenis surat
    $statistik = $suratSelesai->groupBy('jenis_surat');
    $totalSemua = $suratSelesai->count();
    @endphp

    {{-- KOP SURAT --}}
    <table class="kop-surat">
        <tr>
            <td class="logo-cell">
                @if(isset($logoBase64) && $logoBase64)
                <img src="{{ $logoBase64 }}" width="90">
                @endif
            </td>
            <td class="text-cell">
                <h3>PEMERINTAH KABUPATEN {{ strtoupper($profil->kabupaten ?? 'XYZ') }}</h3>
                <h3>KECAMATAN {{ strtoupper($profil->kecamatan ?? 'XYZ') }}</h3>
                <h2>KANTOR KEPALA DESA {{ strtoupper($profil->nama_desa ?? 'XYZ') }}</h2>
                <p>Alamat: {{ $profil->alamat ?? 'Alamat Desa' }}</p>
            </td>
        </tr>
    </table>

    {{-- JUDUL --}}
    <div class="judul-halaman">
        LAPORAN DATA PELAYANAN SURAT
        @if(!empty($bulan) && isset($bulanIndo[$bulan]))
        <br><span style="font-size: 11pt; font-weight: normal; text-decoration: none;">
            Periode: {{ strtoupper($bulanIndo[$bulan]) }} {{ $tahun }}
        </span>
        @else
        <br><span style="font-size: 11pt; font-weight: normal; text-decoration: none;">
            Periode Tahun {{ $tahun }}
        </span>
        @endif
    </div>

    {{-- TABEL DATA --}}
    <table class="data-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="30%">Nama Penduduk / NIK</th>
                <th width="30%">Jenis Surat</th>
                <th width="20%">Tanggal Pengajuan</th>
                <th width="15%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($suratSelesai as $key => $item)
            <tr>
                <td class="text-center">{{ $key + 1 }}</td>
                <td>
                    <div style="font-weight: bold; font-size: 10.5pt;">{{ strtoupper($item->penduduk->nama ?? 'Data Tidak Ditemukan') }}</div>
                    <div style="font-size: 8.5pt; color: #444; margin-top: 2px;">NIK: {{ $item->penduduk->nik ?? '-' }}</div>
                </td>
                <td>{{ $item->jenis_surat }}</td>
                <td class="text-center">
                    @php
                    $tgl = \Carbon\Carbon::parse($item->tanggal_pengajuan ?? $item->created_at);
                    echo $tgl->format('d') . ' ' . $bulanIndo[$tgl->format('m')] . ' ' . $tgl->format('Y');
                    @endphp
                </td>
                <td class="text-center" style="font-weight: bold;">SELESAI</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center" style="padding: 30px; color: #666; font-style: italic;">
                    Tidak ada data surat yang selesai pada periode ini.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- REKAPITULASI PER JENIS SURAT --}}
    @if($totalSemua > 0)
    <div style="margin-top: 25px;">
        <div style="font-weight: bold; font-size: 11pt; margin-bottom: 8px; text-decoration: underline;">
            REKAPITULASI SURAT PER JENIS
        </div>
        <table class="rekap-table">
            <thead>
                <tr>
                    <th width="10%">No</th>
                    <th>Jenis Surat</th>
                    <th width="20%">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @foreach($statistik as $jenis => $kumpulan)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $jenis }}</td>
                    <td class="text-center">{{ $kumpulan->count() }}</td>
                </tr>
                @endforeach
                <tr style="font-weight: bold; background-color: #f2f2f2;">
                    <td colspan="2" style="text-align: right; padding-right: 10px;">TOTAL KESELURUHAN</td>
                    <td class="text-center">{{ $totalSemua }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    @endif

    {{-- INFO CETAK --}}
    <div style="margin-top: 30px; font-size: 9pt; color: #666; font-style: italic;">
        Dicetak pada: {{ \Carbon\Carbon::now()->format('d') . ' ' . $bulanIndo[\Carbon\Carbon::now()->format('m')] . ' ' . \Carbon\Carbon::now()->format('Y H:i') }} WIB
    </div>

</body>

</html>