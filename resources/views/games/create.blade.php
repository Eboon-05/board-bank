<x-app-layout>
    <form action="{{ route('games.store') }}" method='POST' class='px-6'>
        @csrf
        <label for='code'>Code</label>
        <p class='text-sm text-gray-600'>
            The code players will use to join the game.
        </p>

        <input
            type='text'
            name='code'
            class='my-2 bg-gray-200 rounded-lg w-full border-0 outline-none focus:ring-2 focus:ring-gray-300'
        />
        @error('code')
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
            name='initial_balance'
            class='mt-2 bg-gray-200 rounded-lg w-full border-0 outline-none focus:ring-2 focus:ring-gray-300'
        />
        @error('initial_balance')
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
</x-app-layout>