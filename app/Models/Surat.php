<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    use HasFactory;

    protected $table = 'surat';
    protected $primaryKey = 'id_surat'; // Kunci utama tabel kamu
    public $incrementing = true;

    // KUNCI PERBAIKAN: Menambahkan 'berkas' dan 'keterangan' agar diizinkan masuk ke database
    protected $fillable = [
        'id_penduduk',
        'jenis_surat',
        'status',
        'tanggal_pengajuan',
        'tte_code',      // Kode Unik QR untuk Tanda Tangan Digital
        'disetujui_at',   // Waktu kapan Kepdes klik Setuju
        'berkas',        // <--- WAJIB ADA AGAR DATA UPLOAD BERKAS BISA MASUK DATABASE
        'keterangan'     // <--- WAJIB ADA AGAR TEKS ALASAN DITOLAK BISA MASUK DATABASE
    ];

    /**
     * Relasi ke data Penduduk
     */
    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class, 'id_penduduk', 'id_penduduk');
    }
}
