<x-app-layout>
    <header class='p-4 flex justify-between items-center'>
        <div>
            <p class='text-gray-400'>Game code:</p>
            <h1 class='text-2xl font-semibold'>{{ $game->code }}</h1>
        </div>
        <a>Settings</a>
    </header>

    <section class='p-4'>
        <div class='bg-gradient text-white shadow-2xl p-4 sm:px-12 rounded-xl'>
            <h2 class='text-2xl font-medium'>Balance</h2>
            <p class='text-6xl my-4 font-geo'>
                $ {{ $game->userPlayer->balance }}
            </p>
            <nav class='grid grid-cols-3 max-w-sm mx-auto'>
                @foreach ($links as $link)
                    <a href="{{ $link['url'] }}" class='flex flex-col justify-center items-center'>
                        <div
                            class='flex justify-center items-center bg-white text-black bg-opacity-20 rounded-full w-min p-[12px]'>
                            <div class='bg-white w-12 h-12 rounded-full flex justify-center items-center'>
                                <div class='w-2/3'>
                                    {!! $link['icon'] !!}
                                </div>
                            </div>
                        </div>
                        <p class='text-center mt-2'>{{ $link['name'] }}</p>
                    </a> 
                @endforeach
            </nav>
        </div>

        <h2 class='text-2xl font-semibold mt-8 mb-2'>Movements</h2>
        <a class='block text-center bg-gray-200 hover:bg-gray-300 transition-colors mb-6 p-2 rounded-lg'>
            See all
        </a>

        <ul class='max-w-sm mx-auto'>
            @foreach ($player_movements as $mov)
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
