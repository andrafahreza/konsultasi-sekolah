<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IsiChat extends Model
{
    use HasFactory;

    protected $table     = 'isi_chat';
    public $primaryKey   = 'id';
    protected $keyType   = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'chat_id',
        'pengguna_id',
        'isi_chat',
    ];

    public function chat(){
        return $this->belongsTo(Chat::class, "chat_id");
    }

    public function user(){
        return $this->belongsTo(User::class, "pengguna_id");
    }
}
