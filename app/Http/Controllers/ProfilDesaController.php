<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfilDesaController extends Controller
{
    public function index()
    {
        $profil = DB::table('profil_desa')->first();
        return view('admin.profil.edit', compact('profil'));
    }

    public function update(Request $request)
    {
        DB::table('profil_desa')->updateOrInsert(
            ['id' => 1],
            [
                'nama_desa'          => $request->nama_desa,
                'visi'               => $request->visi,
                'misi'               => $request->misi,
                'nama_kades'         => $request->nama_kades,
                'nama_sekdes'        => $request->nama_sekdes,
                'nama_kaur'          => $request->nama_kaur,
                'nama_bendahara'     => $request->nama_bendahara,
                'nama_kasi'          => $request->nama_kasi,
                'nama_kadus'         => $request->nama_kadus,
                'syarat_sku'         => $request->syarat_sku,
                'syarat_sktm'        => $request->syarat_sktm,
                'syarat_skck'        => $request->syarat_skck,
                'syarat_ktp'         => $request->syarat_ktp,
                'syarat_domisili'    => $request->syarat_domisili,
                'syarat_waris'       => $request->syarat_waris,
                'syarat_lahir'       => $request->syarat_lahir,
                'syarat_mati'        => $request->syarat_mati,
                'syarat_belum_rumah' => $request->syarat_belum_rumah,
                'syarat_pindah'      => $request->syarat_pindah,
                'syarat_tanah'       => $request->syarat_tanah,
                'updated_at'         => now(),
            ]
        );

        return back()->with('success', 'Profil Desa Berhasil Diperbarui!');
    }
}
