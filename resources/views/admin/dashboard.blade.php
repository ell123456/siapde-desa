@extends('layouts.admin')

@section('content')
{{-- Container utama ditarik mepet ke atas --}}
<div class="container-fluid" style="padding-top: 5px; animation: fadeIn 0.8s ease-out; font-family: 'Poppins', sans-serif;">
    @php
    $bulanIndo = ['01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'];
    $tglIndo = date('d') . ' ' . $bulanIndo[date('m')] . ' ' . date('Y');
    @endphp

    {{-- 1. BANNER PROFIL DESA --}}
    <div class="banner-profil" style="
        background: white; 
        border-radius: 24px; 
        padding: 30px 45px; 
        margin-bottom: 25px; 
        display: flex; 
        justify-content: space-between; 
        align-items: center; 
        border: 1px solid rgba(34, 211, 238, 0.15); 
        position: relative; 
        overflow: hidden;
        box-shadow: 
            -15px -15px 30px rgba(34, 211, 238, 0.08), 
            15px -15px 30px rgba(34, 211, 238, 0.08),  
            -15px 15px 30px rgba(34, 211, 238, 0.08),  
            15px 15px 30px rgba(34, 211, 238, 0.08);
    ">
        {{-- Watermark Landmark --}}
        <div style="position: absolute; right: -10px; top: -30px; font-size: 180px; color: #f1f5f9; z-index: 0; opacity: 0.5;"><i class="fas fa-landmark"></i></div>

        <div style="position: relative; z-index: 1;">
            <div style="display: inline-block; background: linear-gradient(135deg, #ecfeff 0%, #cffafe 100%); color: #0891b2; padding: 6px 16px; border-radius: 50px; font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 12px; border: 1px solid rgba(8, 145, 178, 0.1);">
                <i class="fas fa-info-circle mr-1"></i> Informasi Wilayah
            </div>
            <h1 style="font-weight: 800; font-size: 30px; color: #1e3a8a; margin: 0 0 5px 0; letter-spacing: -0.5px;">Desa {{ $profil->nama_desa ?? 'Digital' }}</h1>
            <p style="margin: 0; color: #64748b; font-size: 14px; font-weight: 400;">Selamat datang di Pusat Administrasi Digital Terpadu.</p>
        </div>

        <div style="text-align: right; border-left: 2px solid #f1f5f9; padding-left: 45px; position: relative; z-index: 1;">
            {{-- ID DISINI ADALAH clock-banner --}}
            <div id="clock-banner" style="font-size: 36px; font-weight: 800; color: #06b6d4; line-height: 1; letter-spacing: -1.5px;">00:00:00</div>
            <div style="font-size: 14px; font-weight: 600; color: #94a3b8; margin-top: 8px; text-transform: uppercase; letter-spacing: 1px;">{{ $tglIndo }}</div>
        </div>
    </div>

    {{-- 2. STATS GRID --}}
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 22px; margin-bottom: 30px;">
        @foreach([
        ['label'=>'Total Penduduk','val'=>$totalPenduduk ?? 0,'u'=>'Jiwa','i'=>'fa-users','c'=>'#06b6d4'],
        ['label'=>'Menunggu Verifikasi','val'=>$suratPending ?? 0,'u'=>'Dokumen','i'=>'fa-clock-rotate-left','c'=>'#f59e0b'],
        ['label'=>'Layanan Selesai','val'=>$suratSelesai ?? 0,'u'=>'Arsip','i'=>'fa-circle-check','c'=>'#10b981']
        ] as $s)
        <div class="stat-card" style="background: white; padding: 25px; border-radius: 22px; border: 1px solid #eef2f6; display: flex; align-items: center; justify-content: space-between; transition: 0.3s ease; box-shadow: 0 4px 12px rgba(0,0,0,0.02);">
            <div>
                <div style="font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">{{ $s['label'] }}</div>
                <div style="font-size: 26px; font-weight: 800; color: #1e3a8a; display: flex; align-items: baseline; gap: 5px;">
                    {{ $s['val'] }}
                    <span style="font-size: 13px; font-weight: 500; color: #cbd5e1;">{{ $s['u'] }}</span>
                </div>
            </div>
            <div style="background: {{ $s['c'] }}12; color: {{ $s['c'] }}; width: 50px; height: 50px; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                <i class="fas {{ $s['i'] }}"></i>
            </div>
        </div>
        @endforeach
    </div>

    {{-- 3. STRUKTUR PEMERINTAHAN --}}
    <div style="margin-bottom: 30px;">
        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 18px;">
            <div style="width: 4px; height: 18px; background: #06b6d4; border-radius: 10px;"></div>
            <h6 style="font-weight: 800; font-size: 12px; color: #1e3a8a; text-transform: uppercase; letter-spacing: 1px; margin: 0;">Struktur Pemerintahan</h6>
        </div>
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 18px;">
            @php
            $aparat = [
            ['nama' => $profil->nama_kades ?? 'Belum Diatur', 'jab' => 'Kepala Desa', 'icon' => 'fa-user-tie'],
            ['nama' => $profil->nama_sekdes ?? 'Belum Diatur', 'jab' => 'Sekretaris Desa', 'icon' => 'fa-user-shield'],
            ['nama' => $profil->nama_kaur ?? 'Belum Diatur', 'jab' => 'Kaur Umum', 'icon' => 'fa-users-gear'],
            ['nama' => $profil->nama_bendahara ?? 'Belum Diatur', 'jab' => 'Bendahara Desa', 'icon' => 'fa-coins'],
            ['nama' => $profil->nama_kasi ?? 'Belum Diatur', 'jab' => 'Kasi Pemerintahan', 'icon' => 'fa-landmark'],
            ['nama' => $profil->nama_kadus ?? 'Belum Diatur', 'jab' => 'Kepala Dusun', 'icon' => 'fa-id-badge'],
            ];
            @endphp
            @foreach($aparat as $p)
            <div style="background: white; padding: 18px 22px; border-radius: 18px; border: 1px solid #eef2f6; display: flex; align-items: center; gap: 18px; transition: 0.3s;">
                <div style="background: #f8fafc; color: #1e3a8a; width: 44px; height: 44px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; border: 1px solid #f1f5f9;">
                    <i class="fas {{ $p['icon'] }}"></i>
                </div>
                <div style="overflow: hidden;">
                    <div style="font-size: 14px; font-weight: 700; color: #1e3a8a; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $p['nama'] }}</div>
                    <div style="font-size: 10px; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px;">{{ $p['jab'] }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- 4. VISI & MISI --}}
    <div style="display: grid; grid-template-columns: 1fr 1.5fr; gap: 25px; align-items: stretch; margin-bottom: 20px;">
        {{-- Kotak Visi --}}
        <div style="background: white; border-radius: 24px; padding: 35px; border: 1px solid #eef2f6; display: flex; flex-direction: column; box-shadow: 0 4px 6px rgba(0,0,0,0.01);">
            <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 25px;">
                <div style="background: #ecfeff; color: #06b6d4; width: 50px; height: 50px; border-radius: 14px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-eye fa-lg"></i>
                </div>
                <h6 style="margin: 0; font-weight: 800; font-size: 12px; color: #06b6d4; text-transform: uppercase; letter-spacing: 1px;">Visi Strategis</h6>
            </div>
            <div style="flex-grow: 1; display: flex; align-items: center; background: #fcfdfe; padding: 20px; border-radius: 16px; border-left: 4px solid #06b6d4;">
                <p style="font-size: 14.5px; color: #475569; line-height: 1.8; font-style: italic; margin: 0;">
                    "{{ $profil->visi ?? 'Visi desa belum diatur dalam profil.' }}"
                </p>
            </div>
        </div>

        {{-- Kotak Misi --}}
        <div style="background: white; border-radius: 24px; padding: 35px; border: 1px solid #eef2f6; display: flex; flex-direction: column; box-shadow: 0 4px 6px rgba(0,0,0,0.01);">
            <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 25px;">
                <div style="background: #ecfeff; color: #06b6d4; width: 50px; height: 50px; border-radius: 14px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-bullseye fa-lg"></i>
                </div>
                <h6 style="margin: 0; font-weight: 800; font-size: 12px; color: #06b6d4; text-transform: uppercase; letter-spacing: 1px;">Misi Strategis</h6>
            </div>
            <div style="max-height: 200px; overflow-y: auto; padding-right: 12px;">
                @php
                $misi = isset($profil->misi) ? preg_split('/\r\n|\r|\n|-/', $profil->misi) : [];
                $misi = array_filter(array_map('trim', $misi));
                @endphp
                @forelse($misi as $idx => $m)
                <div style="display: flex; gap: 15px; margin-bottom: 15px; align-items: flex-start;">
                    <span style="background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%); color: white; font-weight: 800; font-size: 10px; width: 26px; height: 26px; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 8px rgba(6, 182, 212, 0.2);">
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

<style>
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

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 20px rgba(0, 0, 0, 0.05) !important;
    }

    div::-webkit-scrollbar {
        width: 5px;
    }

    div::-webkit-scrollbar-track {
        background: #f8fafc;
    }

    div::-webkit-scrollbar-thumb {
        background: #e2e8f0;
        border-radius: 10px;
    }
</style>

{{-- SCRIPT JAM DIGITAL --}}
<script>
    function updateClock() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');

        const clockElement = document.getElementById('clock-banner');
        if (clockElement) {
            clockElement.textContent = hours + ":" + minutes + ":" + seconds;
        }
    }
    setInterval(updateClock, 1000);
    updateClock(); // Jalankan langsung
</script>

@endsection