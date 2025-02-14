<?php

use function Livewire\Volt\{state, form, mount};

use App\BankMovementType;
use App\Livewire\Forms\PlayerTransactionForm;

state(['game_id', 'players']);
form(PlayerTransactionForm::class);

mount(function () {
    $this->form->game_id = $this->game_id;
});

$save = function () {
    $this->form->store();

    return $this->redirectRoute('games.show', ['game' => $this->game_id]);
};

?>

<div>
    <h1 class='text-xl font-semibold mb-4'>
        Send money to another player
    </h1>
    <form wire:submit='save'>
        @csrf

        <ul>
            @foreach ($players as $player)
                <li>
                    <input type='radio' >
                        {{ $player->user->name }}
                    </input>
                </li>
            @endforeach
        </ul>

        <div class='p-2 bg-gray-200 rounded-lg w-full'>
            {{ $form->to_player_id || 'Select a player...' }}
        </div>


        <br />

        <label for='initial_balance'>Amount</label>

        <input type='number' wire:model='form.amount'
            class='mt-2 bg-gray-200 rounded-lg w-full border-0 outline-none focus:ring-2 focus:ring-gray-300' />
        
        @error('form.initial_balance')
            <p class='text-red-600 text-sm'>
                {{ $message }}
            </p>
        @enderror

        <button type='submit' class='mt-4 bg-primary text-white w-full'>
            Send
        </button>
    </form>
</div>
