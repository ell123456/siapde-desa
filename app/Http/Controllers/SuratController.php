<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\Penduduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str; // WAJIB UNTUK GENERATE KODE TTE

class SuratController extends Controller
{
    /**
     * Dashboard: Statistik & Ringkasan
     */
    public function dashboard()
    {
        $totalPenduduk = Penduduk::count() ?? 0;
        $suratPending = Surat::where('status', 'diajukan')->count() ?? 0;
        $suratSelesai = Surat::where('status', 'disetujui')->count() ?? 0;
        $recentSurat = Surat::with('penduduk')->orderBy('created_at', 'desc')->take(5)->get() ?? collect([]);
        $profil = DB::table('profil_desa')->first();

        return view('admin.dashboard', compact('totalPenduduk', 'suratPending', 'suratSelesai', 'recentSurat', 'profil'));
    }

    /**
     * Index: Daftar Surat dengan Filter Tanggal & Jenis
     */
    public function index(Request $request)
    {
        $daftar_surat = [
            'SKU'        => 'Keterangan Usaha (SKU)',
            'SKTM'       => 'Keterangan Tidak Mampu (SKTM)',
            'Domisili'   => 'Keterangan Domisili',
            'SKCK'       => 'Pengantar SKCK',
            'KTP'        => 'Pengantar KTP',
            'Ahli Waris' => 'Keterangan Ahli Waris',
            'Kelahiran'  => 'Keterangan Kelahiran',
            'Kematian'   => 'Keterangan Kematian',
        ];

        $query = Surat::with('penduduk');

        if ($request->filled('tgl_mulai')) {
            $query->whereDate('tanggal_pengajuan', '>=', $request->tgl_mulai);
        }

        if ($request->filled('tgl_selesai')) {
            $query->whereDate('tanggal_pengajuan', '<=', $request->tgl_selesai);
        }

        if ($request->filled('jenis_surat')) {
            $query->where('jenis_surat', $request->jenis_surat);
        }

        $surats = $query->orderBy('tanggal_pengajuan', 'desc')->get();

        return view('admin.surat.index', compact('surats', 'daftar_surat'));
    }

    /**
     * Store: Simpan Pengajuan Surat Baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_penduduk' => 'required',
            'jenis_surat' => 'required',
        ]);

        $data = $request->all();
        $data['status'] = 'diajukan';
        $data['tanggal_pengajuan'] = date('Y-m-d');

        Surat::create($data);

        return redirect()->route('surat.index')->with('success', 'Surat berhasil diajukan!');
    }

    public function arsip()
    {
        $surats = Surat::with('penduduk')->whereIn('status', ['disetujui', 'ditolak'])->orderBy('updated_at', 'desc')->get();
        return view('admin.surat.arsip', compact('surats'));
    }

    public function verifikasi()
    {
        $surats = Surat::with('penduduk')->where('status', 'diajukan')->get();
        return view('admin.surat.verifikasi', compact('surats'));
    }

    /**
     * SETUJUI: LOGIKA TANDA TANGAN DIGITAL (TTE)
     */
    public function setujui($id)
    {
        // 1. Keamanan: Cek Role Kepala Desa
        if (auth()->user()->role !== 'kepdes') {
            return redirect()->back()->with('error', 'Hanya Kepala Desa yang dapat menandatangani surat!');
        }

        // 2. Generate Kode Unik TTE
        $kodeTTE = 'TTE-' . strtoupper(Str::random(10));

        // 3. Update Data & Simpan Bukti Digital
        Surat::where('id_surat', $id)->update([
            'status' => 'disetujui',
            'tte_code' => $kodeTTE,
            'disetujui_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->back()->with('success', 'Surat telah ditandatangani digital secara sah!');
    }

    public function tolak($id)
    {
        Surat::where('id_surat', $id)->update([
            'status' => 'ditolak',
            'updated_at' => now()
        ]);
        return redirect()->back()->with('success', 'Permohonan surat telah ditolak.');
    }

    /**
     * CEK KEASLIAN: Fungsi untuk Scan QR Code (Publik)
     */
    public function cekKeaslian($kode)
    {
        $surat = Surat::with('penduduk')->where('tte_code', $kode)->firstOrFail();
        $profil = DB::table('profil_desa')->first();

        return view('admin.surat.validasi_publik', compact('surat', 'profil'));
    }

    public function cetak($id)
    {
        $item = Surat::with('penduduk')->where('id_surat', $id)->firstOrFail();
        $profil = DB::table('profil_desa')->first();
        $logoBase64 = $this->generateLogo();

        $pdf = Pdf::loadView('admin.surat.cetak', compact('item', 'profil', 'logoBase64'));
        return $pdf->stream('Surat_' . $item->id_surat . '.pdf');
    }

    public function cetakSemua()
    {
        $surats = Surat::with('penduduk')->get();
        $profil = DB::table('profil_desa')->first();
        $logoBase64 = $this->generateLogo();
        $pdf = Pdf::loadView('admin.surat.cetak-semua', compact('surats', 'profil', 'logoBase64'));
        return $pdf->stream('Laporan_Surat_Desa.pdf');
    }

    private function generateLogo()
    {
        $path = public_path('logo-desa.png');
        return file_exists($path) ? 'data:image/png;base64,' . base64_encode(file_get_contents($path)) : '';
    }

    public function create()
    {
        $penduduk = Penduduk::orderBy('nama', 'asc')->get();
        return view('admin.surat.create', compact('penduduk'));
    }

    public function edit($id)
    {
        $surat = Surat::where('id_surat', $id)->firstOrFail();
        $penduduk = Penduduk::all();
        return view('admin.surat.edit', compact('surat', 'penduduk'));
    }

    public function update(Request $request, $id)
    {
        Surat::where('id_surat', $id)->update($request->except(['_token', '_method']));
        return redirect()->route('surat.index')->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Surat::where('id_surat', $id)->delete();
        return redirect()->route('surat.index')->with('success', 'Data surat berhasil dihapus.');
    }
}
