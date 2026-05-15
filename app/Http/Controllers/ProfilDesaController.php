<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfilDesaController extends Controller
{
    // Menampilkan halaman form (Index)
    public function index()
    {
        $profil = DB::table('profil_desa')->first(); // Ambil data pertama
        return view('admin.profil.index', compact('profil'));
    }

    // Menyimpan/Update data dari web
    public function store(Request $request)
    {
        DB::table('profil_desa')->updateOrInsert(
            ['id' => 1], // Selalu kunci di ID nomor 1
            [
                'nama_desa'   => $request->nama_desa,
                'visi'        => $request->visi,
                'misi'        => $request->misi,
                'nama_kades'  => $request->nama_kades,
                'nama_sekdes' => $request->nama_sekdes,
                'nama_kaur'   => $request->nama_kaur, // Perangkat 1

                // TAMBAHAN: Perangkat Desa Lainnya
                'nama_bendahara' => $request->nama_bendahara,
                'nama_kasi'      => $request->nama_kasi,
                'nama_kadus'     => $request->nama_kadus,

                'updated_at'  => now(),
            ]
        );

        return back()->with('success', 'Profil Desa Berhasil Diperbarui!');
    }
}
