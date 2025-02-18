<x-app-layout>
    <section class='p-4'>
        <h2 class='text-2xl font-semibold mb-4'>Movements</h2>

        @livewire('games.forms.movements_player', ['players' => $game->players, 'game_id' => $game->id, 'player' => $player])

        <p class='text-center mt-2'>This player has:</p>
        <p class='text-center font-geo text-5xl'>
            $ {{ $player->balance }}
        </p>

        <ul class='max-w-sm mx-auto mt-4'>
            @foreach ($player->getMovements() as $mov)
                @if (array_key_exists('type', $mov))
                    {{-- Bank movement --}}
                    @include('games._bank_movement')
                @else
                    {{-- Player movement --}}
                    @include('games._player_movement')
                @endif
                <hr class='my-4' />
            @endforeach
        </ul>
    </section>
</x-app-layout>
