@extends('layouts.admin')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet">

<style>
    .siapde-dashboard-wrapper {
        font-family: 'Poppins', sans-serif !important;
        background-color: #f4f7fe;
        padding: 12px 15px 20px 15px !important;
        min-height: 100vh;
        box-sizing: border-box;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .stat-card {
        transition: 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.07) !important;
    }

    .card-dashboard {
        background: white;
        border-radius: 20px;
        padding: 28px;
        border: 1px solid #e8eef6;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
    }

    div::-webkit-scrollbar {
        width: 5px;
    }

    div::-webkit-scrollbar-track {
        background: #f4f7fe;
    }

    div::-webkit-scrollbar-thumb {
        background: #d0dff0;
        border-radius: 10px;
    }
</style>

<div class="siapde-dashboard-wrapper" style="animation: fadeIn 0.6s ease-out;">
    @php
    $bulanIndo = ['01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'];
    $tglIndo = date('d') . ' ' . $bulanIndo[date('m')] . ' ' . date('Y');
    $namaBulanSekarang = $bulanIndo[date('m')];
    @endphp

    {{-- 1. BANNER PROFIL DESA --}}
    <div style="
        background: white;
        border-radius: 20px;
        padding: 28px 40px;
        margin-bottom: 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border: 1px solid #e8eef6;
        position: relative;
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(26, 58, 92, 0.06);
    ">
        <div style="position: absolute; right: -10px; top: -30px; font-size: 160px; color: #f0f6fc; z-index: 0; opacity: 0.6;">
            <i class="fas fa-landmark"></i>
        </div>

        <div style="position: relative; z-index: 1;">
            <div style="display: inline-block; background: #e6f1fb; color: #1a3a5c; padding: 5px 14px; border-radius: 50px; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 1.2px; margin-bottom: 12px; border: 1px solid #c5ddf4;">
                <i class="fas fa-info-circle mr-1"></i> Informasi Wilayah
            </div>
            <h1 style="font-weight: 800; font-size: 28px; color: #1a3a5c; margin: 0 0 5px 0; letter-spacing: -0.5px;">
                Desaku {{ $profil->nama_desa ?? 'Digital' }}
            </h1>
            <p style="margin: 0; color: #7a92a8; font-size: 13px;">Selamat datang di Pusat Administrasi Digital Terpadu.</p>
        </div>

        <div style="text-align: right; border-left: 2px solid #e8eef6; padding-left: 40px; position: relative; z-index: 1;">
            <div id="clock-banner" style="font-size: 34px; font-weight: 800; color: #2e86c1; line-height: 1; letter-spacing: -1px;">00:00:00</div>
            <div style="font-size: 13px; font-weight: 600; color: #94a3b8; margin-top: 8px; text-transform: uppercase; letter-spacing: 1px;">{{ $tglIndo }}</div>
        </div>
    </div>

    {{-- 2. STATS GRID --}}
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 28px;">
        @foreach([
        ['label'=>'Total Penduduk', 'val'=>$totalPenduduk ?? 0, 'u'=>'Jiwa', 'i'=>'fa-users', 'c'=>'#2e86c1', 'bg'=>'#e6f1fb'],
        ['label'=>'Menunggu Verifikasi', 'val'=>$suratPending ?? 0, 'u'=>'Dokumen', 'i'=>'fa-clock-rotate-left','c'=>'#e67e22','bg'=>'#faeeda'],
        ['label'=>'Layanan Selesai', 'val'=>$suratSelesai ?? 0, 'u'=>'Arsip', 'i'=>'fa-circle-check', 'c'=>'#27ae60', 'bg'=>'#eaf3de'],
        ] as $s)
        <div class="stat-card" style="background: white; padding: 24px; border-radius: 18px; border: 1px solid #e8eef6; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 2px 8px rgba(0,0,0,0.02);">
            <div>
                <div style="font-size: 10px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">{{ $s['label'] }}</div>
                <div style="font-size: 26px; font-weight: 800; color: #1a3a5c; display: flex; align-items: baseline; gap: 5px;">
                    {{ $s['val'] }}
                    <span style="font-size: 12px; font-weight: 500; color: #b0bec5;">{{ $s['u'] }}</span>
                </div>
            </div>
            <div style="background: {{ $s['bg'] }}; color: {{ $s['c'] }}; width: 48px; height: 48px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                <i class="fas {{ $s['i'] }}"></i>
            </div>
        </div>
        @endforeach
    </div>

    {{-- 3. CHART PANEL --}}
    <div style="display: grid; grid-template-columns: 1.3fr 1.7fr; gap: 22px; margin-bottom: 28px;">

        {{-- GRAFIK PENDUDUK --}}
        <div class="card-dashboard" style="display: flex; flex-direction: column;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 20px;">
                <div style="background: #e6f1fb; color: #2e86c1; width: 38px; height: 38px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 15px;">
                    <i class="fas fa-chart-pie"></i>
                </div>
                <h6 style="margin: 0; font-weight: 700; font-size: 11px; color: #1a3a5c; text-transform: uppercase; letter-spacing: 1px;">Grafik Warga</h6>
            </div>
            <div style="display: flex; align-items: center; justify-content: space-between; flex-grow: 1; gap: 15px; height: 200px;">
                <div style="position: relative; width: 55%; height: 100%;">
                    <canvas id="chartJkSIAPDE"></canvas>
                </div>
                <div style="width: 45%; display: flex; flex-direction: column; gap: 14px; justify-content: center;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <span style="width: 12px; height: 12px; background: #2e86c1; border-radius: 4px; display: inline-block; flex-shrink: 0;"></span>
                        <div style="font-size: 12px; font-weight: 600; color: #475569;">Laki-laki ({{ $jumlahLaki ?? 0 }})</div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <span style="width: 12px; height: 12px; background: #e67e22; border-radius: 4px; display: inline-block; flex-shrink: 0;"></span>
                        <div style="font-size: 12px; font-weight: 600; color: #475569;">Perempuan ({{ $jumlahPerempuan ?? 0 }})</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- GRAFIK SURAT TAHUNAN (12 BULAN) --}}
        <div class="card-dashboard" style="display: flex; flex-direction: column;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 15px;">
                <div style="background: #eaf3de; color: #27ae60; width: 38px; height: 38px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 15px;">
                    <i class="fas fa-envelope-open-text"></i>
                </div>
                <h6 style="margin: 0; font-weight: 700; font-size: 11px; color: #1a3a5c; text-transform: uppercase; letter-spacing: 1px;">Pelayanan Surat Tahun Ini</h6>
            </div>
            <div style="position: relative; height: 200px; width: 100%; flex-grow: 1;">
                <canvas id="chartSuratSIAPDE"></canvas>
            </div>
        </div>
    </div>

    {{-- 4. STRUKTUR PEMERINTAHAN --}}
    <div style="margin-bottom: 28px;">
        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 16px;">
            <div style="width: 4px; height: 16px; background: #2e86c1; border-radius: 10px;"></div>
            <h6 style="font-weight: 700; font-size: 11px; color: #1a3a5c; text-transform: uppercase; letter-spacing: 1px; margin: 0;">Struktur Pemerintahan</h6>
        </div>
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px;">
            @php
            $aparat = [
            ['nama' => $profil->nama_kades ?? 'Belum Diatur', 'jab' => 'Kepala Desa', 'icon' => 'fa-user-tie'],
            ['nama' => $profil->nama_sekdes ?? 'Belum Diatur', 'jab' => 'Sekretaris Desa', 'icon' => 'fa-user-shield'],
            ['nama' => $profil->nama_kaur ?? 'Belum Diatur', 'jab' => 'Kaur Umum', 'icon' => 'fa-users-gear'],
            ['nama' => $profil->nama_bendahara?? 'Belum Diatur', 'jab' => 'Bendahara Desa', 'icon' => 'fa-coins'],
            ['nama' => $profil->nama_kasi ?? 'Belum Diatur', 'jab' => 'Kasi Pemerintahan', 'icon' => 'fa-landmark'],
            ['nama' => $profil->nama_kadus ?? 'Belum Diatur', 'jab' => 'Kepala Dusun', 'icon' => 'fa-id-badge'],
            ];
            @endphp
            @foreach($aparat as $p)
            <div style="background: white; padding: 16px 20px; border-radius: 16px; border: 1px solid #e8eef6; display: flex; align-items: center; gap: 16px;">
                <div style="background: #e6f1fb; color: #2e86c1; width: 42px; height: 42px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 15px;">
                    <i class="fas {{ $p['icon'] }}"></i>
                </div>
                <div style="overflow: hidden;">
                    <div style="font-size: 13px; font-weight: 700; color: #1a3a5c; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $p['nama'] }}</div>
                    <div style="font-size: 10px; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px;">{{ $p['jab'] }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- 5. VISI & MISI --}}
    <div style="display: grid; grid-template-columns: 1fr 1.5fr; gap: 22px; align-items: stretch;">
        <div class="card-dashboard" style="display: flex; flex-direction: column;">
            <div style="display: flex; align-items: center; gap: 14px; margin-bottom: 22px;">
                <div style="background: #e6f1fb; color: #2e86c1; width: 46px; height: 46px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-eye fa-lg"></i>
                </div>
                <h6 style="margin: 0; font-weight: 700; font-size: 11px; color: #2e86c1; text-transform: uppercase; letter-spacing: 1px;">Visi Strategis</h6>
            </div>
            <div style="flex-grow: 1; display: flex; align-items: center; background: #f8fbff; padding: 18px; border-radius: 12px; border-left: 4px solid #2e86c1;">
                <p style="font-size: 13.5px; color: #475569; line-height: 1.8; font-style: italic; margin: 0;">
                    "{{ $profil->visi ?? 'Visi desa belum diatur dalam profil.' }}"
                </p>
            </div>
        </div>

        <div class="card-dashboard" style="display: flex; flex-direction: column;">
            <div style="display: flex; align-items: center; gap: 14px; margin-bottom: 22px;">
                <div style="background: #e6f1fb; color: #2e86c1; width: 46px; height: 46px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-bullseye fa-lg"></i>
                </div>
                <h6 style="margin: 0; font-weight: 700; font-size: 11px; color: #2e86c1; text-transform: uppercase; letter-spacing: 1px;">Misi Strategis</h6>
            </div>
            <div style="max-height: 200px; overflow-y: auto; padding-right: 10px;">
                @php
                $misi = isset($profil->misi) ? preg_split('/\r\n|\r|\n|-/', $profil->misi) : [];
                $misi = array_filter(array_map('trim', $misi));
                @endphp
                @forelse($misi as $idx => $m)
                <div style="display: flex; gap: 14px; margin-bottom: 14px; align-items: flex-start;">
                    <span style="background: #2e86c1; color: white; font-weight: 700; font-size: 10px; width: 24px; height: 24px; border-radius: 6px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        {{ sprintf('%02d', $idx + 1) }}
                    </span>
                    <div style="font-size: 13px; color: #64748b; line-height: 1.6; padding-top: 2px;">{{ $m }}</div>
                </div>
                @empty
                <div style="font-size: 13px; color: #cbd5e1; text-align: center; padding: 20px;">Misi belum tersedia.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/chart.js') }}"></script>
<script>
    function updateClock() {
        const now = new Date();
        const h = String(now.getHours()).padStart(2, '0');
        const m = String(now.getMinutes()).padStart(2, '0');
        const s = String(now.getSeconds()).padStart(2, '0');
        const el = document.getElementById('clock-banner');
        if (el) el.textContent = h + ':' + m + ':' + s;
    }
    setInterval(updateClock, 1000);
    updateClock();

    document.addEventListener("DOMContentLoaded", function() {
        var dataLaki = Number("{{ $jumlahLaki ?? 0 }}");
        var dataPerempuan = Number("{{ $jumlahPerempuan ?? 0 }}");
        var totalPenduduk = Number("{{ $totalPenduduk ?? 0 }}");
        var suratBulanIni = Number("{{ $suratBulanIni ?? 0 }}");
        var currentMonthIdx = Number("{{ date('n') }}");

        var dataBulanan = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        dataBulanan[currentMonthIdx - 1] = suratBulanIni;

        // GRAFIK DONUT PENDUDUK
        var ctxJk = document.getElementById('chartJkSIAPDE').getContext('2d');
        new Chart(ctxJk, {
            type: 'doughnut',
            data: {
                labels: ['Laki-laki', 'Perempuan'],
                datasets: [{
                    data: [dataLaki, dataPerempuan],
                    backgroundColor: ['#2e86c1', '#e67e22'],
                    borderWidth: 2,
                    hoverBorderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                cutout: '75%'
            },
            plugins: [{
                id: 'centerText',
                beforeDraw: function(chart) {
                    if (chart.getDatasetMeta(0).data[0]) {
                        var ctx = chart.ctx;
                        var x = chart.getDatasetMeta(0).data[0].x;
                        var y = chart.getDatasetMeta(0).data[0].y;
                        ctx.save();
                        ctx.font = "bold 24px Poppins";
                        ctx.textBaseline = "middle";
                        ctx.textAlign = "center";
                        ctx.fillStyle = "#1a3a5c";
                        ctx.fillText(totalPenduduk, x, y - 8);
                        ctx.font = "700 9px Poppins";
                        ctx.fillStyle = "#94a3b8";
                        ctx.fillText("TOTAL JIWA", x, y + 13);
                        ctx.restore();
                    }
                }
            }]
        });

        // GRAFIK BAR SURAT TAHUNAN
        var ctxSurat = document.getElementById('chartSuratSIAPDE').getContext('2d');
        new Chart(ctxSurat, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: 'Jumlah Berkas',
                    data: dataBulanan,
                    backgroundColor: ['#2e86c1'],
                    borderRadius: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        top: 25
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            font: {
                                family: 'Poppins',
                                size: 11
                            }
                        },
                        grid: {
                            color: '#f0f6fc'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                family: 'Poppins',
                                size: 12,
                                weight: '700'
                            },
                            color: '#1a3a5c'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            },
            plugins: [{
                id: 'barLabels',
                afterDatasetsDraw: function(chart) {
                    chart.data.datasets.forEach(function(dataset, i) {
                        chart.getDatasetMeta(i).data.forEach(function(bar, index) {
                            var ctx = chart.ctx;
                            ctx.fillStyle = '#1a3a5c';
                            ctx.font = "bold 13px Poppins";
                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'bottom';
                            ctx.fillText(dataset.data[index], bar.x, bar.y - 5);
                        });
                    });
                }
            }]
        });
    });
</script>
@endsection