<x-app-layout>
    <form class='mx-4 border-primary border-2 shadow-lg rounded-3xl overflow-hidden'>
        @csrf
        <div class='p-4 pb-0'>
            <label for='code'>Code</label>

            <input
                type='text'
                name='code'
                class='mt-2 bg-gray-200 rounded-md p-2 w-full border-0 outline-none focus:ring-2 focus:ring-secondary'
            />
        </div>

        <div class='grid grid-cols-2 font-rubik'>
            <button
                class='mt-4 bg-primary text-white p-2'
            >
                Create
            </button>

            <button
                type='submit'
                class='mt-4 bg-light-gray p-2'
            >
                Join
            </button>
        </div>
    </form>
</x-app-layout>
