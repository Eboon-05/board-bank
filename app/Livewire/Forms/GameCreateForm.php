<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;
use Illuminate\Support\Facades\Auth;

use App\Models\Game;
use App\Models\Player;

class GameCreateForm extends Form
{
    #[Validate('required|unique:App\Models\Game,code', as: 'game code')]
    public $code = '';

    #[Validate('required')]
    public $initial_balance = '';

    public function store() {
        $this->validate();

        $game = Game::create($this->all());

        Player::create([
            'game_id' => $game->id,
            'user_id' => Auth::id(),
            'balance' => $this->initial_balance,
        ]);

        return redirect()->route('games.show', $game);
    }
}
