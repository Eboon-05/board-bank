<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public function getMovements() {
        $player = DB::table('player_transactions')
            ->where('from_player_id', $this->id)
            ->orWhere('to_player_id', $this->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $bank = DB::table('bank_transactions')
            ->where('player_id', $this->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return $player->merge($bank)->sortByDesc('created_at');
    }

    public function bankTransactions() {
        return $this->hasMany(BankTransaction::class);
    }

    public function getPlayerTransactions() {
        return DB::table('player_transactions')
            ->where('from_player_id', $this->id)
            ->orWhere('to_player_id', $this->id)
            ->get();
    }
}
