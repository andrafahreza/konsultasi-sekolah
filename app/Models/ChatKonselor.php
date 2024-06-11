<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatKonselor extends Model
{
    use HasFactory;

    protected $table    = 'chat_konselor';
    public $primaryKey   = 'id';
    protected $keyType   = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'orangtua_id',
        'konselor_id',
    ];

    public function orangtua(){
        return $this->belongsTo(User::class, "orangtua_id");
    }

    public function konselor(){
        return $this->belongsTo(User::class, "konselor_id");
    }
}
