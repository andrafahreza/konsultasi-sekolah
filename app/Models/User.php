<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table = "pengguna";
    protected $fillable = [
        'username',
        'password',
        'status',
        'tipe',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    public function siswa(){
        return $this->hasOne(Siswa::class, "pengguna_id", "id");
    }

    public function konselor(){
        return $this->hasOne(Konselor::class, "pengguna_id", "id");
    }

    public function orangtua(){
        return $this->hasOne(OrangTua::class, "pengguna_id", "id");
    }

    public function kepala_sekolah(){
        return $this->hasOne(KepalaSekolah::class, "pengguna_id", "id");
    }
}
