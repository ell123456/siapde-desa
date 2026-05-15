<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penduduk extends Model
{
    use HasFactory;

    protected $table = 'penduduk';
    protected $primaryKey = 'id_penduduk';
    public $timestamps = true;

    protected $fillable = [
        'nik',
        'nama',
        'tempat_lahir',
        'tgl_lahir',
        'jenis_kelamin',
        'agama',            // TAMBAHKAN INI
        'pekerjaan',
        'status_perkawinan', // TAMBAHKAN INI
        'alamat',
        'dusun',             // TAMBAHKAN INI (Jika ada kolom dusun di database)
        'id_user',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
