<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\PendudukController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfilDesaController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

// 1. GUEST AREA (Bisa diakses tanpa login / publik)
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', function () {
    if (Auth::check()) return redirect()->route('dashboard');
    return view('auth.login');
})->name('login');

Route::post('/login', function (Request $request) {
    $credentials = $request->validate(['username' => 'required', 'password' => 'required']);
    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->route('dashboard');
    }
    return back()->withErrors(['username' => 'Username atau password salah!']);
});

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

// --- ROUTE UNTUK SCAN QR CODE (Sudah dipindah ke sini agar bebas akses) ---
Route::get('/cek-surat/{kode}', [SuratController::class, 'cekKeaslian'])->name('surat.cek_keaslian');


// 2. AUTH AREA (Wajib Login Baru Bisa Masuk)
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [SuratController::class, 'dashboard'])->name('dashboard');

    // --- FITUR KHUSUS KEPDES ---
    Route::middleware(['role:kepdes'])->group(function () {
        Route::get('/surat/verifikasi', [SuratController::class, 'verifikasi'])->name('surat.verifikasi');
        Route::post('/surat/setujui/{id}', [SuratController::class, 'setujui'])->name('surat.setujui');
        Route::post('/surat/tolak/{id}', [SuratController::class, 'tolak'])->name('surat.tolak');
    });

    // --- AREA KONTROL (ADMIN & KEPDES BISA MASUK) ---
    Route::middleware(['role:admin,kepdes'])->group(function () {
        Route::resource('user', UserController::class);
        Route::resource('penduduk', PendudukController::class);
        Route::resource('surat', SuratController::class);

        // --- RUTE PROFIL DESA ---
        Route::get('/profil-desa', [ProfilDesaController::class, 'index'])->name('profil.index');
        Route::post('/profil-desa', [ProfilDesaController::class, 'store'])->name('profil.store');
    });

    // --- FITUR BERSAMA ---
    Route::get('/arsip-surat', [SuratController::class, 'arsip'])->name('surat.arsip');
    Route::get('/cetak-semua-laporan', [SuratController::class, 'cetakSemua'])->name('surat.cetakSemua');
    Route::get('/cetak-surat/{id}', [SuratController::class, 'cetak'])->name('surat.cetak');
    Route::get('/export-surat', [SuratController::class, 'export'])->name('surat.export');
    Route::post('/penduduk/import', [PendudukController::class, 'import'])->name('penduduk.import');
});
