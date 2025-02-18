<?php

use function Livewire\Volt\{state, form, mount, computed};

state(['game_id', 'players', 'dropdown' => false, 'player']);

$toggle_dropdown = fn() => ($this->dropdown = !$this->dropdown);

$select_player = function ($id) {
    return $this->redirectRoute('games.movements', ['game' => $this->game_id, 'player' => $id]);
};

?>

<div wire:click="toggle_dropdown"
    class='py-2 px-4 bg-gray-200 rounded-t-lg max-w-[240px] mx-auto flex justify-between items-center relative @if (!$dropdown) rounded-b-lg @endif'>
    <span>
        {{ $player->user->name }}
    </span>
    <div>
        V
    </div>

    @if ($dropdown)
        <ul
            class='absolute top-[100%] z-40 bg-gray-200 shadow-xl inset-x-0 rounded-b-lg border-t-2 border-gray-300 overflow-hidden'>
            @foreach ($players as $player)
                <li class='p-2 hover:bg-gray-300' wire:click="select_player({{ $player->id }})">
                    {{ $player->user->name }}
                </li>
            @endforeach
        </ul>
    @endif
</div>
