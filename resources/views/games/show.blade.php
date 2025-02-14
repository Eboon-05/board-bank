<x-app-layout>
    <header class='p-4 flex justify-between items-center'>
        <div>
            <p class='text-gray-400'>Game code:</p>
            <h1 class='text-2xl font-semibold'>{{ $game->code }}</h1>
        </div>
        <a>Settings</a>
    </header>

    <section class='p-4'>
        <div class='bg-gradient text-white shadow-2xl p-4 rounded-xl'>
            <h2 class='text-2xl font-medium'>Balance</h2>
            <p class='text-6xl my-4 font-geo'>
                $ {{ $game->userPlayer->balance }}
            </p>
            <nav class='grid grid-cols-3'>
                @foreach ($links as $link)
                    <a href="{{ $link['url'] }}" class='flex flex-col justify-center items-center'>
                        <div
                            class='flex justify-center items-center bg-white text-black bg-opacity-20 rounded-full w-min p-[12px]'>
                            <div class='bg-white w-12 h-12 rounded-full flex justify-center items-center'>
                                {!! $link['icon'] !!}
                            </div>
                        </div>
                        <p class='text-center mt-2'>{{ $link['name'] }}</p>
                    </a> 
                @endforeach
            </nav>
        </div>


        <h2 class='text-xl mt-8 font-semibold'>Movements</h2>

        @foreach ($player_movements as $mov)
            {{ $mov->amount }}

            @if (empty($mov->type))
                {{-- Player transaction --}}
            @else
                {{-- Bank Transaction --}}
            @endif            
        @endforeach
    </section>
</x-app-layout>
