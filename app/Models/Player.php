<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class Player extends Model
{
    protected $fillable = [
        'game_id',
        'user_id',
        'balance'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
