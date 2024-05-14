<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManajemenDataBk extends Model
{
    use HasFactory;

    protected $table    = 'manajemen_data_bk';
    protected $fillable = [
        'id',
        'siswa_id',
        'konselor_id',
        'tgl_bk',
        'jenis',
        'isi',
        'tindakan',
        'batas_waktu'
    ];

    public function siswa(){
        return $this->belongsTo(Siswa::class, "siswa_id");
    }

    public function konselor(){
        return $this->belongsTo(Konselor::class, "konselor_id");
    }

    public function chat(){
        return $this->hasOne(Chat::class, "manajemen_data_bk_id", "id");
    }
}
