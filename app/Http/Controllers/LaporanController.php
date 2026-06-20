<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Surat;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB; // <--- INI KUNCI UTAMA YANG MENGHILANGKAN ERROR

class LaporanController extends Controller
{
    /**
     * Menampilkan Halaman Utama Menu Laporan
     */
    public function index()
    {
        return view('admin.laporan.index');
    }

    /**
     * Memproses Filter & Menghasilkan Cetakan PDF
     */
    public function cetakPdf(Request $request)
    {
        // 1. Ambil inputan filter
        $bulan = $request->bulan;
        $tahun = $request->tahun ?? date('Y');

        // 2. Query data surat (FILTER HANYA YANG DISETUJUI/SELESAI)
        $query = Surat::with('penduduk')
            ->whereIn('status', ['disetujui', 'selesai']);

        if (!empty($bulan)) {
            $query->whereMonth('created_at', $bulan);
        }
        $query->whereYear('created_at', $tahun);
        $surats = $query->orderBy('created_at', 'desc')->get();

        // --- KUNCI: AMBIL DATA PROFIL DESA ---
        $profil = DB::table('profil_desa')->first();

        // --- PROSES SUNTIK LOGO ---
        $pathLogo = public_path('logo-desa.png');
        $logoBase64 = file_exists($pathLogo) ? 'data:image/png;base64,' . base64_encode(file_get_contents($pathLogo)) : null;

        // --- KIRIM PROFIL KE VIEW ---
        $pdf = Pdf::loadView('admin.laporan.pdf_view', compact('surats', 'bulan', 'tahun', 'logoBase64', 'profil'));

        return $pdf->stream('Laporan_Surat_Desa_' . $tahun . '.pdf');
    }
}
