<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IsiChatKonselor extends Model
{
    use HasFactory;

    protected $table    = 'isi_chat_konselor';
    public $primaryKey   = 'id';
    protected $keyType   = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'chat_konselor_id',
        'pengguna_id',
        'isi_chat'
    ];

    public function chat_konselor(){
        return $this->belongsTo(ChatKonselor::class, "chat_konselor_id");
    }

    public function pengguna(){
        return $this->belongsTo(User::class, "pengguna_id");
    }
}
