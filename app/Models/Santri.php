<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Santri extends Model
{
    use HasFactory;

    protected $table = 'tblsantri';

    protected $fillable = [
        'pendaftaran_id', 'nik', 'nama_santri', 'tempat_lahir', 'tanggal_lahir',
        'jenis_kelamin', 'alamat', 'nama_orang_tua', 'no_hp',
        'akta_kelahiran', 'kartu_keluarga', 'id_kelas'
    ];

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class, 'pendaftaran_id');
    }

    public function kelas()
    {
        return $this->belongsTo(\App\Models\Kelas::class, 'id_kelas');
    }
}
