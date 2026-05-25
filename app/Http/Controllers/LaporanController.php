<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Surat; // Pastikan nama model surat lo sesuai
use Barryvdh\DomPDF\Facade\Pdf; // Library DomPDF untuk generate laporan ke PDF

class LaporanController extends Controller
{
    /**
     * Menampilkan Halaman Utama Menu Laporan (Tempat Dropdown Filter)
     */
    public function index()
    {
        return view('admin.laporan.index');
    }

    /**
     * Memproses Filter & Menghasilkan Cetakan PDF Beserta Auto-Scanner Logo
     */
    public function cetakPdf(Request $request)
    {
        // 1. Ambil inputan dari dropdown filter halaman index laporan
        $bulan = $request->bulan;
        $tahun = $request->tahun ?? date('Y');

        // 2. Jalankan query penarikan data surat beserta relasi data penduduknya
        $query = Surat::with('penduduk');

        // KUNCI FILTER BULANAN
        if (!empty($bulan)) {
            $query->whereMonth('created_at', $bulan);
        }

        // KUNCI FILTER TAHUNAN
        $query->whereYear('created_at', $tahun);

        // Ambil hasil akhir saringan datanya
        $surats = $query->orderBy('created_at', 'desc')->get();


        // --- PROSES SUNTIK LOGO UTAMA (FIX SEJALUR DENGAN public/logo-desa.png) ---
        // Menembak langsung file logo-desa.png yang berada tepat di bawah folder public lo
        $pathLogo = public_path('logo-desa.png');

        if (file_exists($pathLogo)) {
            $type = pathinfo($pathLogo, PATHINFO_EXTENSION);
            $data = file_get_contents($pathLogo);
            $logoBase64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        } else {
            $logoBase64 = null; // Menghindari crash jika file terhapus
        }


        // 3. Compile dan kirim seluruh data hasil saringan ke file template cetakan PDF lo
        $pdf = Pdf::loadView('admin.laporan.pdf_view', compact('surats', 'bulan', 'tahun', 'logoBase64'));

        // 4. Buka file PDF secara lurus, realtime, dan clean langsung di tab baru browser
        return $pdf->stream('Laporan_Surat_Desa_' . $tahun . '.pdf');
    }
}
