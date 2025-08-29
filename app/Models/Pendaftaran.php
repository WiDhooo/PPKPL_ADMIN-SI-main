<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    protected $table = 'tblpendaftaran'; // Nama tabel di database kamu
    protected $fillable = [
        'user_id', 'nik', 'nama_santri', 'tempat_lahir', 'tanggal_lahir', 
        'jenis_kelamin', 'alamat', 'nama_orang_tua', 'no_hp', 
        'akta_kelahiran', 'kartu_keluarga', 'status', 'order_id', 'snap_token'
    ]; // Kolom-kolom yang bisa diisi
    

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
