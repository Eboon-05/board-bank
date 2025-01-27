<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Player;
use App\BankMovementType;

class BankTransaction extends Model
{
    protected $fillable = [
        'game_id',
        'player_id',
        'amount',
        'type',
    ];

    protected function casts(): array
    {
        return [
            'type' => BankMovementType::class,
        ];
    }

    public function player()
    {
        return $this->belongsTo(Player::class);
    }
}
