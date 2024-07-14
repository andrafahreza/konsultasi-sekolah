<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table    = 'siswa';
    protected $fillable = [
        'id',
        'pengguna_id',
        'nik',
        'nama_lengkap',
        'jenis_kelamin',
        'tempat_lahir',
        'tgl_lahir',
        'agama',
        'golongan_darah',
        'alamat',
        'telepon',
        'sekolah_asal',
        'diterima_sebagai',
        'tahun_terima',
        'hobi',
        'nama_ayah',
        'tempat_lahir_ayah',
        'tgl_lahir_ayah',
        'pekerjaan_ayah',
        'agama_ayah',
        'nama_ibu',
        'tempat_lahir_ibu',
        'tgl_lahir_ibu',
        'pekerjaan_ibu',
        'agama_ibu',
        'alamat_ortu',
        'telepon_ortu',
    ];

    public function pengguna(){
        return $this->belongsTo(User::class, "pengguna_id");
    }
}
