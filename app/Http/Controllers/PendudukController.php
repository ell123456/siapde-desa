<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penduduk;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel; // WAJIB BIAR BISA BACA EXCEL
use App\Exports\PendudukExport; // WAJIB DIIMPORT UNTUK PROSES EXPORT DATA

class PendudukController extends Controller
{
    public function index(Request $request)
    {
        // 1. Panggil query model penduduk
        $query = Penduduk::query();

        // 2. LOGIKA SEARCHING: Diperketat agar tidak menjebak data jadi kosong
        if ($request->filled('search')) {
            $keyword = trim($request->search);
            $query->where(function ($q) use ($keyword) {
                $q->where('nama', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('nik', 'LIKE', '%' . $keyword . '%');
            });
        }

        // 3. KUNCI RAPI: Urutkan data berdasarkan alfabet nama warga (A sampai Z)
        $penduduk = $query->orderBy('nama', 'asc')->get();

        return view('admin.penduduk.index', compact('penduduk'));
    }

    public function create()
    {
        return view('admin.penduduk.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'              => 'required',
            'nik'               => 'required|unique:penduduk,nik',
            'tempat_lahir'      => 'required',
            'tgl_lahir'         => 'required|date',
            'jenis_kelamin'     => 'required',
            'agama'             => 'required',
            'status_perkawinan' => 'required',
            'alamat'            => 'required'
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
            'nama'              => 'required',
            'nik'               => 'required|unique:penduduk,nik,' . $id . ',id_penduduk',
            'tempat_lahir'      => 'required',
            'tgl_lahir'         => 'required|date',
            'jenis_kelamin'     => 'required',
            'agama'             => 'required',
            'status_perkawinan' => 'required',
            'alamat'            => 'required'
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

    // FUNGSI IMPORT EXCEL (ANTI-MENTAL & AMAN)
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required'
        ], [
            'file.required' => 'Pilih file Excel/CSV terlebih dahulu!'
        ]);

        try {
            $file = $request->file('file');
            $ekstensi = strtolower($file->getClientOriginalExtension());

            if (!in_array($ekstensi, ['xlsx', 'xls', 'csv'])) {
                return back()->with('error', 'Format file wajib .xlsx, .xls, atau .csv!');
            }

            Excel::import(new \App\Imports\PendudukImport, $file);

            return redirect()->route('penduduk.index')->with('success', 'Selamat, data warga berhasil diimport ke sistem SIAPDE!');
        } catch (\Exception $e) {
            return back()->with('error', 'Proses Import Gagal! Error: ' . $e->getMessage());
        }
    }

    // FUNGSI EXPORT DATA REALTIME (NEW FEATURE)
    public function export()
    {
        try {
            return Excel::download(new PendudukExport, 'Data_Penduduk_Desa_Realtime.xlsx');
        } catch (\Exception $e) {
            return back()->with('error', 'Proses Export Excel Gagal! Error: ' . $e->getMessage());
        }
    }
}
