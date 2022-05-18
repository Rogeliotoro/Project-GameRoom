<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
    protected $fillable = [ 
        'message',
        'user_id',
        'id_party',    
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function parties()
    {
        return $this->belongsTo(PartyRoom::class, 'id_party');
    }
}