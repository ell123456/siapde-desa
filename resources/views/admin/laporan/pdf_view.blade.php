<!DOCTYPE html>
<html>

<head>
    <title>Laporan Data Surat</title>
    <style>
        /* Standar Kertas Laporan A4 */
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

        /* KOP SURAT IDENTIK */
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
            font-weight: bold;
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
            font-weight: bold;
            font-style: italic;
        }

        /* JUDUL HALAMAN DINAMIS PER BULAN */
        .judul-halaman {
            text-align: center;
            font-weight: bold;
            text-decoration: underline;
            margin: 20px 0;
            font-size: 13pt;
            text-transform: uppercase;
            line-height: 1.5;
        }

        /* TABEL DATA */
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

        /* TANDA TANGAN */
        .footer-ttd {
            margin-top: 30px;
            float: right;
            width: 250px;
            text-align: center;
        }
    </style>
</head>

<body>

    @php
    $bulanIndo = [
    '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
    '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
    '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
    ];
    @endphp

    <table class="kop-surat">
        <tr>
            <td class="logo-cell">
                @if(isset($logoBase64) && $logoBase64)
                <img src="{{ $logoBase64 }}" width="90">
                @endif
            </td>
            <td class="text-cell">
                <h3>PEMERINTAH KABUPATEN XYZ</h3>
                <h3>KECAMATAN XYZ</h3>
                <h2>KANTOR KEPALA DESA XYZ</h2>
                <p>Alamat: DI - XYZ - Kode Pos 0000</p>
            </td>
        </tr>
    </table>

    {{-- KUNCI FILTER DINAMIS: Judul otomatis berganti mengikuti request form dropdown --}}
    <div class="judul-halaman">
        LAPORAN DATA SURAT PENGAJUAN
        @if(!empty($bulan) && isset($bulanIndo[$bulan]))
        <br><span style="font-size: 11pt; font-weight: normal; text-decoration: none;">PERIODE: {{ strtoupper($bulanIndo[$bulan]) }} {{ $tahun }}</span>
        @else
        <br><span style="font-size: 11pt; font-weight: normal; text-decoration: none;">PERIODE TAHUN: {{ $tahun }}</span>
        @endif
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Nama Penduduk / NIK</th>
                <th width="25%">Jenis Surat</th>
                <th width="20%">Tanggal Pengajuan</th>
                <th width="15%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($surats as $key => $item)
            <tr>
                <td class="text-center">{{ $key + 1 }}</td>
                <td>
                    <div style="font-weight: bold; font-size: 10.5pt;">{{ strtoupper($item->penduduk->nama ?? 'Data Tidak Ditemukan') }}</div>
                    <div style="color: #444; font-size: 8.5pt; margin-top: 2px;">NIK: {{ $item->penduduk->nik ?? '-' }}</div>
                </td>
                <td>{{ $item->jenis_surat }}</td>
                <td class="text-center">
                    @php
                    $tglInput = $item->tanggal_pengajuan ?? $item->created_at;
                    $tgl = \Carbon\Carbon::parse($tglInput);
                    echo $tgl->format('d') . ' ' . $bulanIndo[$tgl->format('m')] . ' ' . $tgl->format('Y');
                    @endphp
                </td>
                <td class="text-center" style="font-weight: bold;">{{ strtoupper($item->status) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center" style="padding: 30px; color: #666; font-style: italic;">
                    Tidak ada data surat pengajuan pada periode ini.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer-ttd">
        @php
        $tglSekarang = \Carbon\Carbon::now();
        $hariIni = $tglSekarang->format('d') . ' ' . $bulanIndo[$tglSekarang->format('m')] . ' ' . $tglSekarang->format('Y');
        @endphp
        <p>Xyz, {{ $hariIni }}</p>
        <p>Kepala Desa Xyz,</p>
        <div style="height: 60px;"></div>
        <p><strong>( ________________________ )</strong></p>
    </div>

</body>

</html>