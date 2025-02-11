<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

use App\Models\Game;
use App\Models\Player;

class GameCreateForm extends Form
{
    #[Validate('required|unique:App\Models\Game,code', as: 'game code')]
    public $code = '';

    #[Validate('required|numeric')]
    public $initial_balance = '';

    #[Validate('required')]
    public $user_id;

    public function store() {
        $this->validate();

        $game = Game::create($this->all());

        return $game;
    }
}
