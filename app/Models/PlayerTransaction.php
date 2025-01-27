<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlayerTransaction extends Model
{
    protected $fillable = [
        'game_id',
        'from_player_id',
        'to_player_id',
        'amount'
    ];

    public function fromPlayer() {
        return $this->belongsTo(Player::class, 'from_player_id');
    }

    public function toPlayer() {
        return $this->belongsTo(Player::class, 'to_player_id');
    }
}
