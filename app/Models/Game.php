<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

use App\Models\Player;

class Game extends Model
{
    protected $fillable = [
        'code',
        'initial_balance'
    ];

    /**
     * Get all the players that joined the game
     */
    public function players() {
        return $this->hasMany(Player::class);
    }

    /**
     * Get the player from the logged in user in
     * the game
     */
    public function userPlayer() {
        return $this->hasOne(Player::class)->where([
            'game_id' => $this->id,
            'user_id' => Auth::id(),
        ]);
    }
}
