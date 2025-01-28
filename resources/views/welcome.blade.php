<x-guest-layout>
    <h1 class='text-2xl font-bold'>
        Board Bank
    </h1>
    <p class='mb-4'>
        A simulated bank for your board games.
    </p>

    <a href="{{ route('register') }}" class='block bg-primary hover:bg-primary-dark text-center text-white p-2 rounded-md mt-2'>
        Register
    </a>

    <a href="{{ route('login') }}" class='block bg-gray-200 hover:bg-gray-300 text-center  p-2 rounded-md mt-2'>
        Login
    </a>
</x-guest-layout>
