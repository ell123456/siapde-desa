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
            margin: 20px 0;
            font-size: 13pt;
            text-transform: uppercase;
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
        }

        .text-center {
            text-align: center;
        }

        .rekap-table {
            width: 40%;
            margin-top: 20px;
            border-collapse: collapse;
            font-size: 10pt;
        }

        .rekap-table th,
        .rekap-table td {
            border: 1px solid black;
            padding: 5px;
        }
    </style>
</head>

<body>
    @php
    $bulanIndo = ['01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'];

    // Filter data yang disetujui saja
    $suratValid = $surats->whereIn('status', ['disetujui', 'selesai'])->values();

    // Hitung statistik per jenis surat
    $statistik = $suratValid->groupBy('jenis_surat');
    $totalSemua = $suratValid->count();
    @endphp

    <table class="kop-surat">
        <tr>
            <td class="logo-cell">
                @if(isset($logoBase64) && $logoBase64) <img src="{{ $logoBase64 }}" width="90"> @endif
            </td>
            <td class="text-cell">
                <h3>PEMERINTAH KABUPATEN {{ $profil->kabupaten ?? '................' }}</h3>
                <h3>KECAMATAN {{ $profil->kecamatan ?? '................' }}</h3>
                <h2>KANTOR KEPALA DESA {{ $profil->nama_desa ?? '................' }}</h2>
                <p>Alamat: {{ $profil->alamat ?? '................................................' }}</p>
            </td>
        </tr>
    </table>

    <div class="judul-halaman">LAPORAN DATA SURAT PENGAJUAN</div>

    <table class="data-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Nama Penduduk / NIK</th>
                <th>Jenis Surat</th>
                <th>Tanggal Pengajuan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($suratValid as $key => $item)
            <tr>
                <td class="text-center">{{ $key + 1 }}</td>
                <td>
                    <div style="font-weight: bold;">{{ strtoupper($item->penduduk->nama ?? '-') }}</div>
                    <div style="font-size: 9pt;">NIK: {{ $item->penduduk->nik ?? '-' }}</div>
                </td>
                <td>{{ $item->jenis_surat }}</td>
                <td class="text-center">
                    @php
                    $tgl = \Carbon\Carbon::parse($item->tanggal_pengajuan ?? $item->created_at);
                    echo $tgl->format('d') . ' ' . $bulanIndo[$tgl->format('m')] . ' ' . $tgl->format('Y');
                    @endphp
                </td>
                <td class="text-center" style="font-weight: bold; color: green;">{{ strtoupper($item->status) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Tidak ada data surat yang disetujui.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- TABEL REKAPITULASI (OTOMATIS) --}}
    <div style="margin-top: 30px;">
        <h3 style="margin-bottom: 5px;">Rekapitulasi Surat</h3>
        <table class="rekap-table">
            <thead>
                <tr>
                    <th style="background-color: #f2f2f2;">Jenis Surat</th>
                    <th style="background-color: #f2f2f2;">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @foreach($statistik as $jenis => $kumpulanSurat)
                <tr>
                    <td>{{ $jenis }}</td>
                    <td class="text-center">{{ $kumpulanSurat->count() }}</td>
                </tr>
                @endforeach
                <tr style="font-weight: bold;">
                    <td>TOTAL KESELURUHAN</td>
                    <td class="text-center">{{ $totalSemua }}</td>
                </tr>
            </tbody>
        </table>
    </div>

</body>

</html>