<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Player;

class Game extends Model
{
    protected $fillable = [
        'code'
    ];

    public function players() {
        return $this->hasMany(Player::class);
    }
}
