<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\Penduduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class SuratController extends Controller
{
    /**
     * Helper untuk mendapatkan daftar 11 Jenis Surat (Biar dinamis & terpusat)
     */
    private function getDaftarSurat()
    {
        return [
            'Surat Keterangan Domisili'             => 'Surat Keterangan Domisili',
            'Surat Keterangan Usaha (SKU)'          => 'Surat Keterangan Usaha (SKU)',
            'Surat Ahli Waris'                      => 'Surat Ahli Waris',
            'Surat Pengantar KTP'                   => 'Surat Pengantar KTP',
            'Surat Keterangan Tidak Mampu (SKTM)'   => 'Surat Keterangan Tidak Mampu (SKTM)',
            'Surat Pengantar SKCK'                  => 'Surat Pengantar SKCK',
            'Surat Keterangan Kelahiran'            => 'Surat Keterangan Kelahiran',
            'Surat Keterangan Kematian'             => 'Surat Keterangan Kematian',
            'Surat Keterangan Tanah'                => 'Surat Keterangan Tanah',
            'Surat Keterangan Pindah Penduduk'      => 'Surat Keterangan Pindah Penduduk',
            'Surat Keterangan Belum Memiliki Rumah' => 'Surat Keterangan Belum Memiliki Rumah',
        ];
    }

    /**
     * Dashboard: Statistik & Ringkasan
     */
    public function dashboard()
    {
        $totalPenduduk = Penduduk::count() ?? 0;
        $suratPending = Surat::where('status', 'diajukan')->count() ?? 0;
        $suratSelesai = Surat::whereIn('status', ['disetujui', 'selesai'])->count() ?? 0;
        $recentSurat = Surat::with('penduduk')->orderBy('created_at', 'desc')->take(5)->get() ?? collect([]);
        $profil = DB::table('profil_desa')->first();
        $jumlahLaki = Penduduk::where('jenis_kelamin', 'L')->count() ?? 0;
        $jumlahPerempuan = Penduduk::where('jenis_kelamin', 'P')->count() ?? 0;
        $suratHariIni = Surat::whereDate('created_at', date('Y-m-d'))->count() ?? 0;
        $suratBulanIni = Surat::whereYear('created_at', date('Y'))
            ->whereMonth('created_at', date('m'))
            ->count() ?? 0;

        // Data 12 bulan untuk grafik
        $suratPerBulan = [];
        for ($i = 1; $i <= 12; $i++) {
            $suratPerBulan[$i] = Surat::whereYear('created_at', date('Y'))
                ->whereMonth('created_at', $i)
                ->count();
        }

        return view('admin.dashboard', compact(
            'totalPenduduk',
            'suratPending',
            'suratSelesai',
            'recentSurat',
            'profil',
            'jumlahLaki',
            'jumlahPerempuan',
            'suratHariIni',
            'suratBulanIni',
            'suratPerBulan'
        ));
    }

    /**
     * Index: Data Surat (Meja Kerja)
     */
    public function index(Request $request)
    {
        // Ambil daftar surat dari fungsi terpusat
        $daftar_surat = $this->getDaftarSurat();

        // LOGIKA: Sembunyikan 'selesai', tampilkan sisanya
        $query = Surat::with('penduduk')->whereNotIn('status', ['selesai']);

        if ($request->filled('tgl_mulai')) {
            $query->whereDate('created_at', '>=', $request->tgl_mulai);
        }
        if ($request->filled('tgl_selesai')) {
            $query->whereDate('created_at', '<=', $request->tgl_selesai);
        }
        if ($request->filled('jenis_surat')) {
            $query->where('jenis_surat', $request->jenis_surat);
        }

        $surats = $query->orderBy('created_at', 'desc')->get();

        return view('admin.surat.index', compact('surats', 'daftar_surat'));
    }

    /**
     * Form Tambah Surat
     */
    public function create()
    {
        $penduduk = Penduduk::orderBy('nama', 'asc')->get();
        $daftar_surat = $this->getDaftarSurat(); // Kirim list 11 surat ke view create

        return view('admin.surat.create', compact('penduduk', 'daftar_surat'));
    }

    /**
     * Store: Simpan Surat Baru
     */
    public function store(Request $request)
    {
        $request->validate(['id_penduduk' => 'required', 'jenis_surat' => 'required']);

        $data = $request->all();
        $data['status'] = 'diajukan';
        $data['tanggal_pengajuan'] = date('Y-m-d');

        $berkasData = [];

        if ($request->hasFile('berkas')) {
            foreach ($request->file('berkas') as $index => $file) {
                if ($file->isValid()) {
                    $namaBerkasAsli = $request->input("nama_berkas.$index") ?? 'Berkas';
                    $filename = time() . '_' . $index . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('uploads/berkas'), $filename);

                    $berkasData[] = [
                        'nama'   => $namaBerkasAsli,
                        'file'   => $filename,
                        'status' => 'lengkap'
                    ];
                }
            }
        }

        $data['berkas'] = json_encode($berkasData);
        Surat::create($data);

        return redirect()->route('surat.index')->with('success', 'Surat berhasil diajukan!');
    }

    /**
     * ARSIP: Rekap Data Final (Selesai & Ditolak)
     */
    public function arsip()
    {
        $surats = Surat::with('penduduk')
            ->whereIn('status', ['selesai', 'ditolak'])
            ->orderBy('updated_at', 'desc')
            ->get();
        return view('admin.surat.arsip', compact('surats'));
    }

    public function verifikasi()
    {
        $surats = Surat::with('penduduk')->where('status', 'diajukan')->get();
        return view('admin.surat.verifikasi', compact('surats'));
    }

    public function setujui($id)
    {
        if (auth()->user()->role !== 'kepdes') {
            return redirect()->back()->with('error', 'Hanya Kepala Desa!');
        }
        $kodeTTE = 'TTE-' . strtoupper(Str::random(10));
        Surat::where('id_surat', $id)->update([
            'status' => 'disetujui',
            'tte_code' => $kodeTTE,
            'disetujui_at' => now(),
            'updated_at' => now()
        ]);
        return redirect()->back()->with('success', 'Surat disetujui!');
    }

    public function tolak(Request $request, $id)
    {
        Surat::where('id_surat', $id)->update([
            'status' => 'ditolak',
            'keterangan' => $request->keterangan ?? 'BERKAS KURANG / TIDAK VALID',
            'updated_at' => now()
        ]);

        return redirect()->back()->with('success', 'Permohonan ditolak.');
    }

    public function cekKeaslian($kode)
    {
        $surat = Surat::with('penduduk')->where('tte_code', $kode)->firstOrFail();
        $profil = DB::table('profil_desa')->first();
        return view('admin.surat.validasi_publik', compact('surat', 'profil'));
    }

    public function cetak($id)
    {
        $item = Surat::with('penduduk')->where('id_surat', $id)->firstOrFail();
        if (strtolower($item->status) == 'disetujui') {
            Surat::where('id_surat', $id)->update(['status' => 'selesai', 'updated_at' => now()]);
        }
        $item->status = 'disetujui';
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

    /**
     * Form Edit Surat
     */
    public function edit($id)
    {
        $surat = Surat::where('id_surat', $id)->firstOrFail();
        $penduduk = Penduduk::all();
        $daftar_surat = $this->getDaftarSurat(); // Kirim list 11 surat ke view edit

        return view('admin.surat.edit', compact('surat', 'penduduk', 'daftar_surat'));
    }

    /**
     * Update: Menyimpan perubahan data surat
     */
    public function update(Request $request, $id)
    {
        $surat = Surat::where('id_surat', $id)->firstOrFail();
        $berkasData = [];
        if (!empty($surat->berkas)) {
            $berkasData = is_string($surat->berkas) ? json_decode($surat->berkas, true) : $surat->berkas;
        }

        if ($request->hasFile('berkas')) {
            foreach ($request->file('berkas') as $index => $file) {
                if ($file->isValid()) {
                    $namaBerkasAsli = $request->input("nama_berkas.$index") ?? 'Berkas';
                    $filename = time() . '_edit_' . $index . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('uploads/berkas'), $filename);

                    $ketemu = false;
                    foreach ($berkasData as $key => $value) {
                        if (($value['nama'] ?? '') === $namaBerkasAsli) {
                            $berkasData[$key]['file'] = $filename;
                            $berkasData[$key]['status'] = 'lengkap';
                            $ketemu = true;
                            break;
                        }
                    }

                    if (!$ketemu) {
                        $berkasData[] = [
                            'nama'   => $namaBerkasAsli,
                            'file'   => $filename,
                            'status' => 'lengkap'
                        ];
                    }
                }
            }
        }

        $updateData = [
            'jenis_surat' => $request->jenis_surat,
            'keterangan'  => $request->keterangan,
            'berkas'      => json_encode($berkasData),
            'updated_at'  => now()
        ];

        if (strtolower($surat->status) == 'ditolak') {
            $updateData['status'] = 'diajukan';
            $updateData['keterangan'] = null;
        }

        $surat->update($updateData);

        return redirect()->route('surat.index')->with('success', 'Data surat berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $surat = Surat::where('id_surat', $id)->first();
        if ($surat) {
            $surat->delete();
        }
        return redirect()->route('surat.index')->with('success', 'Data surat berhasil dihapus.');
    }

    public function searchPenduduk(Request $request)
    {
        $term = $request->term;
        $data = Penduduk::where('nama', 'LIKE', "%$term%")
            ->orWhere('nik', 'LIKE', "%$term%")
            ->limit(15)
            ->get(['id_penduduk', 'nik', 'nama']);

        $results = [];
        foreach ($data as $p) {
            $results[] = [
                'id' => $p->id_penduduk,
                'text' => $p->nik . ' — ' . $p->nama
            ];
        }

        return response()->json(['results' => $results]);
    }
}
