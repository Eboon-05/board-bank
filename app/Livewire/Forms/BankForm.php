<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

use App\BankMovementType;
use App\Models\Game;
use App\Models\BankTransaction;

class BankForm extends Form
{
    #[Validate('required|numeric')]
    public $amount = '';

    #[Validate('required|integer')]
    public $type = '';

    #[Validate('required|integer')]
    public $game_id = '';

    public function store() {
        $this->validate();

        $game = Game::find($this->game_id);

        BankTransaction::create([
            'game_id' => $game->id,
            'player_id' => $game->userPlayer->id,
            'amount' => $this->amount,
            'type' => $this->type,
        ]);

        return redirect()->route('games.show', $game);
    }
}
