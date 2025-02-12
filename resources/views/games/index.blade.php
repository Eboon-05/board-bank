<x-app-layout>
    <header class='p-4'>
        <h1 class='text-2xl font-bold'>
            Board bank
        </h1>
    </header>

    <form
        action="{{ route('games.join') }}"
        method='POST'
        class='mx-4 border-primary border-2 shadow-lg rounded-3xl overflow-hidden'
    >
        @csrf
        <div class='p-4 pb-0'>
            <label for='code'>Game code</label>

            <input
                type='text'
                name='code'
                class='mt-2 bg-gray-200 rounded-lg w-full border-0 outline-none focus:ring-2 focus:ring-gray-300'
            />
            @error('code')
                <p class='text-red-500'>{{ $message }}</p>
            @enderror
        </div>

        <div class='grid grid-rows-2 font-rubik  px-4 pt-4 gap-2'>
            <button
                type='submit'
                class='bg-primary text-white p-2'
            >
                Join
            </button>

            <p>
                You can also
                <a
                    href="{{ route('games.create') }}"
                    class='underline text-secondary'
                >
                    create a game
                </a>
            </p>
        </div>
    </form>

    <section class='p-4'>
        <h1 class='text-xl font-semibold mb-2'>
            Your games
        </h1>

        @foreach ($game_list as $game)
            {{ $game->code }}
        @endforeach
    </section>
</x-app-layout>
