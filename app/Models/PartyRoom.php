<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartyRoom extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'id_game',
        'id_user',
    ];

    public function games()
    {
        return $this->belongsTo(Game::class, 'id_game');
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    public function messages()
    {
        return $this->hasMany(Message::class, 'id_party');
    }
};
