<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KepalaSekolah extends Model
{
    use HasFactory;

    protected $table    = 'kepala_sekolah';
    protected $fillable = [
        'id',
        'pengguna_id',
        'nip',
        'nama',
        'agama',
        'alamat',
        'telepon',
    ];

    public function pengguna(){
        return $this->belongsTo(User::class, "pengguna_id");
    }
}
