<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Game;
use App\Models\PlayerTransaction;
use App\Models\BankTransaction;

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

    public function game() {
        return $this->belongsTo(Game::class);
    }

    public function getMovements(int $limit = null) {
        $player = PlayerTransaction::where('from_player_id', $this->id)
            ->orWhere('to_player_id', $this->id)
            ->orderBy('created_at', 'desc')
            ->with('fromPlayer.user', 'toPlayer.user')
            ->limit($limit)
            ->get()
            ->toArray();

        $bank = BankTransaction::where('player_id', $this->id)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get()
            ->toArray();
            
        $result = array_merge($player, $bank);
        
        usort($result, function ($a, $b) {
            $a_date = date_create($a['created_at']);
            $b_date = date_create($b['created_at']);
            $diff = date_diff($a_date, $b_date);

            if ($diff->invert) {
                return -1;
            } else {
                return 1;
            }
        });

        return $result;
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
