<?php

namespace App\Livewire\Forms;

use App\Models\Game;
use Livewire\Attributes\Validate;
use Livewire\Form;

use App\Models\Player;
use App\Models\PlayerTransaction;

class PlayerTransactionForm extends Form
{
    #[Validate('required|integer')]
    public $from_player_id = '';

    #[Validate('required|integer')]
    public $to_player_id = '';
    
    #[Validate('required|numeric')]
    public $amount = '';

    #[Validate('required|integer')]
    public $game_id = '';

    public function store() {
        $this->validate();

        $game = Game::find($this->game_id);

        $to = Player::find($this->to_player_id);
        $to->balance += $this->amount;
        $to->save();

        $game->userPlayer->balance -= $this->amount;
        $game->userPlayer->save();

        PlayerTransaction::create([
            'game_id' => $game->id,
            'from_player_id' => $game->userPlayer->id,
            'to_player_id' => $to->id,
            'amount' => $this->amount,
        ]);
    }
}
