<?php

use function Livewire\Volt\{layout, form, mount};
use Illuminate\Support\Facades\Auth;

use App\Livewire\Forms\GameCreateForm;

layout('layouts.app');
form(GameCreateForm::class);

mount(function () {
    $this->form->user_id = Auth::id();
});

$save = function () {
    $game = $this->form->store();

    return $this->redirectRoute('games.show', ['game' => $game]);
}

?>

<form wire:submit='save' class='p-6'>
    @csrf
    <label for='code'>Game code</label>
    <p class='text-sm text-gray-600'>
        The code players will use to join the game.
    </p>

    <input
        type='text'
        wire:model='form.code'
        class='my-2 bg-gray-200 rounded-lg w-full border-0 outline-none focus:ring-2 focus:ring-gray-300'
    />
    @error('form.code')
        <p class='text-red-600 text-sm'>
            {{ $message }}
        </p>
    @enderror

    <label for='initial_balance'>Initial balance</label>
    <p class='text-sm text-gray-600'>
        The money players will have at the beginning of the game.
    </p>

    <input
        type='number'
        wire:model='form.initial_balance'
        class='mt-2 bg-gray-200 rounded-lg w-full border-0 outline-none focus:ring-2 focus:ring-gray-300'
    />
    @error('form.initial_balance')
        <p class='text-red-600 text-sm'>
            {{ $message }}
        </p>
    @enderror

    <button
        type='submit'
        class='mt-4 bg-primary text-white w-full'
    >
        Create
    </button>
</form>