<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Party extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'game_id',
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
        return $this->hasMany(Message::class, 'party_id');
    }
};
