<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penduduk;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel; // WAJIB DITAMBAH BIAR BISA BACA EXCEL

class PendudukController extends Controller
{
    public function index(Request $request)
    {
        // 1. Panggil query model
        $query = Penduduk::query();

        // 2. LOGIKA SEARCHING: Kalau ada input 'search', cari di database
        if ($request->has('search') && $request->search != '') {
            $keyword = $request->search;
            $query->where('nama', 'LIKE', '%' . $keyword . '%')
                ->orWhere('nik', 'LIKE', '%' . $keyword . '%');
        }

        // 3. Ambil data (diurutkan dari yang terbaru)
        $penduduk = $query->latest()->get();

        return view('admin.penduduk.index', compact('penduduk'));
    }

    public function create()
    {
        return view('admin.penduduk.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'            => 'required',
            'nik'             => 'required|unique:penduduk,nik',
            'tempat_lahir'    => 'required',
            'tgl_lahir'       => 'required|date',
            'jenis_kelamin'   => 'required',
            'agama'           => 'required',
            'status_perkawinan' => 'required',
            'alamat'          => 'required'
        ]);

        try {
            Penduduk::create([
                'nama'              => $request->nama,
                'nik'               => $request->nik,
                'tempat_lahir'      => $request->tempat_lahir,
                'tgl_lahir'         => $request->tgl_lahir,
                'jenis_kelamin'     => $request->jenis_kelamin,
                'agama'             => $request->agama,
                'pekerjaan'         => $request->pekerjaan,
                'status_perkawinan' => $request->status_perkawinan,
                'alamat'            => $request->alamat,
                'id_user'           => Auth::id() ?? 1,
            ]);

            return redirect()->route('penduduk.index')->with('success', 'Data berhasil disimpan');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal simpan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $penduduk = Penduduk::findOrFail($id);
        return view('admin.penduduk.edit', compact('penduduk'));
    }

    public function update(Request $request, $id)
    {
        $penduduk = Penduduk::findOrFail($id);

        $request->validate([
            'nama'            => 'required',
            'nik'             => 'required|unique:penduduk,nik,' . $id . ',id_penduduk',
            'tempat_lahir'    => 'required',
            'tgl_lahir'       => 'required|date',
            'jenis_kelamin'   => 'required',
            'agama'           => 'required',
            'status_perkawinan' => 'required',
            'alamat'          => 'required'
        ]);

        try {
            $penduduk->update([
                'nama'              => $request->nama,
                'nik'               => $request->nik,
                'tempat_lahir'      => $request->tempat_lahir,
                'tgl_lahir'         => $request->tgl_lahir,
                'jenis_kelamin'     => $request->jenis_kelamin,
                'agama'             => $request->agama,
                'pekerjaan'         => $request->pekerjaan,
                'status_perkawinan' => $request->status_perkawinan,
                'alamat'            => $request->alamat,
            ]);

            return redirect()->route('penduduk.index')->with('success', 'Data berhasil diperbarui');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal update: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $penduduk = Penduduk::findOrFail($id);
        $penduduk->delete();
        return redirect()->route('penduduk.index')->with('success', 'Data berhasil dihapus');
    }

    // FUNGSI BARU: UNTUK IMPORT EXCEL
    public function import(Request $request)
    {
        // Validasi file yang masuk harus excel/csv
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            // Proses file excel menggunakan class PendudukImport
            Excel::import(new \App\Imports\PendudukImport, $request->file('file'));

            return redirect()->route('penduduk.index')->with('success', 'Ribuan data warga berhasil diimport dalam sekejap!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal import: Pastikan format kolom excel sesuai. Error: ' . $e->getMessage());
        }
    }
}
