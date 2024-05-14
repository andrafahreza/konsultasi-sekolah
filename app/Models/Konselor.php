<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konselor extends Model
{
    use HasFactory;

    protected $table    = 'konselor';
    protected $fillable = [
        'id',
        'pengguna_id',
        'nip',
        'nama_konselor',
        'agama_konselor',
        'alamat_konselor',
        'telepon_konselor',
    ];

    public function pengguna(){
        return $this->belongsTo(User::class, "pengguna_id");
    }
}
