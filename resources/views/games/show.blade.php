<x-app-layout>
    <header class='p-4 flex justify-between items-center'>
        <div>
            <p class='text-gray-400'>Game code:</p>
            <h1 class='text-2xl font-semibold'>{{ $game->code }}</h1>
        </div>
        <a 
            class='block w-max cursor-pointer text-center bg-gray-200 hover:bg-gray-300 transition-colors p-2 rounded-lg'>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-8">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
            </svg>

        </a>
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
        <a href="{{ route('games.movements', compact('game')) }}"
            class='flex justify-center cursor-pointer text-center bg-gray-200 hover:bg-gray-300 transition-colors mb-6 p-2 rounded-lg'>
            See all
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 ml-2">
  <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
</svg>

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
