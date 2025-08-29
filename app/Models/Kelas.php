<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'tblkelas';

    protected $fillable = [
        'kelas',
    ];

    public $timestamps = false;

    public function santris()
    {
        return $this->hasMany(\App\Models\Santri::class, 'id_kelas');
    }
}
