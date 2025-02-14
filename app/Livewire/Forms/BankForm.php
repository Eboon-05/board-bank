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
        // dd($this->all());
        $this->validate();

        $game = Game::find($this->game_id);

        BankTransaction::create([
            'game_id' => $game->id,
            'player_id' => $game->userPlayer->id,
            'amount' => $this->amount,
            'type' => $this->type,
        ]);

        if ($this->type === BankMovementType::Withdraw->value) {
            $game->userPlayer->balance += $this->amount;
        } else {
            $game->userPlayer->balance -= $this->amount;
        }

        $game->userPlayer->save();

        return redirect()->route('games.show', $game);
    }
}
