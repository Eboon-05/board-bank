<x-layouts.game :game="$game">
    <header class='p-4'>
        @if (empty($type))
            @livewire('games.forms.player', ['players' => $players, 'game_id' => $game_id])
        @else
            @livewire('games.forms.bank', ['type' => $type, 'game_id' => $game_id])
        @endif
    </header>
</x-layouts.game>
