<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\Player;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'initial_balance',
        'user_id'
    ];

    protected $dispatchesEvents = [
        'created' => \App\Events\GameCreated::class,
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

    public function player(User $user) {
        return $this->hasOne(Player::class)->where([
            'game_id' => $this->id,
            'user_id' => $user->id,
        ]);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
