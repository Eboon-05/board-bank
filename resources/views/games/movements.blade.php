<x-app-layout>
    <section class='p-4'>
        <div class='flex justify-between items-center'>
            <a href="{{ route('games.show', compact('game')) }}"
                class='block w-max cursor-pointer text-center bg-gray-200 hover:bg-gray-300 transition-colors mb-6 p-2 rounded-lg'>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
            </a>
            <h2 class='text-2xl font-semibold mb-4'>Movements</h2>
        </div>

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
