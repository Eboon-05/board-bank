<?php

use function Livewire\Volt\{state, form, mount, computed};

use App\BankMovementType;
use App\Livewire\Forms\PlayerTransactionForm;

state(['game_id', 'players', 'dropdown' => false]);
form(PlayerTransactionForm::class);

mount(function () {
    $this->form->game_id = $this->game_id;
    $this->form->to_player_id = $this->players->first()->id;
});

$to = computed(function () {
    return $this->players->find($this->form->to_player_id);
});

$save = function () {
    $this->form->store();

    return $this->redirectRoute('games.show', ['game' => $this->game_id]);
};

$toggle_dropdown = fn() => ($this->dropdown = !$this->dropdown);

$select_player = function ($id) {
    $this->form->to_player_id = $this->players->find($id)->id;
};

?>

<div>
    <h1 class='text-xl font-semibold mb-4'>
        Send money to another player
    </h1>
    <form wire:submit='save'>
        @csrf
        <div wire:click="toggle_dropdown"
            class='p-2 bg-gray-200 rounded-t-lg w-full flex justify-between items-center relative @if (!$dropdown) rounded-b-lg @endif'>
            <span>
                {{ $this->to->user->name }}
            </span>
            <div>
                V
            </div>

            @if ($dropdown)
                <ul
                    class='absolute top-[100%] bg-gray-200 shadow-xl inset-x-0 rounded-b-lg border-t-2 border-gray-300 overflow-hidden'>
                    @foreach ($players as $player)
                        <li class='p-2 hover:bg-gray-300' wire:click="select_player({{ $player->id }})">
                            {{ $player->user->name }}
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>


        <br />

        <label for='amount'>Amount</label>

        <input type='number' wire:model='form.amount' name='amount'
            class='mt-2 bg-gray-200 rounded-lg w-full border-0 outline-none focus:ring-2 focus:ring-gray-300' />

        @error('form.amount')
            <p class='text-red-600 text-sm'>
                {{ $message }}
            </p>
        @enderror

        <button type='submit' class='mt-4 bg-primary text-white w-full'>
            Send
        </button>
    </form>
</div>
