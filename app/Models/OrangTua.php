<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrangTua extends Model
{
    use HasFactory;

    protected $table    = 'orang_tua';
    protected $fillable = [
        'id',
        'pengguna_id',
        'siswa_id',
        'nama',
        'agama',
        'alamat',
        'telepon',
    ];

    public function pengguna(){
        return $this->belongsTo(User::class, "pengguna_id");
    }

    public function siswa(){
        return $this->belongsTo(Siswa::class, "siswa_id");
    }
}
