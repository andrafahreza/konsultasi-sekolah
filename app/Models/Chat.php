<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $table     = 'chat';
    public $primaryKey   = 'id';
    protected $keyType   = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'manajemen_data_bk_id',
        'status_chat',
    ];

    public function manajemen_bk(){
        return $this->belongsTo(ManajemenDataBk::class, "manajemen_data_bk_id");
    }
}
