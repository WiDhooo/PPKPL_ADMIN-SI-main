<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperGuru
 */
class Guru extends Model
{
    protected $table = 'tblguru';
    protected $fillable = [
        'nama',
        'nip',
        'jabatan',
        'mata_pelajaran',
        'pengalaman',
        'pendidikan_terakhir',
        'gambar',
    ];
}
